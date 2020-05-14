@extends('layouts.base_admin')

@section('content')
    <div id="metadata-dictionary"></div>
@endsection

@push('scripts')
    <script>
        const referential = "{{ request('referential') }}";
        const apiVersion = 'v{{ config('app.referential_api_version') }}';
        const apiUrl = `{{ url('api/${apiVersion}/referential/metadata/dictionary', request('referential')) }}`;
    </script>
    <script src="{{ mix('js/metadata-dictionary.js') }}"></script>
@endpush
