@extends('layouts.index_layout')

@section('content')

@include('sweetalert::alert')

<style>
:root {
  --primary: rgb(17,102,130);
  --secondary: rgb(17,65,82);
  --accent: #e8b84a;
  --bg: #f5f7fa;
  --text-dark: #2d3436;
  --text-light: #636e72;
  --white: #ffffff;
  --shadow: 0 10px 30px rgba(0,0,0,0.1);
  --shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

body {
  background: var(--bg);
  color: var(--text-dark);
}

/* Back Button */
.back-button {
  max-width: 1200px;
  margin: 20px auto 0;
  padding: 0 20px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: var(--primary);
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
  padding: 10px 0;
}

.back-link:hover {
  color: var(--secondary);
  gap: 12px;
}

/* Main Container */
.main-container {
  max-width: 1200px;
  margin: 20px auto 60px;
  padding: 0 20px;
}

/* Car Details Card */
.car-details-card {
  background: var(--white);
  border-radius: 30px;
  overflow: hidden;
  box-shadow: var(--shadow-hover);
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0;
}

/* Image Gallery */
.image-gallery {
  position: relative;
  height: 100%;
  min-height: 500px;
  background: #f8fafd;
}

.main-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-badge {
  position: absolute;
  top: 20px;
  left: 20px;
  background: var(--primary);
  color: var(--white);
  padding: 8px 16px;
  border-radius: 30px;
  font-size: 0.9rem;
  font-weight: 600;
  z-index: 2;
  box-shadow: 0 4px 10px rgba(17,102,130,0.3);
  display: flex;
  align-items: center;
  gap: 8px;
}

.image-badge i {
  font-size: 1rem;
}

/* Car Info Section */
.car-info-section {
  padding: 40px;
}

.car-title {
  font-size: 2.2rem;
  font-weight: 700;
  color: var(--text-dark);
  margin-bottom: 15px;
  line-height: 1.2;
}

.car-meta {
  display: flex;
  gap: 12px;
  margin-bottom: 25px;
  flex-wrap: wrap;
}

.meta-tag {
  background: #eef2f7;
  padding: 6px 14px;
  border-radius: 30px;
  font-size: 0.85rem;
  font-weight: 500;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 6px;
}

.meta-tag i {
  color: var(--primary);
  font-size: 0.8rem;
}

/* Price Box */
.price-box {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: var(--white);
  padding: 25px;
  border-radius: 20px;
  margin-bottom: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: var(--shadow);
}

.price-label {
  font-size: 1rem;
  opacity: 0.9;
  display: flex;
  align-items: center;
  gap: 8px;
}

.price-amount {
  font-size: 2.5rem;
  font-weight: 800;
  line-height: 1;
}

.price-period {
  font-size: 0.9rem;
  opacity: 0.9;
  margin-left: 5px;
}

/* Features Grid */
.features-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
  margin-bottom: 30px;
}

.feature-box {
  background: #f8fafd;
  padding: 18px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  transition: all 0.3s ease;
}

.feature-box:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow);
}

.feature-icon {
  width: 45px;
  height: 45px;
  background: var(--white);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--primary);
  font-size: 1.3rem;
  box-shadow: 0 5px 15px rgba(17,102,130,0.1);
}

.feature-text h4 {
  font-size: 1rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 4px;
}

.feature-text p {
  font-size: 0.85rem;
  color: var(--text-light);
}

/* Description Section */
.description-section {
  margin-bottom: 30px;
}

.description-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.description-title i {
  color: var(--primary);
}

.description-text {
  color: var(--text-light);
  line-height: 1.7;
  font-size: 0.95rem;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 15px;
  margin-top: 30px;
}

.btn-book-now {
  flex: 2;
  background: var(--primary);
  color: var(--white);
  border: none;
  border-radius: 15px;
  padding: 16px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  text-decoration: none;
}

.btn-book-now:hover {
  background: var(--secondary);
  transform: translateY(-3px);
  box-shadow: var(--shadow-hover);
}

.btn-back {
  flex: 1;
  background: #eef2f7;
  color: var(--text-dark);
  border: none;
  border-radius: 15px;
  padding: 16px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  text-decoration: none;
}

.btn-back:hover {
  background: #e2e8f0;
  transform: translateY(-3px);
}

/* Specifications Table */
.specs-section {
  margin-top: 40px;
  background: var(--white);
  border-radius: 20px;
  padding: 30px;
  box-shadow: var(--shadow);
}

.specs-title {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 25px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.specs-title i {
  color: var(--primary);
}

.specs-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.spec-item {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.spec-label {
  font-size: 0.85rem;
  color: var(--text-light);
  display: flex;
  align-items: center;
  gap: 5px;
}

.spec-label i {
  color: var(--primary);
  width: 16px;
}

.spec-value {
  font-size: 1rem;
  font-weight: 600;
  color: var(--text-dark);
}

/* Similar Cars */
.similar-section {
  margin-top: 40px;
}

.similar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.similar-header h3 {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 10px;
}

.similar-header h3 i {
  color: var(--primary);
}

.view-all {
  color: var(--primary);
  text-decoration: none;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: all 0.3s ease;
}

.view-all:hover {
  color: var(--secondary);
  gap: 8px;
}

.similar-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.similar-card {
  background: var(--white);
  border-radius: 15px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  text-decoration: none;
  color: inherit;
}

.similar-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.similar-image {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.similar-content {
  padding: 15px;
}

.similar-name {
  font-size: 1rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 5px;
}

.similar-price {
  color: var(--primary);
  font-weight: 700;
  font-size: 1.1rem;
}

.similar-price small {
  font-size: 0.75rem;
  color: var(--text-light);
  font-weight: normal;
}

/* Responsive */
@media (max-width: 900px) {
  .car-details-card {
    grid-template-columns: 1fr;
  }
  
  .image-gallery {
    min-height: 400px;
  }
  
  .car-title {
    font-size: 1.8rem;
  }
  
  .specs-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .similar-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .car-info-section {
    padding: 25px;
  }
  
  .price-box {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }
  
  .features-grid {
    grid-template-columns: 1fr;
  }
  
  .action-buttons {
    flex-direction: column;
  }
  
  .specs-grid {
    grid-template-columns: 1fr;
  }
  
  .similar-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<!-- Back Button -->
<div class="back-button">
  <a href="{{ route('car.rentals') }}" class="back-link">
    <i class="fas fa-arrow-left"></i> Back to All Cars
  </a>
</div>

<!-- Main Container -->
<div class="main-container">
  <!-- Car Details Card -->
  <div class="car-details-card">
    <!-- Image Section -->
    <div class="image-gallery">
      <span class="image-badge">
        <i class="fas fa-car"></i> {{ $car->type }}
      </span>
      <img src="{{ asset('storage/'.$car->image) }}" alt="{{ $car->name }}" class="main-image">
    </div>
    
    <!-- Info Section -->
    <div class="car-info-section">
      <h1 class="car-title">{{ $car->name }}</h1>
      
      <!-- Meta Tags -->
      <div class="car-meta">
        <span class="meta-tag">
          <i class="fas fa-tag"></i> {{ $car->type }}
        </span>
        <span class="meta-tag">
          <i class="fas fa-cog"></i> {{ $car->transmission }}
        </span>
        <span class="meta-tag">
          <i class="fas fa-users"></i> {{ $car->seats }} Seats
        </span>
        <span class="meta-tag">
          <i class="fas fa-map-marker-alt"></i> {{ $car->location ?? 'Various Locations' }}
        </span>
      </div>
      
      <!-- Price Box -->
      <div class="price-box">
        <span class="price-label">
          <i class="fas fa-money-bill-wave"></i> Rental Price
        </span>
        <div>
          <span class="price-amount">₦{{ number_format($car->price_per_day) }}</span>
          <span class="price-period">/day</span>
        </div>
      </div>
      
      <!-- Features Grid -->
      <div class="features-grid">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-gas-pump"></i>
          </div>
          <div class="feature-text">
            <h4>Fuel Type</h4>
            <p>{{ $car->fuel_type ?? 'Petrol' }}</p>
          </div>
        </div>
        
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-tachometer-alt"></i>
          </div>
          <div class="feature-text">
            <h4>Mileage</h4>
            <p>{{ $car->mileage ?? 'Unlimited' }}</p>
          </div>
        </div>
        
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-snowflake"></i>
          </div>
          <div class="feature-text">
            <h4>Air Conditioning</h4>
            <p>{{ $car->ac ?? 'Yes' }}</p>
          </div>
        </div>
        
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div class="feature-text">
            <h4>Insurance</h4>
            <p>Full Coverage</p>
          </div>
        </div>
      </div>
      
      <!-- Description -->
      <div class="description-section">
        <h3 class="description-title">
          <i class="fas fa-info-circle"></i> Description
        </h3>
        <p class="description-text">
          {{ $car->description ?? 'Experience comfort and performance with this premium vehicle. Perfect for business trips, family vacations, airport pickups, and city rides. Features include Bluetooth connectivity, backup camera, cruise control, and more.' }}
        </p>
      </div>
      
      <!-- Action Buttons -->
      <div class="action-buttons">
         <a href="{{ route('car.book.form', $car->id) }}" class="btn-book-now">
          <i class="fas fa-calendar-check"></i> Book This Car
        </a> 
        <a href="{{ route('car.rentals') }}" class="btn-back">
          <i class="fas fa-arrow-left"></i> Back
        </a>
      </div>
    </div>
  </div>
  
  <!-- Specifications Section -->
  <div class="specs-section">
    <h3 class="specs-title">
      <i class="fas fa-clipboard-list"></i> Vehicle Specifications
    </h3>
    
    <div class="specs-grid">
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-calendar"></i> Year</span>
        <span class="spec-value">{{ $car->year ?? '2024' }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-palette"></i> Color</span>
        <span class="spec-value">{{ $car->color ?? 'Various' }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-gas-pump"></i> Fuel Capacity</span>
        <span class="spec-value">{{ $car->fuel_capacity ?? '50L' }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-cog"></i> Transmission</span>
        <span class="spec-value">{{ $car->transmission }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-users"></i> Seating Capacity</span>
        <span class="spec-value">{{ $car->seats }} Persons</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-suitcase"></i> Luggage</span>
        <span class="spec-value">{{ $car->luggage ?? '3 Bags' }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-bluetooth"></i> Bluetooth</span>
        <span class="spec-value">{{ $car->bluetooth ?? 'Yes' }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-camera"></i> Backup Camera</span>
        <span class="spec-value">{{ $car->backup_camera ?? 'Yes' }}</span>
      </div>
      
      <div class="spec-item">
        <span class="spec-label"><i class="fas fa-wifi"></i> GPS</span>
        <span class="spec-value">{{ $car->gps ?? 'Available' }}</span>
      </div>
    </div>
  </div>
  
  <!-- Similar Cars -->
  @if(isset($similarCars) && $similarCars->count() > 0)
  <div class="similar-section">
    <div class="similar-header">
      <h3>
        <i class="fas fa-car"></i> Similar Vehicles
      </h3>
      <a href="{{ route('car.rentals') }}" class="view-all">
        View All <i class="fas fa-arrow-right"></i>
      </a>
    </div>
    
    <div class="similar-grid">
      @foreach($similarCars as $similarCar)
      <a href="{{ route('car.details', $similarCar->id) }}" class="similar-card">
        <img src="{{ asset('storage/'.$similarCar->image) }}" alt="{{ $similarCar->name }}" class="similar-image">
        <div class="similar-content">
          <h4 class="similar-name">{{ $similarCar->name }}</h4>
          <div class="similar-price">
            ₦{{ number_format($similarCar->price_per_day) }} <small>/day</small>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection