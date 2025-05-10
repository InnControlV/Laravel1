@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">User Listing</h2>
    
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
      <i class="bi bi-plus-lg me-1"></i> Add User
    </button>
  </div>

  <hr>

  <!-- User Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Registered On</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; ?>
        @foreach ($users as $user)
        <?php

        $i++;
        
        ?>
          <tr>
            <td>{{ $i }}</td>
            <td>Sample</td>
            <td>{{ $user['email'] }}</td>
            <td>----</td>
            <td>
              <button class="btn btn-sm btn-primary">View</button>
              <button class="btn btn-sm btn-danger">Delete</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <div class="d-flex justify-content-center">
    {{ $users->links() }}
  </div>

  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="userName" class="form-label">Name</label>
            <input type="text" class="form-control" id="userName" required />
          </div>
          <div class="mb-3">
            <label for="userEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="userEmail" required />
          </div>
          <div class="mb-3">
            <label for="userPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="userPassword" required />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
    <!-- Optional: list users here -->
@endsection