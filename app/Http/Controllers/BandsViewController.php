<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bands;
use App\Models\BandLeden;

class BandsViewController extends Controller
{
    public function index() {
        $data = array(
            'allBands' => Bands::select('*')->get(),
        );
        return view('EPK.bands', compact('data'));
    }
}
