<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol', 
        'current_price',
        'change',
        'percent_change',
        'previous_close_price',
    ];
}
