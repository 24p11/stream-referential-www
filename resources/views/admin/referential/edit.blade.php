@extends('layouts.base_admin')

@section('content')
    <form action="{{ url('/admin/edit', request('referential')) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="id" class="required">Nom du référentiel</label>
            <input type="text" id="id" name="id" required="required" disabled class="form-control"
                   value="{{ $vocabulary->id }}"/>
        </div>
        <div class="form-group">
            <label for="description">Déscription</label>
            <textarea id="description" name="description" class="form-control">{{ $vocabulary->description }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" id="save" name="save" class="btn-primary btn">Enregistrer</button>
        </div>
    </form>
@endsection
