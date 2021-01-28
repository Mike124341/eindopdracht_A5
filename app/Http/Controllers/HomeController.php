<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bands;
use App\Models\BandLeden;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        #Haal Data van de user op en zet in var user
        $user = Auth::user();
        $user_bands = BandLeden::where('user_ID', 1)->get();
        $band_data = Bands::where('band_ID', $user_bands[0]['band_ID'])->get();
        $allBands = Bands::all();
        return view('home', compact('user', 'band_data', 'allBands'));
    }


}
