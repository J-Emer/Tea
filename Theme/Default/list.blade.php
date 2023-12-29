@extends('main')

@section('content')
    
    <h2>{{ $data['title'] }}</h2>

    <ul>
        @foreach ($data['posts'] as $item)
            <li>
                <a href="@Url/posts/{{ $data['category']}}/{{ $item }}">{{ $item }}</a>
            </li>
        @endforeach
    </ul>

@endsection