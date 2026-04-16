@extends('layouts.index_layout')

@section('content')

<section class="car-hero">

<img src="{{ asset('storage/'.$car->image) }}">

</section>

<div class="container car-details">

<div class="car-info">

<h2>{{ $car->name }}</h2>

<div class="car-specs">

<span>{{ $car->type }}</span>

<span>{{ $car->transmission }}</span>

<span>{{ $car->seats }} Seats</span>

</div>

<p class="price">
₦{{ number_format($car->price_per_day) }} / day
</p>

<p class="description">
This vehicle is perfect for comfortable travel and reliable transportation.
Ideal for airport pickups, city tours, and long trips.
</p>

</div>

<div class="booking-box">

<h4>Book This Car</h4>

<form action="{{ route('car.book') }}" method="POST">

@csrf

<input type="hidden" name="car_id" value="{{ $car->id }}">

<input type="text" name="name" placeholder="Your Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="text" name="phone" placeholder="Phone" required>

<label>Pickup Date</label>
<input type="date" name="pickup_date">

<label>Return Date</label>
<input type="date" name="return_date">

<label>
<input type="checkbox" name="with_driver">
With Driver
</label>

<button type="submit">
Confirm Booking
</button>

</form>

</div>

</div>
<style>
    
.car-hero img{
width:100%;
height:400px;
object-fit:cover;
}

.car-details{
display:grid;
grid-template-columns:2fr 1fr;
gap:40px;
margin-top:40px;
}

.car-specs{
display:flex;
gap:20px;
margin:10px 0;
color:#666;
}

.price{
font-size:1.6rem;
color:rgb(17,102,130);
font-weight:bold;
}

.booking-box{
background:#fff;
padding:25px;
border-radius:12px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
}

.booking-box input{
width:100%;
padding:12px;
margin-bottom:10px;
border-radius:8px;
border:1px solid #ddd;
}

.booking-box button{
width:100%;
padding:14px;
background:rgb(17,102,130);
color:#fff;
border:none;
border-radius:8px;
cursor:pointer;
}

.booking-box button:hover{
background:rgb(17,65,82);
}
</style>
@endsection