<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelBooking;
use Barryvdh\DomPDF\Facade\Pdf; // For PDF generation

class HotelBookingController extends Controller
{
    // Store the booking
    public function store(Request $request)
    {
        // ✅ Validate request
        $validated = $request->validate([
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'email'             => 'required|email',
            'phone'             => 'required|string|max:20',
            'location'          => 'required|string|max:150',
            'hotel_category'    => 'required|string',
            'check_in'          => 'required|date',
            'check_out'         => 'required|date|after:check_in',
            'guests'            => 'required|integer|min:1',
            'rooms'             => 'required|integer|min:1',
            'room_type'         => 'nullable|string',
            'preferred_hotel'   => 'nullable|string|max:150',
            'notes'             => 'nullable|string',
        ]);

        // ✅ Store booking
        $booking = HotelBooking::create($validated);

        // ✅ Redirect to confirmation page
        return redirect()->route('hotel.confirmation', $booking->id);
    }

    // Show confirmation page
    public function confirmation($id)
    {
        $booking = HotelBooking::findOrFail($id);
        return view('indexes.hotel_confirmation', compact('booking'));
    }

    // Download PDF confirmation
    public function downloadPdf($id)
    {
        $booking = HotelBooking::findOrFail($id);
        $pdf = Pdf::loadView('pdf.hotel_reservation', compact('booking'));

        $filename = 'Hotel_Reservation_' . $booking->first_name . '_' . $booking->last_name . '.pdf';
        return $pdf->download($filename);
    }
    public function showForm()
{
    return response()
        ->view('indexes.hotel_form') // your form view
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
}

}
