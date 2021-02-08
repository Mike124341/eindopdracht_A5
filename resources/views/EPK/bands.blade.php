@extends('layouts.app')
<link rel="stylesheet" href="{{asset('/css/bandsPage.css')}}">
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
    <div class="card main-card">
        <div class="card-header">
            <h2> {{ __('Alle Bands') }}</h2>
        </div>

        <div class="card-body bg-dark">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <p>
                Dit zijn alle bands die zijn in geschreven op de website. <br>
                Hier kunt u alle informatie vinden over de band die U zoekt, <br>
                door op de band te klikken die u intereseerd komt u op de pagina van deze band. <br>
            </p>
            <hr>

            <h4>-Band lijst - Band Naam - Band ID-</h4> <br>
            <div id="bandList">
                <table>
                    <tr>
                        <th>Band naam</th>
                        <th>Band Biografie</th>
                        <th>Band ID</th>
                    </tr>
                    @for($i=0; $i < count($data['allBands']);$i++) 
                    <tr>
                        <td onclick="location.href = 'bands/{{$data['allBands'][$i]['band_ID']}}';">
                            {{$data['allBands'][$i]['name']}}
                        </td>
                        
                        <td onclick="location.href = 'bands/{{$data['allBands'][$i]['band_ID']}}';">
                            {{$data['allBands'][$i]['discription']}}
                        </td>

                        <td onclick="location.href = 'bands/{{$data['allBands'][$i]['band_ID']}}';">
                            {{$data['allBands'][$i]['band_ID']}}
                        </td>
                    </tr>
                    @endfor
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
