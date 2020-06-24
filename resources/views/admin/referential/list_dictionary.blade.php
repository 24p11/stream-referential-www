@extends('layouts.base_admin')

@section('content')
    <div id="list-dictionary"></div>
@endsection

@push('scripts')
    <script>
        const referential = "{{ request('referential') }}";
        const apiVersion = 'v{{ config('app.referential_api_version') }}';
        const baseApiUrl = `{{ url('api/${apiVersion}/list_dictionary') }}`;
        const apiUrl = `${baseApiUrl}/{{ request('referential') }}`;
    </script>
    <script src="{{ mix('js/list-dictionary.js') }}"></script>
@endpush
