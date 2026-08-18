@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Monthly Report</h1>
        <p>{{ $year }}/{{ $month }}</p>

        @include('acp.entry.list', ['entries' => $entries])
    </div>
@endsection
