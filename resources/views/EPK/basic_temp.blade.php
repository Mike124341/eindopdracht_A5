@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('/css/bandTemp.css') }}">

@section('content')

<!--- Pop Up HTML voor het veranderen van jouw persoonlijke kleuren -->
<div class="modal fade bd-example-modal-lg" id="colorchange_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form action="/cssupdate" method="post">
                @csrf
                <input type="hidden" value="{{$isAdmin}}" name='A'>
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

<!--- Band Foto & Video POP-UP -->
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
                <input type="hidden" value="{{$isAdmin}}" name='A'>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">verander</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Genre POP UP -->
<div class="modal fade bd-example-modal-lg" id="genre_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form action="/genres" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="genre">Kies uw genre:</label>
                    <div class="col-sm-10">
                        <select id="chooseGenre" name="genre">
                            <option value="jazz"> Jazz </option>
                            <option value="rock"> Rock </option>
                            <option value="metal"> Metal </option>
                            <option value="hip-hop"> Hip-Hop </option>
                            <option value="blues"> Blues </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="proccess">Kies Video Optie:</label>
                        <div class="col-sm-10">
                            <select id="del_update" name="proccess">
                                <option value="del">Delete</option>
                                <option value="up">Toevoegen</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" value="{{$band[0]['band_ID']}}" name='band-id'>
                    <input type="hidden" value="{{$isAdmin}}" name='A'>

                    <button type="submit" class="btn btn-sm btn-warning">verander</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">

                <h3>{{ $band[0]['name'] }}</h3>
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
                <button type="button" id="genre_modal" class="btn btn-outline-warning btn-sm" data-toggle="modal"
                    data-target="#genre_modal">
                    Genres
                </button>
                
                @endif

            </div>

            <div class="card-body"
                style="color:{{$band[0]['color_txt']}} !important; background-color: {{$band[0]['color_bg']}} !important;">

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

                <!-- Foto -->
                <div class="img-container container">
                    <img src="{{$media['img']}}">
                </div>

                <!-- Midden Stuk -->
                <div class="carousel slide content_slider container" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" id="bandDisc">
                            <p id="biografie">
                                <h1>Biografie</h1>
                                {{$band[0]['discription']}}

                                <h1>Genres</h1>
                                <ul>
                                @for($i=0; $i < count($genres); $i++)
                                    <li>{{$genres[$i]['genre']}}</li>
                                @endfor
                                </ul>
                            </p>
                        </div>

                        <div class="carousel-item">
                            <p id="leden">
                                <h1>Band Leden</h1>
                                <ul>
                                    @for($i=0; $i < count($bandLeden); $i++)
                                        <li id=ledenlist>
                                            {{$bandLeden[$i]['name']}}
                                        </li>
                                    @endfor
                                </ul>
                            </p>
                        </div>

                    </div>
                    <a class="carousel-control-prev" href=".content_slider" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href=".content_slider" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <!-- Video content  -->
                <div class="carousel slide vidSlider container" data-ride="carousel">
                    <h1>Videos</h1>
                    <div class="carousel-inner">
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
                    <a class="carousel-control-prev" href=".vidSlider" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href=".vidSlider" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
