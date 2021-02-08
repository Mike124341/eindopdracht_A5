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

    public function changeName(Request $request, User $user)    {
        
        $this->validate($request, ['new_name' => 'required'] , ['new_name.required' => 'U heeft geen naam ingevuld',]);
        
        $user = Auth::user();
        $user->name = $request->input('new_name');
        $user->save();
        
        return redirect()->back()->with('success', 'Naam veranderd');
    }

    public function changeEmail(Request $request, User $user)    {
        
        $this->validate($request, ['email' => 'required'] , ['new_name.required' => 'U heeft geen e-mail ingevuld',]);
        
        $user = Auth::user();
        $user->email = $request->input('email');
        $user->save();
        
        return redirect()->back()->with('success', 'E-mail veranderd');
    }

}
