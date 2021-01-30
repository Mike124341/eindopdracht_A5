<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\BandLeden;
use App\Models\Band_Requests;
use App\Models\Bands;
use App\Models\User;

class Pop_UpController extends Controller
{
    #Deze functie zorgt dat je jouw wachtwoord kan veranderen
    #Door middel van de pop up in de Dashbord als je bent ingelogd
    public function changePassword(Request $request, User $user)    {
        
        $this->validate($request, [
            'og_pass' => 'required',
            'new_pass' => 'required|min:8',
            'confirm_pass' => 'required|same:new_pass',
        ], [    #Custom error messages
            'og_pass.required' => 'Orginele wachtwoord niet ingevuld',
            'new_pass.required' => 'nieuwe wachtwoord niet ingevuld',
            'confirm_pass.required' => 'wachtwoord niet herhaald',
            'confirm_pass.same' => 'wachtwoorden zijn niet hetzelfe',
            'new_pass.min' => 'wachtwoord moet minimaal 8 tekens zijn',
        ]);
        
        $user = Auth::user();

        #Check of de ingevoerde orginele wachtwoord over een komt
        #Met de orginele wachtwoord uit de database
        if(Hash::check($request->input('og_pass'), $user->password))    {
            #Check of de nieuwe wacht woord het zelfde is als de bestaande
            if(Hash::check($request->input('new_pass'), $user->password))   {
                return back()->withErrors(['Foutmelding', 'Uw nieuwe wachtwoord kan niet hetzelfde zijn als de bestaande']);
            }
        } 
        #als de orginele en de huide niet overeen komen
        else {return back()->withErrors(['Foutmelding', 'uw orginele wachtwoord komt niet overeen']);}

        $user->password = bcrypt($request->input('new_pass'));
        $user->save();
        
        return redirect()->back()->with('success', 'Wachtwoord veranderd');
    }

    public function sent_band_request(Request $request, User $user) {
        #kijk of de gebruiker daadwerkelijk iets heeft ingevoerd
        $this->validate($request, ['band_request_join' => 'required|integer',] , 
            ['band_request_join.required' => 'Geen Band Naam Ingevoerd', 'band_request_join.integer' => 'De band ID moet een getal zijn']);
        #Haal de band op waar de user om heeft gevraagt
        $band_requested = Bands::where('band_ID', $request->input('band_request_join'))->get();   //Slaat de band admin op in de var
        #Haal de band leden op die in de band zitten en tel deze
        $band_requested_leden = Bandleden::where('band_ID', '=', $band_requested[0]['band_ID'])->get();
        $count = count($band_requested_leden);
        #Haal de gegevens van de huidige user op
        $user = Auth::user();
        #Om de Unique constrained error op te vangen
        #dit zorgt er du voor dat er niet meerdere vab de zelfde request komen in de DB
        try {
            for ($i = 0; $i < $count; $i++) {
                $data = array(
                    'sender_ID' => $user->id,
                    'band_ID' => $band_requested[0]['band_ID'],
                    'band_lid' => $band_requested_leden[$i]['user_ID'],
                    'accepted' => FALSE,
                );
                $b = Band_Requests::insert($data);
            }
         } catch (\Exception $e) {  
            if ($e->getCode() == 23000) {   #23000 is de error code van meerdere records die niet uniek zijn wat dus niet mag
                return back()->withErrors(['Foutmelding', 'verzoek bestaat al']);  
            }
         }


        return redirect()->back()->with('success', 'Verzoek verstuurd!');
    }
}
