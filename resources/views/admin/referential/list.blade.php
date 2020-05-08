@extends('layouts.base_admin')

@section('content')
    <div class="list-group">
        @if($vocabularies->isNotEmpty())
            <span class="list-group-item active text-center">
                Référentiels
            </span>
        @else
            <span class="list-group-item text-center text-danger">
                Aucun référentiels
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
