<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Band_pictures;
use Illuminate\Http\Request;
use App\Models\Band_videos;
use App\Models\BandLeden;
use App\Models\Bands;
use App\Models\User;

class BandController extends Controller
{
    public function deleteBand(Request $request) {
        $request->validate(['band_ID' => 'required'], ['band_ID.required' => 'Geen band ingevuld']);
        $band = $request->input('band_ID');

        $deleteBand = Bands::where('band_ID', $band)->delete();

        return redirect()->back()->with('success', 'band verwijderd');
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
        
        return back()->with('success', 'Band aangemaakt: ', $band_data['name'] );
    }

     #Hier komt de functie voor het updaten van de pagina kleur
     public function updateColor(Request $request)   {
            
        #variable komt de input in te staan tweede argument is voor als niet is ingevoerd
        #LET OP Straks moet hier de kleur van uit de DATABASE komen
        $achtergrondColor = $request->input('achtergrondkleur');
        $tekstColor = $request->input('tekstkleur');
        $id = $request->input('id');
        $isAdmin = $request->input('A');
        
        #Check of de gebruiker admin rechten heeft
        if (isset($id) && $isAdmin == TRUE)   {
            $colors = Bands::where('band_ID', $id)->update(
                ['color_bg' => $achtergrondColor, 'color_txt' => $tekstColor] );

            return redirect()->back()->with('success', 'Kleuren zijn veranderd');
        }
        else{
            return redirect()->back()->withErrors('Foutmelding', 'U niet de benodigde rechten voor het veranderen van deze pagina!');
        }

        return back()->withErrors(['Foutmelding', 'er is iets misgegaan']);
    }

}
