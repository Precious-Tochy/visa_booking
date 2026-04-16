<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    protected $fillable = [

'first_name',
'last_name',
'email',
'phone',
'country',
'package',
'departure_date',
'return_date',
'travelers',
'budget',
'travel_style',
'hotel',
'activities',
'notes',
'status'

];
}
