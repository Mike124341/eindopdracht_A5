<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Band_Requests;
use App\Models\Band_pictures;
use Illuminate\Http\Request;
use App\Models\Band_videos;
use App\Models\BandLeden;
use App\Models\Bands;
use App\Models\User;

class BandController extends Controller
{
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

    #Functie om band maker toe tevoegen aan band
    public function addBandMaker($band_data)    {

        #Huidige gebruiker
        $user = Auth::user();
        
        #get band ID
        $thisBand = Bands::where('name', $band_data)
        ->where('discription', $band_data['discription'])
        ->where('color_txt', $band_data['color_txt'])
        ->where('color_bg', $band_data['color_bg'])
        ->get('band_ID');

        #Prepare Insert Data 
        $lidData = array(
            'user_ID' => $user->id,
            'band_ID' => $thisBand[0]['band_ID'],
            'created_at' => now(),
            'updated_at' => now(),
        );

        #Insert Data
        $newLid = BandLeden::insert($lidData);

        #Voeg Stock data toe aan band
        $insertImg = Band_pictures::insert([
            'picture' => 'stock.jpg',
            'band_ID' => $lidData['band_ID'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        #De 3 stock video's
        for($i=0; $i < 3; $i++)   {
            $stockVids = 'stock-'. $i + 1 . '.mp4';

            $insert = Band_videos::insert([
                'video' => $stockVids,
                'band_ID' => $lidData['band_ID'],
                'created_at' => now(),
                'updated_at' => now(), 
            ]);
        }

    }

    #Functie voor het maken van een nieuwe band
    public function createBand(Request $request)    {

        #valideer input data
        $request->validate([
            'bandName' => 'string|required|max:15',
            'disc' => 'string|required|min:10',
            'color-txt' =>  'string|required',
            'color-bg' =>   'string|required',  
        ],
        [ #Error Meldingen
            'bandName.string' => 'De naam moet uit letters bestaan',
            'bandName.required' => 'U heeft geen naam ingevuld',
            'bandName.max' => 'De naam mag niet uit meet dan 15 tekens bestaan',
            'disc.required' => 'U heeft geen omschrijving ingevuld',
            'disc.min' => 'De omschrijving moet minimaal bestaam uit 10 tekens',
            'color-txt.required' => 'U heeft geen tekst kleur ingevuld',
            'color-bg.required' => 'U heeft geen achtergronds kleur uitgekozen',

        ]);

        #Sla de band data op
        $band_data = array(
            'name' => $request->input('bandName'),
            'discription' => $request->input('disc'),
            'color_txt' => $request->input('color-txt'),
            'color_bg' => $request->input('color-bg'),
            'created_at' => now(),
            'updated_at' => now(),
        );

        #Insert Band data
        $newBand = Bands::insert($band_data);

        $this->addBandMaker($band_data);
        
        return back()->withErrors(['Foutmelding', $band_data]);
    }
}
