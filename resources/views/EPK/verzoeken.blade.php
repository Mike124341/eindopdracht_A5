@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('/css/verzoeken.css') }}">
@section('content')

<!-- Error display -->
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

<!--------------------------- VERZOEKEN -------------------------->
<div class="row justify-content-center">
    <div class="card main">
        <div class="card-header">
            <h4> {{ __('Verzoeken') }}</h4>
        </div>

        <div class="card-body bg-dark">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @for($i=0; $i < count($data['verzoeken']); $i++) <form method="POST" action="process">
                @csrf
                <p>
                    U heeft een verzoek van: {{$data['userNames'][$i]['name']}} <br>
                    deze gebruiker vraagt of hij/zij deel mag uitmaken van de band: 
                    <i onclick="location.href = 'bands/{{$data['bandNames'][$i]['band_ID']}}';"><u> {{$data['bandNames'][$i]['name']}} </u></i><br>
                    Klik op
                    <button type='submit' value='accept' name="accept"> accepteren </button>
                    of
                    <button type='submit' value='decline' name='decline'>weigeren </button> 
                    zodat wij het verzoek kunnen verwerken
                    <input type="hidden" name="id_sender" value="{{$data['verzoeken'][$i]['sender_ID']}}">
                    <input type="hidden" name="id_band" value="{{$data['verzoeken'][$i]['band_ID']}}">
                </p>
                </form>
                @endfor

                @if($data['verzoeken'] == '[]')
                <h5>U heeft geen verzoeken.</h5>
                @endif
        </div>
    </div>
</div>


@endsection
