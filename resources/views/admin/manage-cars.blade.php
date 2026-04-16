@extends('layouts.index_layout')
@section('content')

<div class="admin-header">
    <h1>Manage Cars</h1>
    <a href="{{ route('admin.cars.create') }}" class="btn-add">+ Add New Car</a>
</div>

@if(session('success'))
    <p class="success">{{ session('success') }}</p>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Transmission</th>
            <th>Seats</th>
            <th>Type</th>
            <th>Price / Day</th>
            <th>Driver</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($cars as $car)
        <tr>
            <td>{{ $car->id }}</td>
            <td><img src="{{ asset('storage/'.$car->image) }}" width="80"></td>
            <td>{{ $car->name }}</td>
            <td>{{ $car->transmission }}</td>
            <td>{{ $car->seats }}</td>
            <td>{{ $car->type }}</td>
            <td>₦{{ number_format($car->price_per_day) }}</td>
            <td>{{ $car->with_driver ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('admin.cars.edit', $car) }}" class="btn-edit">Edit</a>
                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr><td colspan="9">No cars available.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection

<style>
.admin-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:20px;
}
.admin-header h1 { color: var(--primary); }
.btn-add {
    background: var(--primary);
    color:#fff;
    padding:8px 15px;
    border-radius:6px;
    text-decoration:none;
}
.btn-add:hover { background: var(--secondary); }

.admin-table {
    width:95%;
    margin:20px auto;
    border-collapse: collapse;
}
.admin-table th, .admin-table td {
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}
.admin-table th {
    background: var(--primary);
    color:#fff;
}
.btn-edit {
    background: #17a2b8;
    color:#fff;
    padding:5px 10px;
    border-radius:4px;
    text-decoration:none;
}
.btn-edit:hover { background: #138496; }
.btn-delete {
    background: #dc3545;
    color:#fff;
    padding:5px 10px;
    border-radius:4px;
    border:none;
    cursor:pointer;
}
.btn-delete:hover { background:#c82333; }
.success { color:green; text-align:center; margin:10px 0; }
</style>
