@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="container">

<h3>Edit Car</h3>

<form action="{{ route('admin.cars.update',$car->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<input type="text" name="name" class="form-control mb-2" value="{{ $car->name }}">

<select name="type" class="form-control mb-2">
<option {{ $car->type=='Economy'?'selected':'' }}>Economy</option>
<option {{ $car->type=='SUV'?'selected':'' }}>SUV</option>
<option {{ $car->type=='Luxury'?'selected':'' }}>Luxury</option>
<option {{ $car->type=='Van'?'selected':'' }}>Van</option>
</select>

<select name="transmission" class="form-control mb-2">
<option {{ $car->transmission=='Automatic'?'selected':'' }}>Automatic</option>
<option {{ $car->transmission=='Manual'?'selected':'' }}>Manual</option>
</select>

<input type="number" name="seats" value="{{ $car->seats }}" class="form-control mb-2">

<input type="number" name="price_per_day" value="{{ $car->price_per_day }}" class="form-control mb-2">

<input type="file" name="image" class="form-control mb-2">

<button class="btn btn-success">
Update Car
</button>

</form>

</div>

@endsection