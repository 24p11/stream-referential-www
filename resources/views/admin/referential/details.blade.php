@extends('layouts.base_admin')

@section('content')
    <div id="details"></div>
@endsection

@push('scripts')
    <script>
        const referential = "{{ request('referential') }}";
        const referentialApiVersion = 'v{{ config('app.referential_api_version') }}';
        const referentialApiUrl = `{{ url('api/${referentialApiVersion}/referential', request('referential')) }}`;
    </script>
    <script src="{{ mix('js/details.js') }}"></script>
@endpush
