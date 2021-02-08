<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Bands;

class GenreController extends Controller
{
    #Functie voor het verwijderen/veranderen van Genre
    public function changeGenre(Request $request) {
        $request->validate([
            'genre' => 'required|string',
            'band-id' => 'required|integer'
        ],
        [
            'genre.required' => 'U heeft geen genre gekozen',
            'band-id.required' => 'U heeft geen band gekozen',
        ]);
        
        if (empty($request))   { return redirect()->back(); }

        $isAdmin = $request->input('A');
        $option = $request->input('proccess');
        $genre = $request->input('genre');
        $band = $request->input('band-id');
        
        if($isAdmin == FALSE)    { return redirect()->back()->withErrors('fourmelding', 'U heeft geen rechten voor deze actie!'); }

        if ($option == 'up')   { 

            $updateGenre = Genre::updateOrInsert(['band_ID' => $band, 'genre' => $genre]);
            return redirect()->back()->with('success', 'Genre Veranderd!');
        }
        if ($option == 'del')   { 

            $deleteGenre = Genre::where(['band_ID' => $band, 'genre' => $genre])->delete();
            return redirect()->back()->with('success', 'Genre verwijderd!');
        }
    }  

}
