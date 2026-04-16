@extends('layouts.index_layout')
@section('content')
<div class="country-packages">
    <h2>Explore Travel Packages</h2>
<p class="subtitle">Handpicked premium experiences for global travelers</p>
    <!-- FILTER -->
    <div class="filter-bar">
        <select id="countryFilter">
            <option value="all">All Countries</option>
            @foreach($packages->unique('country') as $pkg)
                <option value="{{ $pkg->country }}">{{ $pkg->country }}</option>
            @endforeach
        </select>
    </div>

    <div class="packages-grid">

        @foreach($packages as $package)
        <div class="package-box" data-country="{{ $package->country }}">
            
            @if($package->is_popular)
                <span class="badge">Popular</span>
            @endif

            
            
            <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}">


            <!-- OVERLAY -->
            <div class="package-overlay">
                <h3>{{ $package->title }}</h3>
                <span>{{ $package->duration }}</span>
            </div>

            <div class="package-content">

                <p class="mini-info">
                    🏨 ✈ 🍽 {{ $package->includes }}
                </p>

                <div class="price">
                    From <strong>${{ $package->price }}</strong>
                </div>

                <div class="package-buttons">
    

    <a href="{{ route('packages.show', $package->slug) }}" class="view-btn">
    View Details →
    </a>
</div>
            </div>

        </div>
        @endforeach

    </div>
</div>
<style>
    .package-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

/* VIEW BUTTON (outline premium) */
.view-btn {
    flex: 1;
    text-align: center;
    padding: 10px;
    border-radius: 30px;
    border: 2px solid rgb(17,102,130);
    color: rgb(17,102,130);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.view-btn:hover {
    background: rgb(17,102,130);
    color: #fff;
    transform: translateY(-2px);
}

/* BOOK BUTTON */
.package-btn {
    flex: 1;
    text-align: center;
}
.package-buttons {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    opacity: 0;
    transform: translateY(20px);
    transition: 0.4s ease;
    z-index: 3;
}

.package-box:hover .package-buttons {
    opacity: 1;
    transform: translateY(0);
}
    .country-packages {
    margin-top: 4rem;
    padding: 20px;
    text-align: center;
}

.country-packages h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: rgb(17,102,130);
    margin-bottom: 10px;
}

.filter-bar {
    margin: 25px 0 40px;
}

.filter-bar select {
    padding: 10px 18px;
    border-radius: 30px;
    border: none;
    background: rgba(17,102,130,0.1);
    color: rgb(17,102,130);
    font-weight: 600;
    outline: none;
    cursor: pointer;
}

/* GRID */
.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

/* CARD */
.package-box {
    position: relative;
    border-radius: 22px;
    overflow: hidden;
    transition: all 0.4s ease;
    background: #fff;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

/* IMAGE */
.package-box img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    transition: transform 0.7s ease;
}

/* OVERLAY GRADIENT */
.package-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75), transparent);
    z-index: 1;
}

/* TITLE ON IMAGE */
.package-overlay {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: #fff;
    z-index: 2;
}

.package-overlay h3 {
    font-size: 1.4rem;
    font-weight: 700;
}

.package-overlay span {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* CONTENT */
.package-content {
    padding: 22px;
    text-align: left;
}

/* MINI INFO */
.mini-info {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 10px;
}

/* PRICE */
.price {
    font-size: 1.1rem;
    margin: 10px 0 15px;
    color: #111;
}

/* BUTTON */
.package-btn {
    display: inline-block;
    background: rgb(17,102,130);
    padding: 10px 20px;
    border-radius: 30px;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.package-btn:hover {
    background: #0d5c73;
    transform: translateY(-2px);
}

/* BADGE */
.badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(45deg, gold, #f5d76e);
    color: #000;
    padding: 6px 14px;
    font-size: 0.75rem;
    border-radius: 20px;
    font-weight: 600;
    z-index: 3;
}

/* HOVER EFFECT */
.package-box:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.package-box:hover img {
    transform: scale(1.1);
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const filter = document.getElementById("countryFilter");

    if (!filter) return;

    filter.addEventListener("change", function () {
        let value = this.value;
        let cards = document.querySelectorAll(".package-box");

        cards.forEach(card => {
            if (value === "all" || card.dataset.country === value) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});
</script>
@endsection