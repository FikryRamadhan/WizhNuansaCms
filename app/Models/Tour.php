<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $guarded = [''];
    protected $casts = [
        'image' => 'array'
    ];
}
