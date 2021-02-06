@extends('layouts.app')
@section('content')

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #8b000029;
}

</style>

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
    <div class="card" style="min-width: 1500px; max-width:1000px">
        <div class="card-header" style="text-align: center; background-color: #8b0000">
            <h2> {{ __('Uw zoek resultaten') }}</h2>
        </div>

        <div class="card-body bg-dark" style='text-align:center; min-height: 700px;font-size:20px;'>
            <table>
                <tr>
                    <th>Naam</th>
                    <th>beschrijving</th>
                    <th>ID</th>
                </tr>
                @for($i=0; $i < count($bands); $i++)
                    <tr>
                        <td style="cursor: pointer;"onclick="location.href = 'bands/{{$bands[$i]['band_ID']}}';"> {{$bands[$i]['name']}} </td>
                        <td style="cursor: pointer;"onclick="location.href = 'bands/{{$bands[$i]['band_ID']}}';"> {{$bands[$i]['discription']}} </td>
                        <td style="cursor: pointer;"onclick="location.href = 'bands/{{$bands[$i]['band_ID']}}';"> {{$bands[$i]['band_ID']}} </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>
</div>

@endsection
