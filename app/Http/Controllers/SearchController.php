<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bands;

class SearchController extends Controller
{
    public function index(Request $request) {

        #Valideer de request
        $request->validate([
            'keyword' => 'required',
        ]);
        
        #Haal Het Zoek Woord Op
        $keyword = $request->input('keyword');

        #Zoek naar bands met hulp van de keyword
        $bands = Bands::where('name', 'LIKE', "%{$keyword}%")->get();

        return view('EPK.search', compact('bands'));
    }
}
