<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'type',
        'price_per_day',
        'seats',
        'transmission',
        'image'
    ];
    public function bookings()
{
return $this->hasMany(CarBooking::class);
}
}
