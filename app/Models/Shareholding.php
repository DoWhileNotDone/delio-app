<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shareholding extends Model
{
    use HasFactory;

    protected $fillable = ['symbol', 'quantity'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
