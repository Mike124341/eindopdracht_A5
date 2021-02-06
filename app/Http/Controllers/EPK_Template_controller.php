<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bands;
use App\Models\BandLeden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MediaController;

class EPK_Template_controller extends Controller
{

    public function isAdmin($band)   {
        if (Auth::check()) {
            // $loggedIn = TRUE;
            $user = Auth::user();
            $user_lid = BandLeden::where('user_ID', $user->id)->get();
            
            for($i=0; $i < count($user_lid); $i++) {
                if ($band[0]['band_ID'] == $user_lid[$i]['band_ID']) {
                    return TRUE;
                }
                else { return FALSE; }
            }
            
        }
    }

    public function index($id){

        $band = Bands::where('band_ID', $id)->get();
        // $loggedIn = FALSE;
        $isAdmin = $this->isAdmin($band);
        
        #media files
        $media = app(MediaController::class)->getMedia($id);

        // if($band == '[]')    { return view('welcome'); }


        
        $bandLeden = User::select('users.name')
        ->join('band_ledens', 'band_ledens.user_ID' , '=', 'users.id')
        ->join('bands', 'band_ledens.band_ID' , '=', 'bands.band_ID')
        ->where('band_ledens.band_ID', $id)
        ->get();

        return view('EPK.basic_temp', compact('band', 'isAdmin', 'media', 'bandLeden' ));
        
    }
}
