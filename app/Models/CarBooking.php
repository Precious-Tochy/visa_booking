<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBooking extends Model
{

protected $fillable = [
'car_id',
'name',
'email',
'phone',
'pickup_location',
'pickup_date',
'pickup_time',
'return_date',
'with_driver',
'total_price',
'status',
'booking_reference'
];

public function car()
{
return $this->belongsTo(Car::class);
}

}