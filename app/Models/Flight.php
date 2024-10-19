<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    public function city() {
        return $this->hasMany(City::class);
    }

    public function air() {
        return $this->belongsTo(Air::class);
    }

    public function airport() {
        return $this->hasMany(Airport::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
