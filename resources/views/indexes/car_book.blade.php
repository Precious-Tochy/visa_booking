@extends('layouts.index_layout')

@section('content')
@include('sweetalert::alert')

<style>
.car-image{
border-radius:15px;
box-shadow:0 15px 40px rgba(0,0,0,0.08);
}

.car-info{
background:rgb(242, 244, 245);
border-radius:15px;
padding:35px;
box-shadow:0 10px 30px rgba(0,0,0,0.05);
}

.booking-form{
background:rgb(218,227,231);
border-radius:15px;
padding:30px;
box-shadow:0 10px 30px rgba(0,0,0,0.05);
}

.section-title{
font-weight:600;
margin-bottom:15px;
}

.price-tag{
font-size:28px;
font-weight:700;
color:rgb(17,102,130);
}

.feature-box{
background:#f8f9fa;
padding:10px 15px;
border-radius:8px;
display:inline-block;
margin-right:10px;
font-size:14px;
}

.btn-book{
padding:12px;
font-size:16px;
border-radius:8px;
}

</style>

<div class="container mt-5">

<div class="row g-4">

<!-- CAR IMAGE -->

<div class="col-lg-6">

<img src="{{ asset('storage/'.$car->image) }}" class="img-fluid car-image">

<div class="car-info mt-4">

<h3 class="mb-3">{{ $car->name }}</h3>

<div class="mb-3">
<span class="feature-box">{{ $car->type }}</span>
<span class="feature-box">{{ $car->transmission }}</span>
<span class="feature-box">{{ $car->seats }} Seats</span>
</div>

<p class="price-tag">₦{{ number_format($car->price_per_day) }} <small>/day</small></p>

<p class="text-muted">
Enjoy a smooth and comfortable ride with this premium vehicle. Perfect for business trips, vacations, airport pickups, and city rides.
</p>

</div>

</div>

<!-- BOOKING FORM -->

<div class="col-lg-6">

<div class="booking-form">

<h4 class="section-title">Book This Car</h4>

<form method="POST" action="{{ route('car.book')  }}">
@csrf

<input type="hidden" name="car_id" value="{{ $car->id }}">

<div class="row">

<div class="col-md-6 mb-3">
<label>Full Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Email Address</label>
<input type="email" name="email" class="form-control" required>
</div>

</div>

<div class="mb-3">
<label>Phone Number</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="mb-3">
<label>Pickup Location</label>
<input type="text" name="pickup_location" class="form-control" placeholder="City or Airport" required>
</div>

<div class="row">

<div class="col-md-6 mb-3">
<label>Pickup Date</label>
<input type="date" name="pickup_date" class="form-control" min="{{ date('Y-m-d') }}" required>
</div>

<div class="col-md-6 mb-3">
<label>Pickup Time</label>
<input type="time" name="pickup_time" class="form-control" required>
</div>

</div>

<div class="mb-3">
<label>Return Date</label>
<input type="date" name="return_date" class="form-control" min="{{ date('Y-m-d') }}" required>
</div>

<div class="form-check mb-4">
<input class="form-check-input" type="checkbox" name="with_driver" id="driverCheck">
<label class="form-check-label" for="driverCheck">
Add Driver Service (+ ₦10,000)
</label>
</div>

<button class="btn w-100 btn-book" style="background-color: rgb(17,102,130); color:#ffffff;">
Confirm Booking
</button>

</form>

</div>

</div>

</div>

</div>

@endsection
