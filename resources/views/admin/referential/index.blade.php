@extends('layouts.base_admin')

@section('content')
    <div class="jumbotron">
        <h1 class="display-4">Administration</h1>
        <p>L'interface d'administration vous permet de gérer les référentiels.</p>
        <a href="/{{ env('L5_SWAGGER_ROUTE') }}">Documentation api rest</a>
    </div>
@endsection
