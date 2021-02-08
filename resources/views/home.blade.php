@extends('layouts.app')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@section('content')

<h1 id='dash-welcome'>Welkom! {{$data['user']['name']}}</h1>

<!-- Message -->
@if (\Session::has('success'))
<div class="alert alert-success message">
    <ul>
        <li>{!! \Session::get('success') !!}</li>
    </ul>
</div>
@endif

<br>

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

@if($data['current_requests'] != '[]')
<!-- Dit is de standaard value van de var dus als de querry niks terug brengt-->
<div class="alert alert-info message" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4>Let op!</h4>

    <p>
        Hallo {{$data['user']['name']}} er is iemand geïnteresseerd in uw band! <br>
        Deze gebruiker(s) heeft gevraagd of hij/zij mee mag doen met uw band. <br>
        Om de verzoek(en) te bekijken klik hier -> <a href="/verzoeken"> Verzoeken</a> <br>
    </p>

</div>
@endif


<!-- Hier komt de code voor de pop up waarmee je jouw wachtwoord veranderd -->
<div class="modal fade bd-example-modal-lg" id="passchange_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form class="form-horizontal" action="/passupdate" method="post">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="og_pass">Orginele wachtwoord:</label>
                    <div class="col-sm-10">
                        <input type="password" placeholder="Huidig wachtwoord" class="form-control" name="og_pass"
                            id="og_pass">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="new_pass">Nieuw wachtwoord:</label>
                    <div class="col-sm-10">
                        <input type="password" placeholder="Nieuwe wachtwoord" class="form-control" name="new_pass"
                            id="new_pass">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="confirm_pass">Herhaal wachtwoord:</label>
                    <div class="col-sm-10">
                        <input type="password" placeholder="Herhaal wachtwoord" class="form-control" name="confirm_pass"
                            id="confirm_pass">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">verander</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Pop Up voor het verwijderem van een band -->
<div class="modal fade bd-example-modal-lg" id="deleteBand_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form class="form-horizontal" action="/delete-band" method="post">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Nieuwe naam:</label>
                    <div class="col-sm-10">
                        <select name="band_ID" id="delete-band">
                            @for($i=0; $i < count($data['user_bands']); $i++)
                                <option value="{{$data['user_bands'][$i]['band_ID']}}">{{$data['user_bands'][$i]['name']}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">verander</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Pop Up voor het veranderen van gebruikers naam -->
<div class="modal fade bd-example-modal-lg" id="nameChange_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form class="form-horizontal" action="/name-update" method="post">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Nieuwe naam:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Nieuwe naam" class="form-control" name="new_name" id="new_name">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">verander</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Pop Up voor het veranderen van gebruikers e-mail -->
<div class="modal fade bd-example-modal-lg" id="emailChange_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form class="form-horizontal" action="/email-update" method="post">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Nieuwe email:</label>
                    <div class="col-sm-10">
                        <input type="email" placeholder="Nieuwe E-mail" class="form-control" name="email" id="email">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">verander</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hier komt de code voor de pop up waarmee je een band creëert -->
<div class="modal fade bd-example-modal-lg" id="createBand_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form class="form-horizontal" action="/new-band" method="post">
                @csrf
                <!-- Band naam -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="bandName">De naam van uw band:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Band Naam" class="form-control" name="bandName" id="bandName">
                    </div>
                </div>
                <!--Band omschrijving  -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="disc">omschrijving van uw band:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Band omschrijving" class="form-control" name="disc" id="disc">
                    </div>
                </div>
                <!-- Band Tekst Kleur -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="color-txt">Tekst kleur band:</label>
                    <div class="col-sm-10">
                        <input type="color" placeholder="Band text kleur" class="form-control" name="color-txt"
                            id="color-txt">
                    </div>
                </div>
                <!-- Band Achtergrond Kleur -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="color-bg">Achtergronds kleur band:</label>
                    <div class="col-sm-10">
                        <input type="color" placeholder="Band achtergrond kleur" class="form-control" name="color-bg"
                            id="color-bg">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-sm btn-warning">creëren</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Pop Up HTML voor het Aanmelden bij een band -->
<div class="modal fade bd-example-modal-lg" id="sentBandRequest_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <form action="/join-band-request" method="post">
                @csrf
                <label for="band_request_join">Voer band ID in: </label>
                <input type="text" placeholder="Hier de id van de band" name="band_request_join">

                <button type="submit" class="btn btn-sm btn-warning">Aanmelden</button>
            </form>
        </div>
    </div>
</div>

<!-- Begin cards -->
<div class="container-fluid">
    <div class="row justify-content-center">

        <!-- Gebruiker gegevens Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{ __('Gebruiker Gegevens') }}</div>

                <div class="card-body bg-dark">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- Begin user gegevens en buttons-->
                    <ul>
                        <li>Gebruikers ID: {{$data['user']['id']}}</li>
                        <li>Gebruikers Naam: {{$data['user']['name']}}</li>
                        <li>Gebruikers E-mail: {{$data['user']['email']}}</li>
                        <br>
                        <!-- Pop up knop hier onder-->
                        <li>
                            <button type="button" id="pop-up-2" class="btn btn-outline-warning btn-sm"
                                data-toggle="modal" data-target="#passchange_modal">
                                Verander wachtwoord
                            </button>
                        </li>
                        <li>
                            <button type="button" id="pop-up-2" class="btn btn-outline-warning btn-sm"
                                data-toggle="modal" data-target="#nameChange_modal">
                                Verander Gebruikers Naam
                            </button>
                        </li>
                        <li>
                            <button type="button" id="pop-up-2" class="btn btn-outline-warning btn-sm"
                                data-toggle="modal" data-target="#emailChange_modal">
                                Verander Gebruikers E-mail
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Bands beheer Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{ __('Beheer uw Band(s)') }}</div>
                <div class="card-body bg-dark card-bands">
                    <ul>Uw bands:
                        @for($i=0; $i<$data['countUserBands']; $i++) <li
                            onclick="location.href = 'bands/{{$user_bands[$i]['band_ID']}}';">
                            {{$user_bands[$i]['name']}}
                            </li>
                            @endfor
                            <br>
                            <li> <a href="/verzoeken">Uw verzoeken: {{$data['countBandVerzoeken']}}</a></li>
                            <li>
                                <button class="btn-outline-warning btn-sm btn" data-toggle="modal"
                                    data-target="#deleteBand_modal">
                                    Verwijder Band
                                </button>
                            </li>
                    </ul>
                    <br>
                    <hr>
                    <div class="bands-info">
                        <div>
                            <button class="btn-outline-warning btn-sm btn btn-left" data-toggle="modal"
                                data-target="#createBand_modal">
                                Band creëren
                            </button>
                            <button class="btn-outline-warning btn-sm btn btn-right" data-toggle="modal"
                                data-target="#sentBandRequest_modal">
                                Meedoen aan een Band
                            </button>
                        </div>

                        <h4> Lijst Bands</h4>

                        <ul>
                            @for ($i = 0; $i < $data['countBands']; $i++) <li
                                onclick="location.href = 'bands/{{$data['bands'][$i]['band_ID']}}';">
                                ID: {{$data['bands'][$i]['band_ID']}} -
                                {{$data['bands'][$i]['name']}}
                                </li>
                                @endfor
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
