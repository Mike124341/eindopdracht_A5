<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandLeden extends Model
{
    use HasFactory;

    public function user()    {
        return $this->belongsToMany(user::class);
    }

    public function bands()    {
        return $this->belongsToMany(Bands::class);
    }

    public function band_request()    {
        return $this->belongsToMany(Band_requests::class);
    }
}
