@extends('layouts.base_errors')

@section('content')
    <br>
    <br>
    <div class="container-fluid text-center">
        <img src="{{ asset('img/404.png') }}"/>
        <br>
        <br>
        <p>
            La page que vous recherchez n'existe pas.
        </p>
        <a class="back-previous-page" href="/">
            Revenir a l'accueil
        </a>
    </div>
@endsection
