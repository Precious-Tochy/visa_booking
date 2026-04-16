@extends('layouts.index_layout')
@section('content')

<div style="width:80%; margin:auto; padding:20px;">
    <h1 style="color: rgb(17,102,130); margin-bottom:20px;">Edit Car</h1>

    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $car->name }}" required>
        </div>
        <div class="form-group">
            <label>Transmission</label>
            <select name="transmission" required>
                <option value="Automatic" {{ $car->transmission == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                <option value="Manual" {{ $car->transmission == 'Manual' ? 'selected' : '' }}>Manual</option>
            </select>
        </div>
        <div class="form-group">
            <label>Seats</label>
            <input type="number" name="seats" value="{{ $car->seats }}" required>
        </div>
        <div class="form-group">
            <label>Price per day</label>
            <input type="number" name="price_per_day" value="{{ $car->price_per_day }}" required>
        </div>
        <div class="form-group">
            <label>Image (leave empty to keep current)</label>
            <input type="file" name="image">
            <img src="{{ asset('storage/'.$car->image) }}" alt="Current Image" style="width:150px; margin-top:10px;">
        </div>

        <button type="submit" style="background:rgb(17,65,82); color:#fff; padding:10px 20px; border-radius:8px;">Update Car</button>
    </form>
</div>

@endsection
