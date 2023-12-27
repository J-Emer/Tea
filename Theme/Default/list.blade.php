@extends('default.main')

@section('content')
    
    <ul>
        @foreach ($data['posts'] as $item)
            <li>
                <a href="@Url/posts/{{ $data['category']}}/{{ $item }}">{{ $item }}</a>
            </li>
        @endforeach
    </ul>

@endsection