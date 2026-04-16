@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="container-fluid">

<h3 class="mb-4">Car Management</h3>

<a href="{{ route('admin.cars.create') }}" class="btn btn-primary mb-3">
Add New Car
</a>

<div class="card shadow-sm">
<div class="table-responsive">

<table class="table table-hover">

<thead>
<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Type</th>
<th>Transmission</th>
<th>Seats</th>
<th>Price</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($cars as $car)

<tr>

<td>{{ $car->id }}</td>

<td>
<img src="{{ asset('storage/'.$car->image) }}" width="70">
</td>

<td>{{ $car->name }}</td>

<td>{{ $car->type }}</td>

<td>{{ $car->transmission }}</td>

<td>{{ $car->seats }}</td>

<td>₦{{ number_format($car->price_per_day) }}</td>

<td>

<a href="{{ route('admin.cars.edit',$car->id) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('admin.cars.destroy',$car->id) }}" method="POST" style="display:inline;">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>

@endsection