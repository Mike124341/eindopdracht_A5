<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BandLeden;
use App\Models\Band_Requests;
use App\Models\Bands;
use App\Models\User;

class BandController extends Controller
{
    #Kijk of de huidig gebruiker openstaande requests heefd
    public function process(Request $request, User $user)  {
        $user = Auth::user();
        $current_user_requests = Band_Requests::where('band_lid', $user->id)->get();
        $band_ID = $request->input('id_band');
        return redirect()->back()->withErrors(['Foutmelding', $band_ID]);
        // if($current_user_requests != '[]')  {
        //     #Check of de user al in een band zit
        //     try {
        //         $data = array(  #De data die in de bandLends table moet komen
        //             'user_ID' => $current_user_requests[0]['sender_ID'],
        //             'band_ID' => $current_user_requests[0]['band_ID'],
        //         );

        //         $b = Band_Requests::insert($data);
        //         #Update de request state
        //         $updateRequest = Band_Requests::where('sender_ID', $current_user_requests[0]['sender_ID'])
        //         ->where('band_ID', $current_user_requests[0]['band_ID'])->update(['accepted' => TRUE]);
                
        //      } catch (\Exception $e) {  
        //         if ($e->getCode() == 23000) {   #23000 is de error code van meerdere records die niet uniek zijn wat dus niet mag

        //             $updateRequest = Band_Requests::where('sender_ID', $current_user_requests[0]['sender_ID'])
        //             ->where('band_ID', $current_user_requests[0]['band_ID'])->update(['accepted' => TRUE]);
                    
        //             return back()->withErrors(['Foutmelding', 'User is al Lid']);  
        //         }
        //      }


            // $deleteAcceptedRequests = BandRequests::where('accepted', TRUE)->delete();



        //     return redirect()->back()->with('success', 'U heeft een nieuwe band lid');
        // }
        // else{
        //     return back()->withErrors(['Foutmelding', 'U Heeft geen openstaande Band Verzoeken']);
        // }
    }
}
