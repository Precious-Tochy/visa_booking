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

/* Hero Section */
.hero {
  height: 70vh;
  background: linear-gradient(135deg, rgba(17,102,130,0.95), rgba(17,65,82,0.95)),
              url('https://images.unsplash.com/photo-1549924231-f129b911e442?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover fixed;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: var(--white);
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  /* background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path d="M20 20 L80 20 L80 80 L20 80 Z" fill="none" stroke="white" stroke-width="2"/><circle cx="50" cy="50" r="15" fill="none" stroke="white" stroke-width="2"/></svg>') repeat; */
  background: url('/visa-booking/image/Leopar Rent a Car _ Social Media Design….jpg');
  animation: slide 60s linear infinite;
}

@keyframes slide {
  from { transform: translateX(0); }
  to { transform: translateX(-100px); }
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 0 20px;
}

.hero h1 {
  font-size: 4rem;
  font-weight: 800;
  margin-bottom: 1rem;
  animation: fadeInUp 0.8s ease;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
  letter-spacing: -1px;
}

.hero p {
  font-size: 1.5rem;
  opacity: 0.95;
  animation: fadeInUp 0.8s ease 0.2s both;
  font-weight: 300;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Search Section */
.search-section {
  max-width: 1200px;
  margin: -50px auto 40px;
  padding: 0 20px;
  position: relative;
  z-index: 10;
}

.search-container {
  background: var(--white);
  border-radius: 20px;
  padding: 25px;
  box-shadow: var(--shadow);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.2);
}

.search-form {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 15px;
}

.form-group {
  position: relative;
}

.form-group i {
  position: absolute;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--primary);
  font-size: 1.1rem;
}

.search-input,
.search-select {
  width: 100%;
  padding: 15px 15px 15px 45px;
  border: 2px solid #eef2f7;
  border-radius: 12px;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  background: #f8fafd;
}

.search-input:focus,
.search-select:focus {
  border-color: var(--primary);
  outline: none;
  background: var(--white);
  box-shadow: 0 0 0 4px rgba(17,102,130,0.1);
}

.search-btn {
  background: var(--primary);
  color: var(--white);
  border: none;
  border-radius: 12px;
  padding: 15px 30px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  border: 2px solid transparent;
}

.search-btn:hover {
  background: var(--secondary);
  transform: translateY(-2px);
  box-shadow: var(--shadow-hover);
}

.search-btn i {
  font-size: 1.2rem;
}

/* Main Layout */
.main-container {
  max-width: 1400px;
  margin: 0 auto 60px;
  padding: 0 20px;
}

.content-wrapper {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 30px;
}

/* Filters Sidebar */
.filters-sidebar {
  background: var(--white);
  border-radius: 20px;
  padding: 25px;
  box-shadow: var(--shadow);
  height: fit-content;
  position: sticky;
  top: 20px;
}

.filters-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 2px solid #eef2f7;
}

.filters-header h3 {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--text-dark);
}

.clear-filters {
  color: var(--primary);
  font-size: 0.9rem;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s ease;
}

.clear-filters:hover {
  color: var(--secondary);
}

.filter-group {
  margin-bottom: 25px;
}

.filter-group h4 {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 15px;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-group h4 i {
  color: var(--primary);
}

.filter-options {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.filter-checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  font-size: 0.95rem;
  color: var(--text-light);
  transition: color 0.3s ease;
}

.filter-checkbox:hover {
  color: var(--primary);
}

.filter-checkbox input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: var(--primary);
  cursor: pointer;
}

/* Cars Slider Section */
.cars-section {
  background: var(--white);
  border-radius: 20px;
  padding: 25px;
  box-shadow: var(--shadow);
  width: 100%;
  overflow: hidden;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.section-header h2 {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 10px;
}

.section-header h2 i {
  color: var(--primary);
}

.results-count {
  background: #eef2f7;
  padding: 8px 16px;
  border-radius: 30px;
  font-size: 0.95rem;
  color: var(--text-dark);
  font-weight: 500;
}

/* Slider Container */
.slider-container {
  position: relative;
  width: 100%;
  overflow: hidden;
  padding: 0 5px;
}

.cars-slider {
  overflow: hidden !important;
  width: 100%;
  position: relative;
}

.slider-track {
  display: flex;
  gap: 25px;
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  width: max-content;
}

/* Car Card */
.car-card {
  flex: 0 0 500px;
  width: 500px !important;
  background: var(--white);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.4s ease;
  border: 1px solid rgba(0,0,0,0.05);
  position: relative;
}

.car-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-hover);
}

.car-badge {
  position: absolute;
  top: 15px;
  left: 15px;
  background: var(--primary);
  color: var(--white);
  padding: 6px 12px;
  border-radius: 30px;
  font-size: 0.8rem;
  font-weight: 600;
  z-index: 2;
  box-shadow: 0 4px 10px rgba(17,102,130,0.3);
  display: flex;
  align-items: center;
  gap: 5px;
}

.car-image-wrapper {
  position: relative;
  height: 200px;
  overflow: hidden;
}

.car-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.car-card:hover .car-image {
  transform: scale(1.1);
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
  opacity: 0;
  transition: opacity 0.4s ease;
}

.car-card:hover .image-overlay {
  opacity: 1;
}

.car-content {
  padding: 20px;
}

.car-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.car-name {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--text-dark);
  margin: 0;
}

.car-type {
  background: #eef2f7;
  padding: 4px 10px;
  border-radius: 30px;
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--primary);
}

.car-location {
  display: flex;
  align-items: center;
  gap: 5px;
  color: var(--text-light);
  font-size: 0.9rem;
  margin-bottom: 15px;
}

.car-location i {
  color: var(--primary);
  font-size: 0.9rem;
}

.car-features {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
  padding: 10px 0;
  border-top: 1px solid #eef2f7;
  border-bottom: 1px solid #eef2f7;
}

.feature {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 0.85rem;
  color: var(--text-light);
}

.feature i {
  color: var(--primary);
}

.car-price {
  display: flex;
  align-items: baseline;
  gap: 5px;
  margin-bottom: 15px;
}

.price-amount {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--primary);
}

.price-period {
  font-size: 0.9rem;
  color: var(--text-light);
}

.car-actions {
  display: flex;
  gap: 10px;
}

.btn-view,
.btn-book {
  flex: 1;
  padding: 12px;
  border-radius: 12px;
  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;
  text-align: center;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
}

.btn-view {
  background: #eef2f7;
  color: var(--text-dark);
  border: 1px solid transparent;
}

.btn-view:hover {
  background: #e2e8f0;
  transform: translateY(-2px);
}

.btn-book {
  background: var(--primary);
  color: var(--white);
  border: 1px solid transparent;
}

.btn-book:hover {
  background: var(--secondary);
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(17,102,130,0.3);
}

/* Slider Controls */
.slider-controls {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 30px;
}

.slider-btn {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  background: var(--white);
  border: 2px solid #eef2f7;
  color: var(--primary);
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
}

.slider-btn:hover:not(:disabled) {
  background: var(--primary);
  border-color: var(--primary);
  color: var(--white);
  transform: scale(1.1);
}

.slider-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.slider-dots {
  display: flex;
  gap: 8px;
  justify-content: center;
  margin-top: 20px;
}

.dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #eef2f7;
  cursor: pointer;
  transition: all 0.3s ease;
}

.dot.active {
  background: var(--primary);
  width: 25px;
  border-radius: 10px;
}

/* No Results */
.no-results {
  text-align: center;
  padding: 60px 20px;
}

.no-results i {
  font-size: 4rem;
  color: var(--primary);
  opacity: 0.5;
  margin-bottom: 20px;
}

.no-results h3 {
  font-size: 1.5rem;
  color: var(--text-dark);
  margin-bottom: 10px;
}

.no-results p {
  color: var(--text-light);
}

/* Responsive */
@media (max-width: 1200px) {
  .car-card {
    flex: 0 0 300px;
    width: 300px;
  }
}

@media (max-width: 900px) {
  .hero h1 {
    font-size: 3rem;
  }
  
  .hero p {
    font-size: 1.2rem;
  }
  
  .content-wrapper {
    grid-template-columns: 1fr;
  }
  
  .filters-sidebar {
    position: static;
    margin-bottom: 20px;
  }
  
  .car-card {
    flex: 0 0 280px;
    width: 280px;
  }
}

@media (max-width: 600px) {
  .hero h1 {
    font-size: 2rem;
  }
  
  .search-container {
    padding: 15px;
  }
  
  .section-header {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }
  
  .car-card {
    flex: 0 0 260px;
    width: 260px;
  }
}

#car-results {
  width: 100%;
  overflow: hidden;
}
</style>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1>Car Rentals</h1>
    <p>Discover the perfect vehicle for your journey</p>
  </div>
</section>

<!-- Search Section -->
<div class="search-section">
  <div class="search-container">
    <form id="carSearchForm" class="search-form">
      <div class="form-group">
        <i class="fas fa-map-marker-alt"></i>
        <input type="text" class="search-input" name="location" placeholder="Pickup Location" value="{{ request('location') }}">
      </div>
      
      <div class="form-group">
        <i class="fas fa-calendar"></i>
        <input type="date" class="search-input" name="pickup_date" value="{{ request('pickup_date') }}">
      </div>
      
      <div class="form-group">
        <i class="fas fa-calendar-check"></i>
        <input type="date" class="search-input" name="return_date" value="{{ request('return_date') }}">
      </div>
      
      <div class="form-group">
        <i class="fas fa-car"></i>
        <select name="type" class="search-select">
          <option value="">Car Type</option>
          <option value="Economy" {{ request('type')=='Economy' ? 'selected' : '' }}>Economy</option>
          <option value="SUV" {{ request('type')=='SUV' ? 'selected' : '' }}>SUV</option>
          <option value="Luxury" {{ request('type')=='Luxury' ? 'selected' : '' }}>Luxury</option>
          <option value="Van" {{ request('type')=='Van' ? 'selected' : '' }}>Van</option>
        </select>
      </div>
      
      <button type="submit" class="search-btn">
        <i class="fas fa-search"></i>
        Search Cars
      </button>
    </form>
  </div>
</div>

<!-- Main Content -->
<div class="main-container">
  <div class="content-wrapper">
    <!-- Filters Sidebar -->
    <aside class="filters-sidebar">
      <div class="filters-header">
        <h3><i class="fas fa-sliders-h"></i> Filters</h3>
        <a href="#" class="clear-filters" id="clearFilters">Clear all</a>
      </div>
      
      <div class="filter-group">
        <h4><i class="fas fa-cog"></i> Transmission</h4>
        <div class="filter-options">
          <label class="filter-checkbox">
            <input type="checkbox" class="filter-checkbox-input" name="transmission[]" value="Automatic">
            <span>Automatic</span>
          </label>
          <label class="filter-checkbox">
            <input type="checkbox" class="filter-checkbox-input" name="transmission[]" value="Manual">
            <span>Manual</span>
          </label>
        </div>
      </div>
      
      <div class="filter-group">
        <h4><i class="fas fa-user"></i> Driver</h4>
        <div class="filter-options">
          <label class="filter-checkbox">
            <input type="checkbox" class="filter-checkbox-input" name="with_driver" value="1">
            <span>With Driver</span>
          </label>
        </div>
      </div>
    </aside>

    <!-- Cars Slider Section -->
    <div class="cars-section">
      <div class="section-header">
        <h2>
          <i class="fas fa-car"></i>
          Available Cars
        </h2>
        <span class="results-count" id="resultsCount">{{ count($cars) }} vehicles found</span>
      </div>

      <div id="car-results">
        @include('indexes.partials.car_results')
      </div>
    </div>
  </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    let currentIndex = 0;
    let visibleCards = 3;
    let totalCards = 0;
    let cardWidth = 0;
    let autoSlideInterval;

    function updateVisibleCards() {
        if ($(window).width() <= 900) {
            visibleCards = 1;
        } else if ($(window).width() <= 1200) {
            visibleCards = 2;
        } else {
            visibleCards = 3;
        }
    }

    function initSlider() {
        totalCards = $('.car-card').length;
        
        if (totalCards === 0) return;
        
        updateVisibleCards();
        
        const sliderTrack = $('.slider-track');
        const firstCard = $('.car-card').first();
        
        if (firstCard.length) {
            cardWidth = firstCard.outerWidth(true);
            
            sliderTrack.css({
                'gap': '25px',
                'width': (totalCards * (cardWidth + 25)) + 'px'
            });
        }
        
        updateSliderControls();
        startAutoSlide();
    }

    function updateSliderControls() {
        const maxIndex = Math.max(0, totalCards - visibleCards);
        
        $('.prev-btn').prop('disabled', currentIndex <= 0);
        $('.next-btn').prop('disabled', currentIndex >= maxIndex);
        
        const dotsCount = Math.ceil(totalCards / visibleCards);
        let dotsHtml = '';
        for (let i = 0; i < dotsCount; i++) {
            dotsHtml += `<span class="dot ${i === Math.floor(currentIndex / visibleCards) ? 'active' : ''}" data-index="${i * visibleCards}"></span>`;
        }
        $('.slider-dots').html(dotsHtml);
    }

    function slideTo(index) {
        if (index < 0) index = 0;
        const maxIndex = Math.max(0, totalCards - visibleCards);
        if (index > maxIndex) index = maxIndex;
        
        currentIndex = index;
        const translateX = -currentIndex * (cardWidth + 25);
        $('.slider-track').css('transform', `translateX(${translateX}px)`);
        
        updateSliderControls();
    }

    function slideNext() {
        slideTo(currentIndex + 1);
    }

    function slidePrev() {
        slideTo(currentIndex - 1);
    }

    function startAutoSlide() {
        stopAutoSlide();
        if (totalCards > visibleCards) {
            autoSlideInterval = setInterval(() => {
                if (currentIndex >= totalCards - visibleCards) {
                    slideTo(0);
                } else {
                    slideNext();
                }
            }, 2000);
        }
    }

    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
    }

    function initializeCarSlider() {
        setTimeout(() => {
            if ($('.car-card').length > 0) {
                initSlider();
            }
        }, 100);
    }

    function fetchCars() {
        let transmission = [];
        $('input[name="transmission[]"]:checked').each(function() {
            transmission.push($(this).val());
        });
        
        let driver = $('input[name="with_driver"]:checked').val();

        $.ajax({
            url: "{{ route('car.search') }}",
            type: "GET",
            data: {
                transmission: transmission,
                with_driver: driver,
                location: $('input[name="location"]').val(),
                pickup_date: $('input[name="pickup_date"]').val(),
                return_date: $('input[name="return_date"]').val(),
                type: $('select[name="type"]').val()
            },
            success: function(data) {
                $('#car-results').html(data);
                $('#resultsCount').text($('.car-card').length + ' vehicles found');
                stopAutoSlide();
                currentIndex = 0;
                initializeCarSlider();
            },
            error: function() {
                $('#car-results').html('<div class="no-results"><i class="fas fa-car"></i><h3>No cars available</h3><p>Try adjusting your filters</p></div>');
            }
        });
    }

    // Event Listeners
    $('#carSearchForm').on('submit', function(e) {
        e.preventDefault();
        fetchCars();
    });

    $('input[name="transmission[]"], input[name="with_driver"]').on('change', function() {
        if ($(this).attr('name') === 'transmission[]') {
            $('input[name="transmission[]"]').not(this).prop('checked', false);
        }
        fetchCars();
    });

    $('select[name="type"], input[name="location"], input[name="pickup_date"], input[name="return_date"]').on('change', function() {
        fetchCars();
    });

    $('#clearFilters').on('click', function(e) {
        e.preventDefault();
        $('input[name="transmission[]"]').prop('checked', false);
        $('input[name="with_driver"]').prop('checked', false);
        fetchCars();
    });

    // Button click handlers
    $(document).on('click', '.prev-btn', function() {
        if (!$(this).prop('disabled')) {
            stopAutoSlide();
            slidePrev();
            startAutoSlide();
        }
    });

    $(document).on('click', '.next-btn', function() {
        if (!$(this).prop('disabled')) {
            stopAutoSlide();
            slideNext();
            startAutoSlide();
        }
    });

    $(document).on('click', '.dot', function() {
        stopAutoSlide();
        const targetIndex = parseInt($(this).data('index'));
        slideTo(targetIndex);
        startAutoSlide();
    });

    // Initialize on page load
    initializeCarSlider();

    // Handle window resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if ($('.car-card').length > 0) {
                stopAutoSlide();
                updateVisibleCards();
                initSlider();
                slideTo(currentIndex);
                startAutoSlide();
            }
        }, 250);
    });

    // Hover pause for auto-slide
    $(document).on('mouseenter', '.cars-slider', stopAutoSlide);
    $(document).on('mouseleave', '.cars-slider', startAutoSlide);
});
</script>

@endsection