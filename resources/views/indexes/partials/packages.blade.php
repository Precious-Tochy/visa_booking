@forelse($packages as $package)
<div class="package-box">

    @if($package->is_popular)
        <span class="badge">🔥 Popular</span>
    @endif

    <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}">

    <div class="package-content">
        <h3>{{ $package->title }}</h3>
        <span class="country">{{ $package->country }}</span>

        <div class="price">
            From <strong>${{ $package->price }}</strong>
        </div>

        <!-- VIEW BUTTON -->
        <a href="{{ route('packages.show', $package->slug) }}" class="view-btn">
            View Details →
        </a>
    </div>
</div>
<style>
    .package-box {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    transition: 0.3s ease;
}

.package-box:hover {
    transform: translateY(-8px);
}

/* IMAGE */
.package-box img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

/* BADGE */
.badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: crimson;
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
}

/* CONTENT */
.package-content {
    padding: 20px;
}

.package-content h3 {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.country {
    font-size: 0.9rem;
    color: #777;
}

.price {
    margin: 10px 0;
    font-size: 1rem;
}

/* VIEW BUTTON */
.view-btn {
    display: inline-block;
    margin-top: 10px;
    background: linear-gradient(135deg, rgb(17,102,130), #0d5c73);
    color: #fff;
    padding: 10px 18px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: 0.3s ease;
}

.view-btn:hover {
    background: #0d5c73;
    transform: translateY(-2px);
}
</style>
@empty
<p class="no-data">No packages available yet.</p>
@endforelse