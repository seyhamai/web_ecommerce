@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <x-page-header
        title="Manage Users"
        breadcrumb="Users"
        breadcrumb-url="/admin/dashboard"
    />

    <x-_alerts />

    <div class="card mb-4 border-0 shadow-sm">
        
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 py-3 border-bottom">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3"> 
                <div class="fw-bold fs-5">
                    <i class="fas fa-users me-2 text-primary"></i>
                    Registered Customers & Admins
                </div>
                <x-button 
                    type="button" 
                    color="danger" 
                    outline 
                    icon="fas fa-trash-alt" 
                    class="h-75 w-100 w-sm-auto" 
                    data-bs-toggle="modal" 
                    data-bs-target="#disabledUsersModal"
                >
                    Inactive Bin
                </x-button>
            </div> 

           <div class="d-flex flex-column flex-sm-row gap-2">
                <!-- Export File Button -->
                <x-button 
                    href="{{ route('admin.users.export', request()->query()) }}" 
                    color="success" 
                    outline 
                    size="sm" 
                    icon="fas fa-file-csv" 
                    class="w-100 w-sm-auto text-center"
                >
                    Export File
                </x-button>

                <!-- Add New User Button -->
                <x-button 
                    href="{{ route('admin.users.create') }}" 
                    color="blue" 
                    size="sm" 
                    icon="fas fa-plus" 
                    class="w-100 w-sm-auto"
                >
                    Add New User
                </x-button>
            </div>
        </div>

        <div class="card-body px-0 m-0">
            
            <!-- Filters Section -->
            <div class="px-3 mb-3">
                <form action="{{ route('admin.users') }}" method="GET" class="mb-2">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                        
                        <div class="input-group w-auto flex-grow-1 shadow-sm" style="max-width: 650px;">
                            <x-input name="search" class="auto-submit border-secondary mr-2" placeholder="Search by name or email..." value="{{ request('search') }}" :no-wrapper="true" />
                            
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary fw-bold">
                                Clear
                            </a>
                        </div>

                        <div class="w-auto shadow-sm" style="min-width: 200px;">
                            <x-select name="id" class="auto-submit border-secondary" :no-wrapper="true">
                                <option value="">All Users</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->public_id }}" {{ request('public_id') == $role->public_id ? 'selected' : '' }}>
                                        {{ $role->name }}   
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 🌟 Main Users Table Component 🌟 -->
            <x-table :headers="['No.', 'Name', 'Email', 'User Type', 'Joined Date', 'Action']">
                @forelse($users as $user)
                <tr>
                    <td class="fw-bold text-muted ps-4">{{ $loop->iteration }}</td>
                    <td class="fw-semibold text-dark">{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ optional($user->role)->name === 'Admin' ? 'bg-danger bg-opacity-10 text-danger border border-danger-subtle' : 'bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle' }}">
                            {{ optional($user->role)->name ?? 'User' }}
                        </span>
                    </td>
                    <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="pe-4">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user->public_id) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-sm btn-outline-danger shadow-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-action-url="{{ route('admin.users.destroy', $user->public_id) }}"
                                    title="Disable User">
                                <i class="fas fa-user-slash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users text-secondary opacity-25 mb-3" style="font-size: 32px;"></i>
                        <h5 class="fw-bold text-dark">No users found</h5>
                        <p class="mb-0">No users match your current search filters.</p>
                    </td>
                </tr>
                @endforelse
            </x-table>
        </div>
    </div>
</div>

<!-- 🌟 Deactivation Modal Component 🌟 -->
<x-modal 
    id="deleteModal" 
    title="Confirm Deactivation" 
    form-action="#" 
    form-method="DELETE" 
    submit-text="Yes, Disable User" 
    submit-color="danger"
>
    <p class="mb-0">Are you sure you want to disable this user account? They will be moved to the Inactive Bin.</p>
</x-modal>


<!-- Disabled Users Modal (Manual HTML to retain modal-xl width) -->
<div class="modal fade" id="disabledUsersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="margin-left: auto; margin-top: 5vh; margin-right: 3vw;">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-danger fw-bold">
                    <i class="fas fa-user-slash me-2"></i> Disabled Accounts
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                
                <!-- 🌟 Secondary Table Component 🌟 -->
                <x-table :headers="['Name', 'Email', 'Disabled Date', 'Actions']">
                    @forelse($disabledUsers as $disabled)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $disabled->full_name }}</td>
                            <td>{{ $disabled->email }}</td>
                            <td class="text-muted">{{ $disabled->deleted_at->format('Y-m-d H:i') }}</td>
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <form action="{{ route('admin.users.restore', $disabled->public_id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success shadow-sm" onclick="return confirm('Are you sure you want to restore this user?')">
                                            <i class="fas fa-undo me-1"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.forceDelete', $disabled->public_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('WARNING: This will permanently delete the user. Continue?')">
                                            <i class="fas fa-times me-1"></i> Delete Forever
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="fas fa-inbox mb-3 text-secondary opacity-25" style="font-size: 32px;"></i>
                                <h6 class="fw-bold text-dark">No disabled users found.</h6>
                            </td>
                        </tr>
                    @endforelse
                </x-table>

            </div>
        </div>
    </div>
</div>
@endsection