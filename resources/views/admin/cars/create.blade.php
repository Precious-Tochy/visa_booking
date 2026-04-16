@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="container">

<h3>Add New Car</h3>

<form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Type</label>
<select name="type" class="form-control">
<option>Economy</option>
<option>SUV</option>
<option>Luxury</option>
<option>Van</option>
</select>
</div>

<div class="mb-3">
<label>Transmission</label>
<select name="transmission" class="form-control">
<option>Automatic</option>
<option>Manual</option>
</select>
</div>
<div class="mb-3">
    <label>Location</label>
    <input type="text" name="location" class="form-control">
</div>
<div class="mb-3">
<label>Seats</label>
<input type="number" name="seats" class="form-control">
</div>

<div class="mb-3">
<label>Price Per Day</label>
<input type="number" name="price_per_day" class="form-control">
</div>

<div class="mb-3">
<label>Car Image</label>
<input type="file" name="image" class="form-control">
</div>

<button class="btn btn-primary">
Save Car
</button>

</form>

</div>

@endsection