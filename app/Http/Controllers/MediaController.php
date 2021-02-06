<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Band_pictures;
use Illuminate\Http\Request;
use App\Models\Band_videos;
use App\Models\Bands;

class MediaController extends Controller
{
    public function changeMedia(Request $request)   {
        $user = Auth::user();
        $band = $request->input('band_id');
        $img = $request->file('image');
        $video = $request->file('video');
        $option = $request->input('option');

        #voor als alle 2 worden geupload
        if  (empty($request->input('video')) == FALSE && empty($request->input('image')) == FALSE) {
            #Validate -->
            $request->validate([
                'video' => 'required|file|mimes:mp4',
                'image' => 'required|image|mimes:jpg|max:2048',
            ]);
            #Foto ----->
            $imageName = 'Band' . '--' . $band . '.' . $img->extension();
            $img->move(public_path('band_media\img'), $imageName);
            $pathImg = 'public/band_media/img/' . $imageName;
            Band_pictures::updateOrInsert(['band_ID' => $band, 'picture' => $imageName]);

            #Video ---->
            $videoName = 'Band' . '-' . $band . '-' . $option . '.' . $video->extension();
            $video->move(public_path('band_media\vids'), $videoName);
            $pathVid = 'public/band_media/vids/' . $videoName;
            Band_videos::updateOrInsert(['band_ID' => $band, 'video' => $videoName]);

            return redirect()->back()->with('success', 'Media veranderd!');
        }  
        #Als er een video word geupload
        elseif  (isset($video) == TRUE )    { 
            $request->validate([
                'video' => 'required|file|mimes:mp4',
            ]);
            $videoName = 'Band' . '-' . $band . '-' . $option . '.' . $video->extension();
            $video->move(public_path('band_media\vids'), $videoName);
            $path = 'public/band_media/vids/' . $videoName;
            Band_videos::updateOrInsert(['band_ID' => $band, 'video' => $videoName]);

            return redirect()->back()->with('success', 'Media veranderd!');
        }
        #Als er een foto upgeload is
        elseif  (isset($img) == TRUE )  {
            $request->validate([
                'image' => 'required|image|mimes:jpg|max:2048',
            ]);
            $imageName = 'Band' . '--' . $band . '.' . $img->extension();
            $img->move(public_path('band_media\img'), $imageName);
            $path = 'public/band_media/img/' . $imageName;
            Band_pictures::updateOrInsert(['band_ID' => $band, 'picture' => $imageName]);

            return redirect()->back()->with('success', 'Media veranderd!');
        }
        else    {return back()->withErrors(['Foutmelding', 'n']);}
    }

    public function getMedia($id)    {

        #Standaard video namen zoals hierboven is gemaakt
        $vidName1 = 'Band-'. $id . '-1.mp4';
        $vidName2 = 'Band-'. $id . '-2.mp4';
        $vidName3 = 'Band-'. $id . '-3.mp4';

        $imgName = 'Band--'. $id . '.jpg';

        #querry de media bestande
        
        $vid1 = Band_videos::where('band_ID', $id)->where('video' , $vidName1)->get();
        $vid2 = Band_videos::where('band_ID', $id)->where('video' , $vidName2)->get();
        $vid3 = Band_videos::where('band_ID', $id)->where('video' , $vidName3)->get();

        $picture = Band_pictures::where('band_ID', $id)->where('picture', $imgName)->get();

        #check of de video querry's leeg zijn - Zoja query de stock video's
        if ($vid1 == '[]')    { $vid1 = Band_videos::where('band_ID', $id)->where('video' , 'stock-1.mp4')->get(); }
        if ($vid2 == '[]')    { $vid2 = Band_videos::where('band_ID', $id)->where('video' , 'stock-2.mp4')->get(); }
        if ($vid3 == '[]')    { $vid3 = Band_videos::where('band_ID', $id)->where('video' , 'stock-3.mp4')->get(); }
        
        #check of de foto query leeg is - Zoja query de stock foto
        if ($picture == '[]')    { $picture = Band_pictures::where('band_ID', $id)->where('picture', 'stock.jpg')->get(); }

        #Zet de Media in de Array
        $media = array(

            'vid1' => url('/band_media/vids/') . '/' . $vid1[0]['video'],
            'vid2' => url('/band_media/vids/') . '/' . $vid2[0]['video'],
            'vid3' => url('/band_media/vids/') . '/' . $vid3[0]['video'],

            'img' => url('/band_media/img/') . '/' . $picture[0]['picture'],
        );

        return $media;
    }
}
