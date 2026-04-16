<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\FlightBookingController;
use App\Http\Controllers\HotelBookingController; 
use App\Http\Controllers\VisaAssistanceController;
use App\Http\Controllers\CarRentalController;
use App\Http\Controllers\TourBookingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ChatController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

// ================== PUBLIC ROUTES ==================
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/filter-packages', [HomeController::class, 'filter']);

Route::get('index_layout', function(){
    return view('layouts.index_layout');
});

Route::get('/flight_booking', function () {
    return view('indexes.flight_booking');
})->name('flight_booking');

Route::get('/hotel_booking', function () {
    return view('indexes.hotel');
})->name('hotel_booking');

// Disable public registration
Auth::routes(['register' => false]); // login route exists

// ================== ADMIN ACCESS ==================

// /admin route: show login if guest, dashboard if admin
Route::get('/admin', function () {
    if (!Auth::check()) {
        return view('auth.login'); // guest sees login page
    }

    if ((int) Auth::user()->user_type !== 1) {
        Auth::logout();
        return redirect()->route('login');
    }

    return redirect()->route('admin.dashboard'); // admin sees dashboard
});
// ================== DASHBOARD ==================
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// ================== ADMIN ROUTES (PROTECTED) ==================
Route::middleware([AdminMiddleware::class])->group(function() {

    
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::post('/admin/update-status', [AdminController::class, 'updateStatus'])->name('admin.update.status');
    
    // Flight & hotel bookings
    Route::get('/admin/flight-bookings', [AdminController::class, 'flightBookings'])->name('admin.flight.bookings');
    Route::patch('/admin/flight-bookings/{booking}/status', [AdminController::class, 'updateflightStatus'])->name('admin.flight.status');
    Route::delete('/admin/flight-bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('admin.flight.delete');
    Route::get('/admin/flight-bookings/export', [AdminController::class, 'exportPDF'])->name('admin.flight.export');

    Route::get('/admin/hotel-bookings', [AdminController::class, 'hotelBookings'])->name('admin.hotel.bookings');
    Route::get('/admin/hotel-bookings/{id}', [AdminController::class, 'viewhotelBooking'])->name('admin.hotel.view');
    Route::patch('/admin/hotel-bookings/{booking}/status', [AdminController::class, 'updateHotelStatus'])->name('admin.hotel.update.status');
    Route::delete('/admin/hotel-bookings/{id}', [AdminController::class, 'deletehotelBooking'])->name('admin.hotel.delete');
    
   // Visa applications
    Route::get('/visa-applications', [AdminController::class,'visaApplications'])->name('admin.visa.applications');
    Route::get('/visa/{id}', [AdminController::class,'viewVisa'])->name('admin.visa.view');
    Route::delete('/visa/{id}', [AdminController::class,'deleteVisa'])->name('admin.visa.delete');
    Route::post('/admin/visa/{id}/update-status', [AdminController::class, 'updateVisaStatus'])->name('admin.visa.update-status');
    Route::get('/admin/visa-export', [AdminController::class,'exportVisaPDF'])->name('admin.visa.export');
    Route::get('/admin/visa-export-excel', [AdminController::class,'exportVisaExcel'])->name('admin.visa.export.excel');
    Route::post('/admin/visa/{id}/assign-agent', [AdminController::class,'assignAgent'])->name('admin.visa.assign.agent');

Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

Route::get('/admin/chat', [AdminController::class, 'adminChat'])->name('admin.chat');
    // Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/cardashboard', [AdminController::class, 'cardashboard'])->name('cardashboard');
    
    // Car Bookings
    Route::get('/car-bookings', [AdminController::class, 'carBookings'])->name('car.bookings');
    Route::get('/car-booking/{id}', [AdminController::class, 'carBookingDetails'])->name('car.booking.details');
    Route::put('/car-booking/{id}/status', [AdminController::class, 'updateCarBookingStatus'])->name('car.booking.status');
    Route::delete('/car-booking/{id}', [AdminController::class, 'deleteCarBooking'])->name('car.booking.delete');
    
    // Invoice Routes
    Route::get('/car-booking/{id}/invoice', [AdminController::class, 'viewInvoice'])->name('car.booking.invoice.view');
    Route::get('/car-booking/{id}/invoice/download', [AdminController::class, 'generateInvoice'])->name('car.booking.invoice.download');
    Route::post('/car-booking/{id}/invoice/send', [AdminController::class, 'sendInvoiceEmail'])->name('car.booking.invoice.send');
    
    // Bulk Actions
    Route::post('/car-bookings/bulk', [AdminController::class, 'bulkAction'])->name('car.bookings.bulk');
    
    // Export
    Route::get('/car-bookings/export', [AdminController::class, 'exportBookings'])->name('car.bookings.export');
    
    // Cars Management
   
});
// Admin Tour Routes
Route::prefix('admin')->group(function () {
 Route::get('/admin/hotel-bookings/export-pdf', [AdminController::class, 'exportHotelPDF'])->name('admin.hotel.export');
   // Visa applications
    Route::get('/tour-bookings', [AdminController::class, 'tourBookings'])->name('admin.tours');

    Route::get('/tour-booking/{id}', [AdminController::class, 'viewTour'])->name('admin.tour.view');

    Route::post('/tour-booking/{id}/status', [AdminController::class, 'updateTourStatus'])->name('admin.tour.status');

    Route::delete('/tour-booking/{id}', [AdminController::class, 'deleteTour'])->name('admin.tour.delete');

});
Route::get('/admin/tours/pdf', [AdminController::class, 'toursPdf'])->name('admin.tours.pdf');
// routes/web.php
Route::get('/admin/tour/{id}/pdf', [AdminController::class, 'tourPdf'])->name('admin.tour.pdf.single');
   Route::prefix('admin')->group(function () {

    // Packages
    Route::get('/packages', [AdminController::class, 'packages'])->name('admin.packages');
    Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('admin.packages.create');
    Route::post('/packages/store', [AdminController::class, 'storePackage'])->name('admin.packages.store');
    Route::get('/packages/edit/{id}', [AdminController::class, 'editPackage'])->name('admin.packages.edit');

    Route::put('/packages/update/{id}', [AdminController::class, 'updatePackage'])->name('admin.packages.update');

    Route::delete('/packages/delete/{id}', [AdminController::class, 'deletePackage'])->name('admin.packages.delete');
});
 });

// ================== CAR ADMIN ROUTES ==================
Route::prefix('admin')->name('admin.')->middleware([AdminMiddleware::class])->group(function() {
    // Cars
    Route::get('/cars', [AdminController::class, 'carsIndex'])->name('cars.index');
    Route::get('/cars/create', [AdminController::class, 'carsCreate'])->name('cars.create');
    Route::post('/cars/store', [AdminController::class, 'carsStore'])->name('cars.store');
    Route::get('/cars/{car}/edit', [AdminController::class, 'carsEdit'])->name('cars.edit');
    Route::put('/cars/{car}/update', [AdminController::class, 'updateCar'])->name('cars.update'); // <== matches your controller
    Route::delete('/cars/{car}/delete', [AdminController::class, 'carsDestroy'])->name('cars.destroy');

   
    
    });

// ================== OTHER PUBLIC ROUTES ==================
Route::post('/flight-booking', [FlightBookingController::class, 'store'])->name('flight.book');
Route::post('/hotel-booking', [HotelBookingController::class, 'store'])->name('hotel.book');
Route::get('/hotel-booking/confirmation/{id}', [HotelBookingController::class, 'confirmation'])->name('hotel.confirmation');
Route::get('/hotel-booking/pdf/{id}', [HotelBookingController::class, 'downloadPdf'])->name('hotel.download.pdf');

Route::get('/visa-assistance', [VisaAssistanceController::class, 'showForm'])->name('visa.form');
Route::post('/visa-assistance', [VisaAssistanceController::class, 'submitForm'])->name('visa.assist');
Route::get('/visa-assistance/thank-you/{id}', [VisaAssistanceController::class, 'thankYou']);
Route::get('/visa-checklist/pdf/{visaRequest}', [VisaAssistanceController::class, 'downloadChecklist'])->name('visa.download.pdf');

Route::get('/extra-guidance', function () { return view('indexes.extra-guidance'); })->name('extra.guidance');
Route::get('/car-rentals', [CarRentalController::class, 'index'])->name('car.rentals');
Route::get('/car/{id}', [CarRentalController::class,'show'])->name('car.details');
Route::post('/car-book', [CarRentalController::class,'book'])->name('car.book');

Route::get('/car-book/{id}', [CarRentalController::class, 'bookForm'])->name('car.book.form');
Route::get('/car-search', [CarRentalController::class,'search'])->name('car.search');


// Show tour booking form
Route::get('/tour-booking', [TourBookingController::class, 'create'])->name('tour.form');

// Submit form
Route::post('/tour-booking', [TourBookingController::class, 'store'])->name('tour.book');

// Success page
Route::get('/tour-booking-success/{id}', [TourBookingController::class, 'success'])->name('tour.success');
Route::get('/packages', function () {
    return view('packages.index');
})->name('packages.index');
Route::get('/packages/{package:slug}', [PackageController::class, 'show'])
    ->name('packages.show');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

Route::post('/chat/send', [ChatController::class, 'send']);

Route::prefix('admin')->middleware([AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
    Route::get('/clients/create', [AdminController::class, 'createClient'])->name('clients.create');
    Route::post('/clients/store', [AdminController::class, 'storeClient'])->name('clients.store');
    Route::get('/clients/{phone}', [AdminController::class, 'showClient'])->name('clients.show');
    Route::get('/clients/{phone}/edit', [AdminController::class, 'editClient'])->name('clients.edit');
    Route::put('/clients/{phone}/update', [AdminController::class, 'updateClient'])->name('clients.update');
    Route::delete('/clients/{phone}/delete', [AdminController::class, 'deleteClient'])->name('clients.delete');
});