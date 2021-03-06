<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band_requests extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_ID', 'band_ID', 'accepted',
    ];

    public function user()    {
        return $this->belongsToMany(user::class);
    }

    public function bands()    {
        return $this->belongsToMany(Bands::class);
    }
}
