<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coffe extends Model
{
    protected $guarded = [''];

    protected $casts = [
        'image' => 'array',
    ];

}
