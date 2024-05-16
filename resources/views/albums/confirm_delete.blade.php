@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Delete Album</h1>
    <p>The album "{{ $album->name }}" is not empty. What would you like to do with the pictures?</p>
    <form action="{{ route('albums.deleteOrMove', $album->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="radio" id="delete" name="action" value="delete" required>
            <label for="delete">Delete all pictures</label>
        </div>
        <div class="form-group">
            <input type="radio" id="move" name="action" value="move" required>
            <label for="move">Move pictures to another album</label>
            <select name="target_album_id" class="form-control">
                @foreach($all_albums as $targetAlbum)
                    @if($targetAlbum->id !== $album->id)
                        <option value="{{ $targetAlbum->id }}">{{ $targetAlbum->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
</div>
@endsection
