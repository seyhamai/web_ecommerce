<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\CanExportCSV;

class UserController extends Controller
{
    use CanExportCSV;
    private function applyUserFilters(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // Fixed to 'full_name' to match your working index method
                $q->where('full_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $users = $this->applyUserFilters($request)->latest()->get();
        $disabledUsers = User::onlyTrashed()->with('role')->latest()->get();


        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'disabledUsers'));
    }

    public function exportUsers(Request $request) // Added missing Request parameter!
    {
        // Call the exact same helper function, then extract the cursor
        $users = $this->applyUserFilters($request)->cursor();

        $columns = ['No.', 'Name', 'Email', 'UserType', 'Created At'];
        $counter = 1;

        return $this->streamCSV('users_list', $columns, $users, function ($user) use (&$counter) {
            return [
                $counter++,
                $user->full_name,
                $user->email,
                $user->role->name ?? 'N/A',
                $user->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'public_id' => Str::ulid(),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        /** @var \Illuminate\Database\Eloquent\Model $user */
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }
}
