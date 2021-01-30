<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bands;
use App\Models\BandLeden;
use App\Models\Band_Requests;


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
        #de band verzoeken van de huidige user
        $current_requests = Band_Requests::where('band_lid', $user->id)->get();
        #Alle bands waar de User in zit
        $user_bands = Bands::select('bands.name')
        ->join('band_ledens', 'bands.band_ID', '=', 'band_ledens.band_ID')
        ->join('users', 'band_ledens.user_ID', '=', 'users.id')
        ->where('users.id', $user->id)
        ->get();


        #Alle bands in de DB
        $bands = Bands::get();
        #Zodat ik niet meerdere count variablen mee hoef te geven aan de compact
        $count = array('bands' => count($bands), 'userBands' => count($user_bands), 'bandVerzoeken' => count($current_requests));

        return view('home', compact('user', 'user_bands','bands', 'count', 'current_requests'));
    }


}
