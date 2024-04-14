<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'species', 
        'amount',
        'age',
        'sex',
        'province',
        'location',
        'latitude',
        'initial_date',
        'final_date',
        'observer',
        'image',
    ];

}
