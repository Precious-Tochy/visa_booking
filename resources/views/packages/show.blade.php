@extends('layouts.index_layout')

@section('content')

<div class="package-details">

    <!-- HERO SECTION -->
    <div class="hero">
        <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}">
        <div class="hero-overlay">
            <h1>{{ $package->title }}</h1>
            <p>{{ $package->country }} • {{ $package->duration }}</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="details-container">

        <!-- LEFT SIDE -->
        <div class="details-left">

            <h2>✨ Experience {{ $package->country }}</h2>
            <p class="desc">
                Discover the beauty of {{ $package->country }} with our carefully curated travel experience.
                Enjoy comfort, adventure, and unforgettable memories tailored just for you.
            </p>

            <!-- FEATURES -->
           @php
    $includes = json_decode($package->includes, true);
@endphp

<div class="features">
    <h3>What’s Included</h3>
    <ul>
        @if($includes)
            @foreach($includes as $item)
                <li>✔ {{ $item }}</li>
            @endforeach
        @else
            <li>✔ Luxury Accommodation</li>
            <li>✔ Daily Breakfast</li>
            <li>✔ Airport Transfers</li>
            <li>✔ Guided Tours</li>
        @endif
    </ul>
</div>

            <!-- EXTRA INFO -->
            <div class="extra">
                <h3>Why Choose This Package?</h3>
                <p>
                    ✔ Premium service <br>
                    ✔ Best price guarantee <br>
                    ✔ Trusted travel experience <br>
                    ✔ 24/7 customer support
                </p>
            </div>

        </div>

        <!-- RIGHT SIDE (BOOKING CARD) -->
        <div class="details-right">

            <div class="booking-card">

                <h3>From</h3>
                <h2>${{ $package->price }}</h2>

                <p>{{ $package->duration }} stay</p>

                <a href="https://wa.me/2349053531176?text=Hello%20I%20am%20interested%20in%20{{ urlencode($package->title) }}"
                   class="book-btn"
                   target="_blank">
                   Book Now via WhatsApp
                </a>

                <p class="note">No hidden fees • Instant response</p>

            </div>

        </div>

    </div>
</div>

<style>

/* HERO */
.hero {
    position: relative;
    height: 60vh;
    overflow: hidden;
}

.hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    bottom: 40px;
    left: 40px;
    color: #fff;
}

.hero-overlay h1 {
    font-size: 3rem;
    font-weight: 700;
}

.hero-overlay p {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* CONTAINER */
.details-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    padding: 50px;
}

/* LEFT */
.details-left h2 {
    font-size: 2rem;
    margin-bottom: 15px;
}

.desc {
    color: #555;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* FEATURES */
.features ul {
    list-style: none;
    padding: 0;
}

.features li {
    margin-bottom: 10px;
    font-size: 1rem;
}

/* EXTRA */
.extra {
    margin-top: 30px;
}

/* RIGHT CARD */
.booking-card {
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    text-align: center;
    position: sticky;
    top: 100px;
}

.booking-card h2 {
    font-size: 2.5rem;
    color: rgb(17,102,130);
}

.book-btn {
    display: block;
    margin-top: 20px;
    background: rgb(17,102,130);
    color: #fff;
    padding: 14px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.book-btn:hover {
    background: #0d5c73;
    transform: translateY(-2px);
}

.note {
    font-size: 0.8rem;
    color: #777;
    margin-top: 10px;
}

/* RESPONSIVE */
@media(max-width: 900px){
    .details-container {
        grid-template-columns: 1fr;
    }
}

</style>

@endsection