@extends('layouts.index_layout')
@section('content')

<div style="width:80%; margin:auto; padding:20px;">
    <h1 style="color: rgb(17,102,130); margin-bottom:20px;">Add New Car</h1>

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Transmission</label>
            <select name="transmission" required>
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>
        <div class="form-group">
            <label>Seats</label>
            <input type="number" name="seats" required>
        </div>
        <div class="form-group">
            <label>Price per day</label>
            <input type="number" name="price_per_day" required>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" required>
        </div>

        <button type="submit" style="background:rgb(17,65,82); color:#fff; padding:10px 20px; border-radius:8px;">Add Car</button>
    </form>
</div>

@endsection
