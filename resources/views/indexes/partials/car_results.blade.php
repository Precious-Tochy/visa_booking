@if($cars->count() > 0)
<div class="slider-container">
    <div class="cars-slider">
        <div class="slider-track">
            @foreach($cars as $car)
            <div class="car-card">
                <div class="car-image-wrapper">
                    <img src="{{ asset('storage/'.$car->image) }}" alt="{{ $car->name }}" class="car-image">
                    <div class="image-overlay"></div>
                </div>
                
                <div class="car-content">
                    <div class="car-header">
                        <h3 class="car-name">{{ $car->name }}</h3>
                        <span class="car-type">{{ $car->type }}</span>
                    </div>
                    
                    <div class="car-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $car->location ?? 'Various locations' }}</span>
                    </div>
                    
                    <div class="car-features">
                        <span class="feature">
                            <i class="fas fa-users"></i> {{ $car->seats }} Seats
                        </span>
                        <span class="feature">
                            <i class="fas fa-cog"></i> {{ $car->transmission }}
                        </span>
                    </div>
                    
                    <div class="car-price">
                        <span class="price-amount">₦{{ number_format($car->price_per_day) }}</span>
                        <span class="price-period">/day</span>
                    </div>
                    
                    <div class="car-actions">
                        <a href="{{ route('car.details', $car->id) }}" class="btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('car.book.form', $car->id) }}" class="btn-book">
                            <i class="fas fa-calendar-check"></i> Book
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="slider-controls">
        <button class="slider-btn prev-btn" disabled>
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-btn next-btn">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
    
    <div class="slider-dots"></div>
</div>
@else
<div class="no-results">
    <i class="fas fa-car"></i>
    <h3>No cars available</h3>
    <p>Try adjusting your search filters or check back later</p>
</div>
@endif