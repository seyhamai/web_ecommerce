@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Replaced raw HTML header with Page Header Component -->
    <x-page-header
        title="Edit User"
        breadcrumb="Users"
        breadcrumb-url="{{ route('admin.users') }}"
    />

    <!-- Reusable Alerts Component -->
    <x-_alerts />

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.update', $user->public_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Full Name Input -->
                <x-input name="full_name" label="Full Name" value="{{ $user->full_name }}" required />

                <!-- Email Input -->
                <x-input type="email" name="email" label="Email" value="{{ $user->email }}" autocomplete="off" required />

                <!-- Role Select Dropdown -->
                <x-select name="role_id" label="Role" required>
                    <option value="" disabled>Select a role...</option>
                    @foreach($roles as $role)
                        <!-- Uses old() fallback with the user's current role ID -->
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-select>

                <div class="mt-4 pt-2 border-top">
                    <x-button type="submit" color="success" size="md">
                        Update User
                    </x-button>
                    <x-button href="{{ route('admin.users') }}" color="secondary" size="md" class="px-4 ms-2">
                        Cancel
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection