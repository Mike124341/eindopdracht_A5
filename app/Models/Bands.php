<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bands extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'discription', 'color_txt', 'color_bg', 
    ];

    public function band_videos()    {
        return $this->hasMany(Band_videos::class);
    }

    public function band_pictures()    {
        return $this->hasMany(Band_pictures::class);
    }

    public function band_leden()    {
        return $this->belongsToMany(BandLeden::class);
    }
}
