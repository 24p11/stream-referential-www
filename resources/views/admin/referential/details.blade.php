@extends('layouts.base_admin')

@section('content')
    <div id="details"></div>
@endsection

@push('scripts')
    <script>
        const referential = "{{ request('referential') }}";
        const referentialApiVersion = "{{ url('api/v1/referential', request('referential')) }}";
    </script>
    <script src="{{ mix('js/details.js') }}"></script>
@endpush
