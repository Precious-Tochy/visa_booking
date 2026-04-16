<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TourBooking;

class TourBookingController extends Controller
{
    // Show form
    public function create()
    {
        return view('indexes.guided_tour'); // create a new Blade file for the form
    }

    // Handle POST submission
    public function store(Request $request)
    {
        $booking = TourBooking::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'package' => $request->package,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'travelers' => $request->travelers,
            'budget' => $request->budget,
            'travel_style' => $request->travel_style,
            'hotel' => $request->hotel,
            'activities' => json_encode($request->activities),
            'notes' => $request->notes
        ]);

        return redirect()->route('tour.success', $booking->id);
    }

    // Show success page
    public function success($id)
    {
        $booking = TourBooking::findOrFail($id);
        return view('tour.success', compact('booking'));
    }
}