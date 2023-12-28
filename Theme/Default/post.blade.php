@extends('main')

@section('content')
    


    {!! $content !!}


    <small>{{ $data['author'] }} | {{ $data['published'] }}</small>


@endsection