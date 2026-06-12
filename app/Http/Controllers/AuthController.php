<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * 1. LOGIN LOGIC
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);

            // Safely check the role by its name, not a hardcoded integer
            if (Auth::user()->role->name === 'Admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('store.index');
        }

        RateLimiter::hit($throttleKey, 900);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * 2. REGISTER LOGIC
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Find the exact ID for the 'Customer' role dynamically
       $customerRole = Role::query()->where('name', 'Customer')->first();

        // Safety fallback in case the database hasn't been seeded yet
        if (!$customerRole) {
            throw ValidationException::withMessages([
                'email' => 'System error: Customer role not found. Please run database seeders.',
            ]);
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $customerRole->id, 
        ]);

        Auth::login($user);

        return redirect()->route('store.index')->with('success', 'Welcome to our Store!');
    }

    /**
     * 3. FORGOT PASSWORD
     */
    public function showForgot()
    {
        return view('auth.forgot-password');
    }
    /**
     * Send the password reset link to the user's email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        // Laravel's built-in broker handles generating the token and sending the email!
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the final Reset Password form (after they click the email link).
     */
    public function showReset(Request $request,string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Save the new password securely to the database.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // The broker verifies the token, and if valid, runs the closure function
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Force update the password, clear the remember token, and save
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Fire an event (good practice) and log the user in instantly
                event(new PasswordReset($user));
                Auth::login($user);
            }
        );

        // If successful, redirect to the store. If failed, send them back with an error.
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('store.index')->with('success', 'Your password has been reset!');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * 4. LOGOUT LOGIC
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
    }
}