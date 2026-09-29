@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Replaced raw HTML headers with your Page Header Component -->
    <x-page-header
        title="Add New User"
        breadcrumb="Users"
        breadcrumb-url="{{ route('admin.users') }}"
    />

    <!-- Global alerts (if any) -->
    <x-_alerts />

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <!-- 1. Text Input Component -->
                <x-input name="full_name" label="Full Name" required />

                <!-- 2. Email Input Component -->
                <x-input type="email" name="email" label="Email" autocomplete="new-off" required />

                <!-- 3. Password Input Component -->
                <x-input type="password" name="password" label="Password" autocomplete="new-password" required />

                <!-- 4. Select Dropdown Component -->
                <x-select name="role_id" label="User Type" required>
                    <option value="" disabled selected>Select a role...</option>
                    @foreach($roles as $role)
                        <!-- Added old() check so it remembers their choice if validation fails -->
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-select>

                <div class="mt-4 pt-2 border-top">
                    <x-button type="submit" color="success" size="md">
                        Create User
                    </x-button>
                    <x-button href="{{ route('admin.users') }}" color="secondary" size="md" class="w-90">
                        Cancel
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection