@extends('layouts.base_admin')

@section('content')
    <div class="list-group">
        <span class="list-group-item active text-center">
               {{ request('referential') }}
        </span>
        <a href="{{ url('admin/edit', request('referential')) }}"
           class="list-group-item list-group-item-action">
            Edition
        </a>
        <a href="{{ url('admin/metadata_dictionary', request('referential')) }}"
           class="list-group-item list-group-item-action">
            Dictionnaire des variables
        </a>
        <a href="{{ url('admin/details', request('referential')) }}"
           class="list-group-item list-group-item-action">
            Détails
        </a>
    </div>
@endsection
