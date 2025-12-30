@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Users</h1>
    <a href="{{ url('/admin/users/create') }}" class="btn btn-primary">+ Create User</a>
</div>
<!-- User Search & Filter -->
<form method="GET" action="" class="mb-4">
    <div class="row align-items-end">
        <div class="col-md-3">
            <label for="search">Search</label>
            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Name, Email, Phone">
        </div>
        <div class="col-md-3">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="">All</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100 mt-4"><i class="fas fa-search mr-1"></i> Filter</button>
        </div>
    </div>
</form>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @if($user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $user->role ?? '')) }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                @if($user->active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                                <form action="{{ route('users.toggle', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning mt-1">{{ $user->active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                            </td>
                            <td>
                                <!-- Edit/Delete buttons will go here -->
                                <a href="{{ url('/admin/users/' . $user->id) }}" class="btn btn-sm btn-secondary">View</a>
                                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-info">Edit</a>
                                @if(($user->role ?? '') !== 'super_admin')
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
