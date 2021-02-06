@extends('layouts.app')

@section('content')
<!-- Zet klueren naar die van de band -->
{{$band[0]['color_txt']}}
{{$band[0]['color_bg']}}
<style>
    .py-4{
        background-color: {{$band[0]['color_bg']}};
    }
    .py-4{
        color:{{$band[0]['color_txt']}};
    }

</style>

<!--- Pop Up HTML voor het veranderen van jouw persoonlijke kleuren -->
<div class="modal fade bd-example-modal-lg bg-dark" id="colorchange_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/cssupdate" method="post">
                @csrf
                <label for="achtergrond">Kies een achtergronds kleur:</label>
                <input type="color" value="{{$band[0]['color_bg']}}" name="achtergrondkleur" id="achtergrond">

                <label for="tekst">Kies een tekst kleur:</label>
                <input type="color" value="{{$band[0]['color_txt']}}" name="tekstkleur" id="tekst">

                <input type="hidden" value="{{$band[0]['band_ID']}}" name='id'>
                <button type="submit" class="btn btn-sm btn-warning">verander</button>
            </form>
        </div>
    </div>
</div>

<!--- Band Foto & Video -->
<div class="modal fade bd-example-modal-lg" id="media_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form action="/changemedia" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="video">Upload video:</label>
                    <div class="col-sm-10">
                        <input type="file" class=" bg-dark" placeholde='Video link' name="video" id="media_video">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Upload Foto:</label>
                    <div class="col-sm-10">
                        <input class=" bg-dark" type="file" value="" name="image" id="media_foto">
                    </div>
                </div>

                <div class="form-group">
                    <label for="option">Kies Video Optie:</label>
                    <div class="col-sm-10">
                        <select id="media_optie" name="option">
                            <option value="1">video 1</option>
                            <option value="2">video 2</option>
                            <option value="3">video 3</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" value="{{$band[0]['band_ID']}}" name='band_id'>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">verander</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Error displaty -->
@if ($errors->any())
<div class="alert alert-danger message" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>

    @foreach($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<!-- error display einde -->

<!-- Message -->
@if (\Session::has('success'))
<div class="alert alert-success message">
    <ul>
        <li>{!! \Session::get('success') !!}</li>
    </ul>
</div>
@endif
<!-- Admin options -->
@if($isAdmin == TRUE)
<button type="button" id="pop-up-color" class="btn btn-outline-warning btn-sm" data-toggle="modal"
    data-target="#colorchange_modal">
    Verander kleuren
</button>
<button type="button" id="pop-up-media" class="btn btn-outline-warning btn-sm" data-toggle="modal"
    data-target="#media_modal">
    Verander Media
</button>
@endif

<div class="container" style="border: solid red 2px;
    min-width: 400px;
    max-width: 800px;
    min-height: 300px;
    max-height: 600px;
    overflow: overlay;">
    <img src="{{$media['img']}}" alt="" style='max-width:100%; max-height: 100%'>
</div> 
<div id='bandDisc' class="container" style='border: solid blue 2px; text-align:center;
    min-width: fit-content;
    min-height: fit-content;
    margin-top: 30px;
    font-size: 20px;
    margin-bottom: 30px'>
    <h2>Biografie</h2>
    <p style="width:100%">{{$band[0]['discription']}}</p>

</div>

<div class="carousel slide vid_slider container" data-ride="carousel" style='max-width:800px; max-height:600px; border:solid white 2px;'>
        <div class="carousel-inner">
            <h2>Video's</h2>
            <div class="carousel-item active">
                <video class="d-block w-100" alt="first slide" controls>
                    <source src="{{$media['vid1']}}" type="video/mp4"> 
                </video>
            </div>

            <div class="carousel-item">
                <video class="d-block w-100" alt="first slide" controls>
                    <source src="{{$media['vid2']}}" type="video/mp4"> 
                </video>
            </div>

            <div class="carousel-item">
                <video class="d-block w-100" alt="first slide" controls>
                    <source src="{{$media['vid3']}}" type="video/mp4"> 
                </video>
            </div>

        </div>
        <a class="carousel-control-prev" href=".vid_slider" role="button" data-slide="prev"
            style='max-height: 10px; top: 192px;'>
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href=".vid_slider" role="button" data-slide="next"
            style='max-height: 10px; top: 192px;'>
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

@endsection
