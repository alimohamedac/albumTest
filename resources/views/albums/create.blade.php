@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <h1>Create Album</h1>
        <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="name">Album Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
            <h5 class="card-title">المرفقات</h5>

            <div class="col-sm-12 col-md-12">
                <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                       data-height="70" />
            </div><br>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>

    </div>
@endsection

@section('footer-scripts')
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
@endsection
