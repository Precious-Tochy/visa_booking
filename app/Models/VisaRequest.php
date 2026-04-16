<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaRequest extends Model
{
    use HasFactory;

    protected $fillable = [

'first_name',
'last_name',
'email',
'phone',
'visa_type',
'country',
'occupation',
'travel_history',
'consultation',
'notes',

'status',
'admin_notes',

'progress_stage',
'agent',

'passport',
'bank_statement',
'invitation_letter'

];
}
