<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'country',
        'image',
        'duration',
        'price',
        'is_popular',
        'includes'
    ];
    public function getRouteKeyName()
{
    return 'slug';
}
}