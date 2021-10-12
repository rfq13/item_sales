<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function detail()
    {
        return $this->hasMany(DetailSale::class);
    }
}
