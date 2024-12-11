<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'profit',
        'total_return',
        'earning_cap',
        'status',
    ];
}
