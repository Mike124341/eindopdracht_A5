<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Band_Requests;
use App\Models\Bands;
use App\Models\User;

class VerzoekenController extends Controller
{
    public function index() {

        $user = Auth::user();
        $verzoeken = Band_Requests::where('band_lid', $user->id)->get();

        $userNames = User::select('users.name')
        ->join('band_requests', 'users.id' , '=', 'band_requests.sender_ID')
        ->where('band_requests.band_lid', $user->id)
        ->get();

        $bandNames = Bands::select('bands.name')
        ->join('band_requests', 'bands.band_ID' , '=', 'band_requests.band_ID')
        ->where('band_requests.band_lid', $user->id)
        ->get();

        $data = array(
            'verzoeken' => $verzoeken,
            'user' => $user,
            'userNames' => $userNames,
            'bandNames' => $bandNames,
        );

        return view('EPK.verzoeken', compact('data'));
    }
}
