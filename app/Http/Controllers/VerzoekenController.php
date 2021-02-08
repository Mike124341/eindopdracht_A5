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

        $bandNames = Bands::select('bands.name' , 'bands.band_ID')
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

     #Kijk of de huidig gebruiker openstaande requests heefd
    public function process(Request $request, User $user)  {
        $user = Auth::user();
        $current_user_requests = Band_Requests::where('band_lid', $user->id)->get();
        $band_ID = $request->input('id_band');

        if($request->input('accept') == 'accept')  {    #Kijk op de knop accept is gedrukt
            try {
                $data = array(  #De data die in de bandLends table moet komen
                    'user_ID' => $request->input('id_sender'),
                    'band_ID' => $request->input('id_band'),
                );
                #Insert de data array hier boven
                $b = BandLeden::insert($data);

                #Update de request state
                $updateRequest = Band_Requests::where('sender_ID', $request->input('id_sender'))
                ->where('band_ID', $request->input('id_band'))->update(['accepted' => TRUE]);
                
             } catch (\Exception $e) {  
                if ($e->getCode() == 23000) {   
                    #23000 is de error code van meerdere records die niet uniek zijn wat dus niet mag
                    #Met andere woorden de Gebruiker die de request heeft verstuurd is al lid van deze band!
                    $updateRequest = Band_Requests::where('sender_ID', $request->input('id_sender'))
                    ->where('band_ID', $request->input('id_band'))->update(['accepted' => TRUE]);
                    #verwijder dus de request 
                    $deleteAcceptedRequests = Band_Requests::where('accepted', TRUE)->delete();
                    #stuur terug met foutmelding
                    return back()->withErrors(['Foutmelding', 'User is al Lid']);  
                }
             }
            #Stuur terug met Succes melding
            return redirect()->back()->with('success', 'U heeft een nieuwe band lid');
        }
        #Voor de zekerheid check of de decline knop is gedrukt
        elseif($request->input('decline') == 'decline'){
            #verwijder de request
            $updateRequest = Band_Requests::where('sender_ID', $request->input('id_sender'))
            ->where('band_ID', $request->input('id_band'))->delete();

            return back()->withErrors(['succes', 'Verzoek afgewezen']);
        }
        else{
            return back()->withErrors(['Foutmelding', 'Sorry er is iets fout gegeaan!']);
        }
    }
}
