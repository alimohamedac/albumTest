@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Albums</h1>
        <a href="{{ route('albums.create') }}" class="btn btn-primary">Create Album</a>
        <ul>
            @foreach($albums as $album)
                <li>
                    <a href="{{ route('albums.edit', $album->id) }}">{{ $album->name }}</a>
                    <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('albums.destroy', $album->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

