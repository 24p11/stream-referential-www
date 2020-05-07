@extends('layouts.base_admin')

@section('content')
    <a class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true"
       href="path('admin_referential_add') ">
        Ajouter un nouveau référentiel +
    </a>
    <br>
    <br>
    <div class="list-group">
        @if($vocabularies)
            <span class="list-group-item active text-center">
                Référentiels
            </span>
        @endif
        @foreach($vocabularies as $vocabulary)
            <a class="list-group-item list-group-item-action"
               href="{{ url("admin/manage/{$vocabulary->id}") }}">
                {{ $vocabulary->id }}
                @if($vocabulary->description)
                    (<span class="font-weight-light">{{ $vocabulary->description }}</span>)
                @endif
            </a>
        @endforeach
    </div>
@endsection
