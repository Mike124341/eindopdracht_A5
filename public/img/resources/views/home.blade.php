@extends('layouts.app')

@section('content')
<!-- {{$user->name}} -->
<!--- Pop Up HTML voor het veranderen van jouw persoonlijke kleuren -->
<div class="modal fade bd-example-modal-lg" id="colorchange_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/cssupdate" method="post">
        @csrf
        <label for="achtergrond">Kies een achtergronds kleur:</label>
        <input type="color" value="{{$user->achtergrondKleur}}" name="achtergrondkleur" id="achtergrond">

        <label for="tekst">Kies een tekst kleur:</label>
        <input type="color" value="{{$user->tesktKleur}}" name="tekstkleur" id="tekst">

        <button type="submit" class="btn btn-sm btn-warning">verander</button>
      </form>
    </div>
  </div>
</div>

<!-- Hier komt de code voor de pop up waarmee je jouw wachtwoord veranderd -->
<div class="modal fade bd-example-modal-lg" id="passchange_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" action="/passupdate" method="post">
        @csrf
        <div class="form-group">
          <label class="control-label col-sm-2" for="og_pass">Orginele wachtwoord:</label>
          <div class="col-sm-10">
            <input type="password" placeholder="Huidig wachtwoord" class="form-control" name="og_pass" id="og_pass">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="new_pass">Nieuw wachtwoord:</label>
          <div class="col-sm-10">
            <input type="password" placeholder="Nieuwe wachtwoord" class="form-control" name="new_pass" id="new_pass">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="confirm_pass">Herhaal wachtwoord:</label>
          <div class="col-sm-10">
            <input type="password" placeholder="Herhaal wachtwoord" class="form-control" name="confirm_pass" id="confirm_pass">
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

<!--- Pop Up HTML voor het Aanmelden bij een band -->
<div class="modal fade bd-example-modal-lg" id="sentBandRequest_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/join-band-request" method="post">
        @csrf
        <label for="band_request_join">Voer band naam in:</label>
        <input type="text" placeholder="Band Naam" name="band_request_join">

        <button type="submit" class="btn btn-sm btn-warning">Aanmelden</button>
      </form>
    </div>
  </div>
</div>

<!-- Begin gebruikers data section -->
<div class="container" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ><h3>{{ __('Dashboard') }}</h3></div>

                <div class="card-body" style="background-color:{{$user->achtergrondKleur}}">
                <!-- alert als iemand jouw band wil joinen -->
                @if($band_requests != '[]') <!-- Dit is de standaard value van de var dus als de querry niks terug brengt-->
                    <div class="alert alert-info" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <h4>Let op!</h4>
                        <p style="color:{{$user->tesktKleur}}">
                        Hallo {{$user->name}} er is iemand geïnteresseerd in uw band! <br>
                        Deze gebruiker heeft gevraagd of hij/zij mee mag doen met uw band, <br>
                        Om deze gebruiker to te accepteren druk op de link <a href="/band-join-accept"> accepteren.</a> <br>
                        Of druk op de Volgende link om het verzoek aftewijzen <a href="/band-join-decline">Link</a>
                        </p>
                        
                    </div>
                @endif
                <!-- einde alert joinen -->

                <!-- Error displaty -->
                    @if ($errors->any())
                      <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>

                      @foreach($errors->all() as $error)
                      {{ $error }}<br/>
                      @endforeach
                      </div>
                    @endif
                <!-- error display einde -->

                <!-- Message -->
                  @if (\Session::has('success'))
                    <div class="alert alert-success">
                      <ul>
                        <li>{!! \Session::get('success') !!}</li>
                      </ul>
                    </div>
                  @endif
                <!-- Einde message -->
                <!-- Begin user gegevens en buttons-->
                    <h5>Gebruiker gegevens</h5>
                    <ul style="color:{{$user->tesktKleur}}">
                        <li>Gebruikers ID: {{$user->id}}</li>
                        <li>Gebruikers Naam: {{$user->name}}</li>
                        <li>Gebruikers E-mail: {{$user->email}}</li>
                        <br>
                        <!-- Pop up knop hier onder-->
                        <li><button type="button" id="pop-up-1" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#colorchange_modal">
                          Verander kleuren
                        </button></li>
                        <li><button type="button" id="pop-up-2" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#passchange_modal">
                          Verander wachtwoord
                        </button></li>
                        <li><button class="btn-outline-warning btn-sm btn" data-toggle="modal" data-target="#sentBandRequest_modal">
                          Meedoen aan bij Band
                        </button></li>
                    </ul>
                <!-- Einde User Gegevens En Buttons -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
