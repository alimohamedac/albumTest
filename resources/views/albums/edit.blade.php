@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Edit Album</h1>
        <form action="{{ route('albums.update', $album->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Album Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $album->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
