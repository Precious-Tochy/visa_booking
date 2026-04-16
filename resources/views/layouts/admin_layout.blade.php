<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Tochy Travels Admin Dashboard')</title>

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('visa-booking/css/bootstrap.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* ========== GENERAL STYLING ========== */
body {
    font-family: 'Arial', sans-serif;
    background: #f5f7fa;
    color: #1f2937;
    margin: 0;
}
a { text-decoration: none; }
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 260px;
    background: linear-gradient(180deg, #115e82 0%, #116682 100%);
    color: #fff;
    padding-top: 20px;
    transition: width 0.3s ease;
    z-index: 1000;

    /* NEW */
    overflow-y: auto;      /* vertical scroll if content overflows */
    scrollbar-width: thin; /* for Firefox */
}

/* Optional: custom scrollbar for Chrome/Edge */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.3);
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

/* ========== SIDEBAR ========== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 260px;
    background: linear-gradient(180deg, #115e82 0%, #116682 100%);
    color: #fff;
    padding-top: 20px;
    transition: width 0.3s ease;
    z-index: 1000;
}
.sidebar.collapsed { width: 80px; }
.sidebar .brand {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}
.sidebar .brand img {
    width: 50px;
    border-radius: 50%;
    margin-right: 15px;
}
.sidebar .menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar .menu li {
    padding: 10px 25px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: background 0.2s ease;
}
.sidebar .menu li:hover {
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
}
.sidebar .menu li i {
    font-size: 20px;
    margin-right: 15px;
}
 .menu li  a {
   color: #fff !important;
}
.sidebar .menu li span {
    font-weight: 500;
}

/* ========== TOP NAVBAR ========== */
.topbar {
    position: fixed;
    top: 0;
    left: 260px;
    right: 0;
    height: 70px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: left 0.3s ease;
    z-index: 900;
}
.topbar.collapsed { left: 80px; }

/* Profile section */
.topbar .profile {
    display: flex;
    align-items: center;
}
.topbar .profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

/* ========== MAIN CONTENT ========== */
.main-content {
    margin-left: 260px;
    margin-top: 70px;
    padding: 30px;
    transition: margin-left 0.3s ease;
}
.main-content.collapsed { margin-left: 80px; }

/* ========== DASHBOARD CARDS ========== */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}
.card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}
.card:hover { transform: translateY(-6px); }
.card h3 { font-size: 1.2rem; margin-bottom: 10px; color: #115e82; }
.card p { font-size: 1.6rem; font-weight: 600; margin: 0; }

/* ========== TABLES ========== */
.table-container {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    padding: 20px;
    overflow-x: auto;
}
.table-container table {
    width: 100%;
    border-collapse: collapse;
}
.table-container th, .table-container td {
    padding: 12px 15px;
    text-align: left;
}
.table-container th {
    background: #115e82;
    color: #fff;
    font-weight: 600;
}
.table-container tr:nth-child(even) { background: #f5f7fa; }
.table-container tr:hover { background: #e6f2fa; }
.topbar i{
    display: none !important;
}

/* ========== RESPONSIVE ========== */
/* ================= RESPONSIVE ================= */

@media (max-width: 1200px) {

    .cards {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    }

}

@media (max-width: 992px) {

    .sidebar {
        width: 220px;
    }

    .topbar {
        left: 220px;
    }

    .main-content {
        margin-left: 220px;
    }
    .topbar i{
    display: block !important;
}


}

@media (max-width: 768px) {

    /* Sidebar becomes hidden by default */
    .sidebar {
        left: -260px;
        width: 260px;
    }

    .sidebar.active {
        left: 0;
    }

    /* Topbar full width */
    .topbar {
        left: 0;
        width: 100%;
    }

    /* Content full width */
    .main-content {
        margin-left: 0;
        padding: 20px;
    }

    /* Cards stack */
    .cards {
        grid-template-columns: 1fr;
    }

    /* Tables scroll */
    .table-container {
        overflow-x: auto;
    }
    .topbar i{
    display:  block!important;
}


}

@media (max-width: 480px) {

    .topbar h2 {
        font-size: 24px;
        margin-top: 5px;
    }

    .sidebar .brand span {
        display: none;
    }
.topbar i{
    display: block !important;
}

}
.sidebar {
    transition: all 0.3s ease;
}

.sidebar.active {
    left: 0;
}

.sidebar.hidden {
    left: -260px;
}
</style>

@stack('styles')

</head>
<body>
@include('sweetalert::alert')
<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Logo">
        <span>Tochy Travels</span>
    </div>
    <ul class="menu">
   <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="ri-dashboard-line"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.flight.bookings') }}">
            <i class="ri-flight-takeoff-line"></i>
            <span>Flight Bookings</span>
        </a>
    </li>
    <li><a href="{{route('admin.hotel.bookings')}}"><i class="ri-hotel-line"></i><span>Hotel Reservations</span></a></li>
    <li>
<a href="{{ route('admin.visa.applications') }}">
<i class="ri-file-paper-2-line"></i>
<span>Visa Applications</span>
</a>
</li>
   <li class="nav-item">

<a class="nav-link" data-bs-toggle="collapse" href="#carsMenu">

<i class="ri-car-line"></i>

<span>Car Rentals</span>

<i class="ri-arrow-down-s-line float-end"></i>

</a>

<ul class="collapse list-unstyled" id="carsMenu">

<li>
    <a href="{{ route('admin.car.bookings') }}">
        <i class="fas fa-calendar-check"></i> Car Bookings
    </a>
</li>


<li>
<a href="{{ route('admin.cars.index') }}">
Car Management
</a>
</li>

</ul>

<li class="{{ request()->is('admin/tour*') ? 'active' : '' }}">
    <a href="{{ route('admin.tours') }}">
        <i class="ri-map-2-line"></i>
        <span>Guided Tour</span>
    </a>
</li>
      <li>
    <a href="{{ route('admin.packages') }}">
         <i class="ri-earth-line"></i>
        <span>Tour Packages</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.chat') }}">
        <i class="ri-message-3-line"></i>
        <span>Chat Messages</span>
    </a>
</li>
    <li class="{{ request()->is('admin/clients*') ? 'active' : '' }}">
    <a href="{{ route('admin.clients') }}">
        <i class="ri-account-circle-line"></i>
        <span>Clients</span>
    </a>
</li>
   <li>
    <a href="{{ route('admin.settings') }}">
        <i class="ri-settings-3-line"></i>
        <span>Settings</span>
    </a>
</li>

    <!-- Logout -->
    <li>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="color: white; display:flex; align-items:center;">
            <i class="ri-logout-box-line"></i>
            <span style=";">Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </li>
</ul>
</div>
<div class="topbar" id="topbar">
    <div style="display:flex; align-items:center; gap:15px;">
        <i class="ri-menu-line" id="menu-toggle" style="font-size:24px; cursor:pointer;"></i>
        <h2>@yield('page-title', 'Dashboard')</h2>
    </div>

    <div class="profile">
        <img src="{{ asset('visa-booking/image/profile.jpg') }}" alt="Admin">
    </div>
</div>
<!-- TOPBAR -->

<!-- MAIN CONTENT -->
<div class="main-content" id="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script>
document.getElementById("menu-toggle").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("active");
});
</script>
</body>
</html>