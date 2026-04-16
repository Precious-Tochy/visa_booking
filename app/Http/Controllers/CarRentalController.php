<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Car;
use App\Models\CarBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CarRentalController extends Controller
{
    // Show all cars
    public function index()
    {
        $cars = Car::latest()->get();
        return view('indexes.car_rentals', compact('cars'));
    }

    // Show single car details
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('indexes.car_details', compact('car'));
    }
    public function bookForm($id) {
    $car = Car::findOrFail($id);
    return view('indexes.car_book', compact('car'));
}

    // Handle booking
    public function book(Request $request)
{
    \Log::info('Booking attempt:', $request->all());

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'pickup_location' => 'required',
        'pickup_date' => 'required|date|after_or_equal:today',
        'pickup_time' => 'required',
        'return_date' => 'required|date|after_or_equal:pickup_date'
    ]);

    $car = Car::findOrFail($request->car_id);

    $pickup = Carbon::parse($request->pickup_date);
    $return = Carbon::parse($request->return_date);

    $days = $pickup->diffInDays($return);
    if ($days == 0) {
        $days = 1;
    }

    if ($days > 30) {
        Alert::error('Booking Failed', 'Maximum booking period is 30 days.');
        return back();
    }

    $total = $days * $car->price_per_day;

    if ($request->has('with_driver')) {
        $total += 10000;
    }

    CarBooking::create([
        'car_id' => $car->id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'pickup_location' => $request->pickup_location,
        'pickup_date' => $request->pickup_date,
        'pickup_time' => $request->pickup_time,
        'return_date' => $request->return_date,
        'with_driver' => $request->has('with_driver') ? 1 : 0,
        'total_price' => $total,
        'status' => 'pending',
        'booking_reference' => 'CRB' . str_pad(CarBooking::max('id') + 1, 6, '0', STR_PAD_LEFT),
    ]);

    Alert::success(
        'Booking Confirmed!',
        'Your car booking has been submitted successfully. A confirmation email will be sent to your email address.'
    )->showConfirmButton('Okay', '#3085d6')->autoClose(8000);

    return redirect()->route('car.rentals');
}

    // Handle search + filters
  public function search(Request $request)
{
    $cars = Car::query();

    // Filter by location
    if ($request->filled('location')) {
        $cars->where('location', 'LIKE', "%{$request->location}%");
    }

    // Filter by type
    if ($request->filled('type')) {
        $cars->where('type', $request->type);
    }

    // Filter by transmission
    if ($request->filled('transmission')) {
        $cars->where('transmission', $request->transmission);
    }

    // Filter by availability (pickup and return dates)
    if ($request->filled('pickup_date') && $request->filled('return_date')) {
        $pickup = $request->pickup_date;
        $return = $request->return_date;

        // Exclude cars already booked in that date range
        $cars->whereDoesntHave('bookings', function($query) use ($pickup, $return) {
            $query->where(function($q) use ($pickup, $return) {
                $q->whereBetween('pickup_date', [$pickup, $return])
                  ->orWhereBetween('return_date', [$pickup, $return])
                  ->orWhere(function($q2) use ($pickup, $return) {
                      $q2->where('pickup_date', '<', $pickup)
                         ->where('return_date', '>', $return);
                  });
            });
        });
    }

    $cars = $cars->get();

    if ($request->ajax()) {
        return view('indexes.partials.car_results', compact('cars'))->render();
    }

    return view('indexes.car_rentals', compact('cars'));
}

}