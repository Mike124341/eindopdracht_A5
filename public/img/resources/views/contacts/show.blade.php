@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Contact bekijken</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif

        <div>
           <a style="margin: 19px;" href="{{ route('contacts.index')}}" class="btn btn-primary">Overzicht</a>
        </div>

        <table class="table table-striped">
        <tbody>
            <tr>
                <td>Voornaam:</td>
                <td>{{ $contact->first_name }}</td>
            </tr>
            <tr>
                <td>Achternaam:</td>
                <td>{{ $contact->last_name }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $contact->email }}</td>
            </tr>
            <tr>
                <td>Woonplaats:</td>
                <td>{{ $contact->city }}</td>
            </tr>
            <tr>
                <td>Land:</td>
                <td>{{ $contact->country }}</td>
            </tr>
            <tr>
                <td>Functie:</td>
                <td>{{ $contact->job_title }}</td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
