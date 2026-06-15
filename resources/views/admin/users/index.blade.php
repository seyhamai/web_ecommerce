@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-1 font-semibold fs-2">Manage Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4 mx-0">
        <div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <i class="fas fa-users me-1"></i>
        Registered Customers & Admins
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('exportUsers', request()->query()) }}" class="btn btn-sm btn-outline-primary">
    <i class="fas fa-file-csv"></i> Export File
</a>

        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Add New User
        </a>
    </div>
</div>
        <div class="card-body">
            
            <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
        
        <div class="input-group w-auto flex-grow-1" style="max-width: 600px;">
            <input type="text" 
       name="search" 
       class="form-control" 
       placeholder="Search by name or email..." 
       value="{{ request('search') }}"
       oninput="liveSearch(this)">
            
            <button type="submit" class="btn btn-primary rounded-end">
                <i class="fas fa-search"></i> Filter
            </button>
            
            <a href="{{ route('admin.users') }}" class="btn btn-secondary mx-1 rounded-2 ">
                Clear
            </a>
        </div>

        <div class="w-auto" style="min-width: 200px;">
            <select name="role_id" class="form-select" onchange="this.form.submit()">
                <option value="">All User</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
    </div>
</form>

            <table class="table table-bordered table-striped table-hover">
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
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No users found matching your search.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
    let searchTimeout = null;

    function liveSearch(inputElement) {
        // Clear the previous timer if the user is still typing
        clearTimeout(searchTimeout);

        // Wait 500 milliseconds (half a second) after they stop typing, then submit!
        searchTimeout = setTimeout(function() {
            inputElement.form.submit();
        }, 500);
    }
</script>
@endsection