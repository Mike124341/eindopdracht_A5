<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band_videos extends Model
{
    use HasFactory;

    protected $fillable = [
        'video', 'id'
    ];

    public function bands()  {
        return $this->belongsTo(Bands::class);
    }
}
