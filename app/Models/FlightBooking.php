<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'dob', 'passport_number',
        'departure_city', 'destination_city', 'departure_date', 'return_date',
        'trip_type', 'passengers', 'class', 'airline', 'notes', 'status'
    ];
}
