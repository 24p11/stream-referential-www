@extends('layouts.base')

@section('content')
    <br>
    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1>Référentiel APHP</h1>
            <img src="{{ asset('img/logo.png') }}" alt="Referential logo">
            <div>
                <a href="{{ url('admin') }}">Administration des référentiels</a>
            </div>
        </div>
    </div>
@endsection
