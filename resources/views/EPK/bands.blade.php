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

<!-- Message -->
@if (\Session::has('success'))
<div class="alert alert-success message">
    <ul>
        <li>{!! \Session::get('success') !!}</li>
    </ul>
</div>
@endif

<div class="row justify-content-center">
    <div class="card" style="min-width: 1000px; max-width:1000px">
        <div class="card-header" style="text-align: center; background-color: #8b0000">
            <h2> {{ __('Alle Bands') }}</h2>
        </div>

        <div class="card-body bg-dark" style='text-align:center; min-height: 700px;font-size:20px;'>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <p style='margin-left:0%;'>
                Dit zijn alle bands die zijn in geschreven op de website. <br>
                Hier kunt u alle informatie vinden over de band die U zoekt, <br>
                door op de band te klikken die u intereseerd komt u op de pagina van deze band. <br>
            </p>
            <hr style="border-color:white;">

            <h4>-Band lijst - Band Naam - Band ID-</h4> <br>
            <div id="bandList" style="text-align:center; display:flex; margin-left:37%;">
                <ul style="list-style:none;">
                    @for($i=0; $i < count($data['allBands']);$i++) 
                        <li style="cursor: pointer;"onclick="location.href = 'bands/{{$data['allBands'][$i]['band_ID']}}';">
                            {{$data['allBands'][$i]['name']}}
                        </li>
                    @endfor
                </ul>
                <ul style="list-style:none;">
                    @for($i=0; $i < count($data['allBands']);$i++) 
                        <li style="cursor: pointer;"onclick="location.href = 'bands/{{$data['allBands'][$i]['band_ID']}}';">
                            {{$data['allBands'][$i]['band_ID']}}
                        </li>
                    @endfor
                </ul>
            </div>

        </div>
    </div>
</div>

@endsection
