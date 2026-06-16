@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <h1 class="mt-4 font-semibold fs-2">Manage Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 py-1">
            
            <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3"> 
                <div class="fw-bold fs-5">
                    <i class="fas fa-users me-1"></i>
                    Registered Customers & Admins
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger h-75 w-100 w-sm-auto " data-bs-toggle="modal" data-bs-target="#disabledUsersModal">
                    <i class="fas fa-trash"></i> Inactive Bin
                </button>
            </div> 

            <div class="d-flex flex-column flex-sm-row gap-2">
                <a href="{{ route('exportUsers', request()->query()) }}" class="btn btn-sm btn-outline-primary w-100 w-sm-auto text-center">
                    <i class="fas fa-file-csv"></i> Export File
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success w-100 w-sm-auto">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            </div>
            
        </div>

        <div class="card-body px-1">
            
            <form action="{{ route('admin.users') }}" method="GET" class="mb-2">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                    
                    <div class="input-group w-auto flex-grow-1" style="max-width: 600px;">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}" oninput="liveSearch(this)">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            Clear
                        </a>
                    </div>

                    <div class="w-auto" style="min-width: 200px;">
                        <select name="id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Users</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->public_id }}" {{ request('public_id') == $role->public_id ? 'selected' : '' }}>
                                    {{ $role->name }}   
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
            </form>

            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Joined Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ optional($user->role)->name === 'Admin' ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ optional($user->role)->name ?? 'User' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->public_id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userid="{{ $user->public_id }}">
                                    Disable
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No users found matching your search.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deactivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to disable this user account? They will be moved to the Inactive Bin.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Disable User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="disabledUsersModal" tabindex="-1" aria-labelledby="disabledUsersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="margin-left: auto; margin-top: 5vh; margin-right: 3vw;">
        <div class="modal-content shadow-lg border-0">
            
            <div class="modal-header bg-light">
                <h5 class="modal-title text-danger fw-bold" id="disabledUsersModalLabel">
                    <i class="fas fa-user-slash me-2"></i> Disabled Accounts
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Name</th>
                                <th>Email</th>
                                <th>Disabled Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($disabledUsers as $disabled)
                                <tr>
                                    <td class="ps-3">{{ $disabled->full_name }}</td>
                                    <td>{{ $disabled->email }}</td>
                                    <td>{{ $disabled->deleted_at->format('Y-m-d H:i') }}</td>
                                    <td class="pe-3">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <form action="{{ route('admin.users.restore', $disabled->public_id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to restore this user?')">
                                                    <i class="fas fa-undo"></i> Restore
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.forceDelete', $disabled->public_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('WARNING: This will permanently delete the user. Continue?')">
                                                    <i class="fas fa-times"></i> Delete Forever
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox mb-2 text-secondary" style="font-size: 32px;"></i>
                                        <p class="mb-0 mt-2">No disabled users found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dynamic form action for the standard delete modal
        var deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var userId = button.getAttribute('data-userid');
                var form = document.getElementById('deleteForm');
                form.action = '/admin/users/' + userId;
            });
        }
    });

    // Debounce function for Search-as-you-type
    let searchTimeout = null;
    function liveSearch(inputElement) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            inputElement.form.submit();
        }, 500);
    }
</script>
@endsection