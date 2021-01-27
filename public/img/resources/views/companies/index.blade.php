@extends('layouts.app')

@section('content')
<div class="col-sm-12">

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
</div>

 <div>
    <a style="margin: 19px;" href="{{ route('companies.create')}}" class="btn btn-primary">Bedrijf toevoegen</a>
 </div>

<div class="row">
<div class="col-sm-12">
    <h1 class="display-3">Bedrijven</h1>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Naam</td>
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
        <tr>
            <td>{{$company->id}}</td>
            <td>{{$company->name}}</td>
            <td>
                <a href="{{ route('companies.edit',$company->id)}}" class="btn btn-primary">Aanpassen</a>
            </td>
            <td>
                <form action="{{ route('companies.destroy', $company->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Verwijderen</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
@endsection
