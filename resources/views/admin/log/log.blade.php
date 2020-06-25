@extends('layouts.base_admin')

@section('content')
    <div id="log">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Log</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->entry }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:m:s')  }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')

@endpush
