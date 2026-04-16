@extends('layouts.admin_layout') 
@section('page-title', 'Clients')
@section('content')
@include('sweetalert::alert')
<div class="table-container">
    <h3>All Clients</h3>
    <div style="margin-bottom:15px;">
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">Add New Client</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Bookings</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->bookings_count }}</td>
                <td>
                    @if($client->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.clients.show', $client->phone) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('admin.clients.edit', $client->phone) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.clients.delete', $client->phone) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this client?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
</div>

@endsection