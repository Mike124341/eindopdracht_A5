@extends('layouts.app')
<link href="{{ asset('css/search.css') }}" rel="stylesheet">

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
    <div class="card main">
        <div class="card-header">
            <h2> {{ __('Uw zoek resultaten') }}</h2>
        </div>

        <div class="card-body bg-dark" style=''>
            <table>
                <tr>
                    <th>Naam</th>
                    <th>beschrijving</th>
                    <th>ID</th>
                </tr>
                @for($i=0; $i < count($bands); $i++)
                    <tr>
                        <td onclick="location.href = 'bands/{{$bands[$i]['band_ID']}}';"> {{$bands[$i]['name']}} </td>
                        <td onclick="location.href = 'bands/{{$bands[$i]['band_ID']}}';"> {{$bands[$i]['discription']}} </td>
                        <td onclick="location.href = 'bands/{{$bands[$i]['band_ID']}}';"> {{$bands[$i]['band_ID']}} </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>
</div>

@endsection
