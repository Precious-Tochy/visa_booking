<?php

namespace App\Mail;

use App\Models\VisaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisaConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visaRequest;

    public function __construct(VisaRequest $visaRequest)
    {
        $this->visaRequest = $visaRequest;
    }

    public function build()
    {
        $checklist = [
            'tourist' => ["Passport", "Photos", "Bank Statement", "Travel Itinerary", "Hotel Reservation", "Flight Reservation"],
            'study' => ["Passport", "Admission Letter", "Academic Certificates", "Bank Statement", "Language Proof (IELTS/TOEFL)"],
            'work' => ["Passport", "Offer Letter", "CV", "Professional Certificates", "Police Clearance"],
            'business' => ["Passport", "Invitation Letter", "Company Documents", "Bank Statement", "Business Profile"],
            'transit' => ["Passport", "Confirmed Flight", "Visa for Final Destination if needed"]
        ];

        return $this->subject('Your Visa Request Confirmation')
                    ->view('emails.visa-confirmation')
                    ->with([
                        'visaRequest' => $this->visaRequest,
                        'checklist' => $checklist[$this->visaRequest->visa_type] ?? []
                    ]);
    }
}
