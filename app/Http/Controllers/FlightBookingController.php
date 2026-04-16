<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use Illuminate\Support\Facades\Mail;

class FlightBookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'passport_number' => 'nullable|string|max:50',
            'departure_city' => 'required|string|max:255',
            'destination_city' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date',
            'trip_type' => 'required|string',
            'passengers' => 'required|integer|min:1',
            'class' => 'required|string',
            'airline' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $booking = FlightBooking::create($data);

        $emailData = [
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'departure_city' => $data['departure_city'],
            'destination_city' => $data['destination_city'],
            'departure_date' => $data['departure_date'],
            'return_date' => $data['return_date'] ?? 'N/A',
            'trip_type' => $data['trip_type'],
            'passengers' => $data['passengers'],
            'class' => $data['class'],
            'airline' => $data['airline'] ?? 'N/A',
            'notes' => $data['notes'] ?? 'N/A',
        ];

        // Client email
        Mail::send('emails.client_booking_confirmation', $emailData, function($message) use ($data){
            $message->to($data['email'])
                    ->subject('Flight Booking Confirmation - Tochy Travels');
        });

        // Admin email
        Mail::send('emails.admin_booking_notification', $emailData, function($message){
            $message->to('preciousabugu38@gmail.com')
                    ->subject('New Flight Booking Received');
        });

        return redirect()->back()->with([
            'success' => 'Your flight booking request has been successfully submitted. Our travel agent will contact you shortly.',
            'booking' => $emailData
        ]);
    }

    
}
