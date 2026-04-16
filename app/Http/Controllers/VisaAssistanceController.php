<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Http\Request;
use App\Models\VisaRequest;

class VisaAssistanceController extends Controller
{
    // Show the form
    public function showForm()
    {
        return view('indexes.visa-assistance');
    }

    // Handle submission
    public function submitForm(Request $request)
    {
        $data = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:50',
            'visa_type'       => 'required|string|max:50',
            'country'         => 'required|string|max:100',
            'occupation'      => 'nullable|string|max:255',
            'travel_history'  => 'nullable|string|max:255',
            'consultation'    => 'nullable|string|max:50',
            'notes'           => 'nullable|string',
        ]);

        $visaRequest = VisaRequest::create($data);

        // Send Email
        \Mail::to($visaRequest->email)->send(new \App\Mail\VisaConfirmationMail($visaRequest));

        // Return JSON for SweetAlert AJAX
        return response()->json([
            'status' => 'success',
            'visa' => $visaRequest
        ]);
    }

    // Thank you / upsell page
    public function thankYou($id)
    {
        $visaRequest = VisaRequest::findOrFail($id);

        $checklistData = [
            'tourist' => ["Passport", "Photos", "Bank Statement", "Travel Itinerary", "Hotel Reservation", "Flight Reservation"],
            'study' => ["Passport", "Admission Letter", "Academic Certificates", "Bank Statement", "Language Proof (IELTS/TOEFL)"],
            'work' => ["Passport", "Offer Letter", "CV", "Professional Certificates", "Police Clearance"],
            'business' => ["Passport", "Invitation Letter", "Company Documents", "Bank Statement", "Business Profile"],
            'transit' => ["Passport", "Confirmed Flight", "Visa for Final Destination if needed"]
        ];

        $checklist = $checklistData[$visaRequest->visa_type] ?? [];

        return view('visa-thankyou', compact('visaRequest','checklist'));
    }
 

public function downloadChecklist(VisaRequest $visaRequest)
{
    $checklists = [
        'tourist' => ["Passport", "Photos", "Bank Statement", "Travel Itinerary", "Hotel Reservation", "Flight Reservation"],
        'study'   => ["Passport", "Admission Letter", "Academic Certificates", "Bank Statement", "Language Proof (IELTS/TOEFL)"],
        'work'    => ["Passport", "Offer Letter", "CV", "Professional Certificates", "Police Clearance"],
        'business'=> ["Passport", "Invitation Letter", "Company Documents", "Bank Statement", "Business Profile"],
        'transit' => ["Passport", "Confirmed Flight", "Visa for Final Destination if needed"]
    ];

    $additionals = [
        'study' => ["Scholarship letters (if any)", "Motivation Letter", "Financial Sponsorship Documents"],
        'tourist' => ["Travel Insurance", "Hotel Bookings Confirmation"],
        'work' => ["Work Contract Translation", "Employer Recommendation Letter"],
        'business' => ["Invitation Letter from Partner Company", "Business Plan Summary"],
        'transit' => ["Visa for connecting countries if needed"]
    ];

    $visa_type = $visaRequest->visa_type;

    $pdf = Pdf::loadView('pdf.visa-checklist', [
        'visa_type' => $visa_type,
        'checklist' => $checklists[$visa_type] ?? [],
        'additional' => $additionals[$visa_type] ?? []
    ]);

    return $pdf->download($visa_type . '-visa-checklist.pdf');
}

}
