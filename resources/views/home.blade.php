@extends('layouts.app')

@section('content')

<h1 style="text-align:center">Welkom! {{$user->name}}</h1>

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

<!-- Begin cards -->
<div class="container-fluid">
    <div class="row justify-content-center">

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
                    <h5>Gebruiker gegevens</h5>
                    <ul style="color:{{$user->tesktKleur}}">
                        <li>Gebruikers ID: {{$user->id}}</li>
                        <li>Gebruikers Naam: {{$user->name}}</li>
                        <li>Gebruikers E-mail: {{$user->email}}</li>
                        <br>
                        <!-- Pop up knop hier onder-->
                        <li>
                            <button type="button" id="pop-up-2" class="btn btn-outline-warning btn-sm"
                                data-toggle="modal" data-target="#passchange_modal">
                                Verander wachtwoord
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{ __('Beheer uw Band(s)') }}</div>

                <div class="card-body bg-dark">
                    <ul>
                        <li>Uw bands: {{$band_data[0]['name']}}</li>
                        <li>
                            <button class="btn-outline-warning btn-sm btn" data-toggle="modal"
                                data-target="#sentBandRequest_modal">
                                Meedoen aan bij Band
                            </button>
                        </li>
                    </ul>

                    <div style="text-align:center;">
                        Lijst Bands <br>
                        {{var_dump(count($allBands))}}
                        {{$allBands}}
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
