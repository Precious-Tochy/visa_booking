@extends('layouts.index_layout')
@section('content')

<div class="confirmation-header" style="text-align:center; padding:4rem 1rem; background-color:#f0f8ff;">
    <!-- Large check icon badge -->
    <div style="display:flex; justify-content:center; align-items:center; background-color:#116682; color:white; border-radius:50%; width:80px; height:80px; font-size:2.5rem; margin:0 auto 1rem auto;">
        <i class="fas fa-check"></i>
    </div>
    
    <h1 style="font-size:2.5rem; color:#116682; margin-bottom:0.5rem;">Reservation Confirmed!</h1>
    <p style="font-size:1.2rem; color:#555;">Thank you for booking with <strong>Tochy Travels</strong></p>
</div>

<div class="confirmation-summary" style="display:flex; justify-content:center; padding:3rem 1rem;">
    <div style="background:#fff; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); padding:2rem; max-width:800px; width:100%;">
        <h2 style="text-align:center; color:#116682; margin-bottom:2rem;">Booking Summary</h2>
        <div style="display:grid; grid-template-columns:1fr 1fr; row-gap:15px; column-gap:20px; font-size:1rem; color:#333;">
            <div><strong>Guest Name:</strong> {{ $booking->first_name }} {{ $booking->last_name }}</div>
            <div><strong>Email:</strong> {{ $booking->email }}</div>
            <div><strong>Phone:</strong> {{ $booking->phone }}</div>
            <div><strong>Location:</strong> {{ $booking->location }}</div>
            <div><strong>Hotel Category:</strong> {{ $booking->hotel_category }}</div>
            <div><strong>Check-in:</strong> {{ $booking->check_in }}</div>
            <div><strong>Check-out:</strong> {{ $booking->check_out }}</div>
            <div><strong>Guests:</strong> {{ $booking->guests }}</div>
            <div><strong>Rooms:</strong> {{ $booking->rooms }}</div>
            <div><strong>Room Type:</strong> {{ $booking->room_type ?? 'N/A' }}</div>
            <div style="grid-column:1 / -1;"><strong>Special Requests:</strong> {{ $booking->notes ?? 'None' }}</div>
        </div>

        <div style="text-align:center; margin-top:30px;">
            <a href="{{ route('hotel.download.pdf', $booking->id) }}"
               style="display:inline-block; padding:12px 25px; background:#116682; color:white; border-radius:8px; font-weight:600; text-decoration:none;">
               <i class="fas fa-download" style="margin-right:8px;"></i> Download PDF
            </a>
        </div>
    </div>
</div>

@endsection

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-jQVR2..." crossorigin="anonymous" referrerpolicy="no-referrer" />
