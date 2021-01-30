@extends('layouts.app')

@section('content')

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

<!--------------------------- VERZOEKEN -------------------------->
<div class="row justify-content-center">
    <div class="card" style="min-width: 1800px; max-width:1800px">
        <div class="card-header" style="text-align: center;"> <h4> {{ __('Verzoeken') }}</h4></div>

        <div class="card-body bg-dark" style='text-align:center'>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @for($i=0; $i < count($data['verzoeken']); $i++)
            <form method="POST" action="process"
            style="display: inline-block; padding-right:10px; padding-left:10px; padding-bottom:10px; border-right: solid 1px white; border-left: solid 1px white;">
                    @csrf 
                    U heeft een verzoek van: {{$data['userNames'][$i]['name']}} <br>
                    deze gebruiker vraagt of hij/zij deel mag uitmaken van de band: {{$data['bandNames'][$i]['name']}} <br>
                    Klik op 
                    <button type='submit' value='accept' style="background-color: transparent; color: white; border: none; text-decoration: underline;">
                    accepteren
                    </button>
                    of
                    <button type='submit' value='decline' style="background-color: transparent; color: white; border: none; text-decoration: underline;">
                        weigeren
                    </button> zodat wij het verzoek kunnen verwerken
                    <input type="hidden" name="id_sender" value="{{$data['verzoeken'][$i]['sender_ID']}}">
                    <input type="hidden" name="id_band" value="{{$data['verzoeken'][$i]['band_ID']}}">
                </form>
            @endfor

        </div>
    </div>
</div>

<!--------------------------- VERZONDEN -------------------------->
<div class="row justify-content-center" style='padding-top:10px;'>
    <div class="card" style="min-width: 1800px; max-width:1800px">
        <div class="card-header" style="text-align: center; background-color:#6934dc;"> <h4> {{ __('Verstuurde Verzoeken') }}</h4></div>

        <div class="card-body bg-dark" style='text-align:center'>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @for($i=0; $i < count($data['verzoeken']); $i++)
                <form style="display: inline-block; padding-right:10px; padding-left:10px; padding-bottom:10px; border-right: solid 1px white; border-left: solid 1px white;"> 
                    Ja
                </form>
            @endfor

        </div>
    </div>
</div>
@endsection
