<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    protected $fillable = [
    'first_name',
    'last_name',
    'country',
    'visa_type',
    'amount',
    'status'
];
}
