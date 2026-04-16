@extends('layouts.index_layout')

@section('content')

<div class="success-wrapper">

    <!-- MAIN SUCCESS CARD -->
    <div class="success-card">

        <!-- TICK ICON -->
        <div class="tick-icon">✔</div>

        <!-- HEADINGS -->
        <h1>Tour Booking Confirmed</h1>
        <p class="subtitle">Thank you for booking with <strong>Tochy Travels</strong>.</p>
        <p class="note">We’ll review your request and get back to you shortly with the best tour options.</p>

        <!-- SUMMARY -->
        <div class="summary-card">
            <h3>Booking Summary</h3>
            <div class="summary-row">
                <span>Name</span>
                <strong>{{$booking->first_name}} {{$booking->last_name}}</strong>
            </div>
            <div class="summary-row">
                <span>Destination</span>
                <strong>{{$booking->country ?? '—'}}</strong>
            </div>
            <div class="summary-row">
                <span>Package</span>
                <strong>{{$booking->package ?? '—'}}</strong>
            </div>
            <div class="summary-row">
                <span>Departure</span>
                <strong>{{$booking->departure_date ?? '—'}}</strong>
            </div>
            <div class="summary-row">
                <span>Return</span>
                <strong>{{$booking->return_date ?? '—'}}</strong>
            </div>
            <div class="summary-row">
                <span>Travelers</span>
                <strong>{{$booking->travelers}}</strong>
            </div>
            <div class="summary-row">
                <span>Status</span>
                <strong class="status">{{$booking->status}}</strong>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="actions">
            <a href="{{ url('/') }}" class="btn primary">Return Home</a>
            <a href="{{ route('tour.form') }}" class="btn outline">Book Another Tour</a>
        </div>

    </div>

</div>

@endsection

<style>
/* LUXURY SUCCESS WRAPPER */
.success-wrapper {
    min-height: 80vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 50px 15px;
}

/* MAIN CARD */
.success-card {
    background:rgb(238, 241, 241);
    border-radius: 25px;
    padding: 50px 40px;
    max-width: 600px;
    width: 100%;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    position: relative;
}

/* TICK ICON */
.tick-icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    font-size: 50px;
    color: rgb(17,102,130); /* BRAND BLUE */
    border: 3px solid rgb(17,102,130);
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 25px;
    font-weight: bold;
}

/* HEADINGS */
.success-card h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: rgb(17,102,130);
    margin-bottom: 10px;
}

.subtitle {
    color: #444;
    font-size: 1rem;
    margin-bottom: 5px;
}

.note {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 30px;
}

/* SUMMARY CARD */
.summary-card {
    text-align: left;
    background: #f9f9f9;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.summary-card h3 {
    color: rgb(17,102,130);
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 0.95rem;
}

.summary-row span {
    color: #777;
}

.summary-row strong {
    color: #222;
}

.status {
    background: rgb(189, 189, 125);
    color: #fff;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 0.8rem;
}

/* BUTTONS */
.actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 25px;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}

/* PRIMARY BUTTON */
.btn.primary {
    background: rgb(17,102,130);
    color: #fff;
}

.btn.primary:hover {
    background: rgb(17,65,82);
    color: #fff;
}

/* OUTLINE BUTTON */
.btn.outline {
    border: 2px solid rgb(17,102,130);
    color: rgb(17,102,130);
}

.btn.outline:hover {
    background: rgb(17,102,130);
    color: #fff !important;
}

/* RESPONSIVE */
@media(max-width:600px){
    .success-card {
        padding: 40px 20px;
    }
    .tick-icon {
        width: 80px;
        height: 80px;
        font-size: 40px;
    }
}
</style>