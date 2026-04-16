@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="booking-wrapper">

    <div class="booking-header">
        <h2>Booking Details</h2>
        <a href="{{ route('admin.tours') }}" class="back-btn">
            <i class="ri-arrow-left-line"></i> Back to Bookings
        </a>
    </div>

    <div class="booking-card">

        <div class="booking-info">
            <h3>{{ $booking->first_name }} {{ $booking->last_name }}</h3>
            <p><i class="ri-mail-line"></i> {{ $booking->email }}</p>
            <p><i class="ri-phone-line"></i> {{ $booking->phone }}</p>
            <p><i class="ri-map-pin-line"></i> Destination: {{ $booking->country }}</p>
            <p><i class="ri-briefcase-line"></i> Package: {{ $booking->package }}</p>
            <p><i class="ri-user-line"></i> Travelers: {{ $booking->travelers }}</p>
            <p><i class="ri-hotel-line"></i> Hotel: {{ $booking->hotel }}</p>
            <p><i class="ri-sticky-note-line"></i> Notes: {{ $booking->notes ?? 'N/A' }}</p>
        </div>

        <hr>

        <div class="status-update">
            <h4>Update Booking Status</h4>
            <form method="POST" action="{{ route('admin.tour.status', $booking->id) }}">
                @csrf
                <select name="status" class="status-select">
                    <option value="Pending" @if($booking->status == 'Pending') selected @endif>Pending</option>
                    <option value="Approved" @if($booking->status == 'Approved') selected @endif>Approved</option>
                    <option value="Rejected" @if($booking->status == 'Rejected') selected @endif>Rejected</option>
                </select>

                <button type="submit" class="update-btn">Update Status</button>
            </form>
        </div>

    </div>
</div>

@endsection

<style>
.booking-wrapper {
    padding: 30px;
    background: #f9fafd;
}

.booking-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.booking-header h2 {
    color: #116682;
}

.back-btn {
    text-decoration: none;
    color: #116682;
    border: 1px solid #116682;
    padding: 6px 15px;
    border-radius: 8px;
    transition: 0.3s;
    font-weight: 500;
}

.back-btn:hover {
    background: #116682;
    color: #fff;
}

.booking-card {
    background: #fff;
    padding: 25px 30px;
    border-radius: 20px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
}

.booking-info h3 {
    margin-bottom: 10px;
    color: #333;
}

.booking-info p {
    margin: 6px 0;
    color: #555;
    display: flex;
    align-items: center;
}

.booking-info i {
    margin-right: 8px;
    color: #116682;
    font-size: 16px;
}

.status-update {
    margin-top: 20px;
}

.status-select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-right: 10px;
    outline: none;
}

.update-btn {
    padding: 8px 20px;
    border-radius: 25px;
    border: none;
    background: #116682;
    color: #fff;
    cursor: pointer;
    transition: 0.3s;
}

.update-btn:hover {
    background: #0d4c5d;
}
</style>