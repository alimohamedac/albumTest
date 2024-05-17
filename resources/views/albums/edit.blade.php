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

        <div class="card-body">
            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
            <h5 class="card-title">اضافة مرفقات</h5>
            <form method="post" action="{{ url('/pictures') }}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile"
                           name="name" required>
                    <input type="hidden" id="customFile" name="album_id"
                           value="{{ $album->id }}">
                    <label class="custom-file-label" for="customFile">حدد
                        المرفق</label>
                </div><br><br>
                <button type="submit" class="btn btn-primary btn-sm "
                        name="uploadedFile">تاكيد</button>
            </form>
        </div>
        <br>
        <div class="table-responsive mt-15">
            <table class="table center-aligned-table mb-0 table table-hover"
                   style="text-align:center">
                <thead>
                <tr class="text-dark">
                    <th scope="col">م</th>
                    <th scope="col">اسم الملف</th>
                    <th scope="col">تاريخ الاضافة</th>
                    <th scope="col">العمليات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach ($attachments as $attachment)
                    <?php $i++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $attachment->name }}</td>
                        <td>{{ $attachment->created_at }}</td>
                        <td colspan="2">

                            <a class="btn btn-outline-success btn-sm"
                               href="{{ route('openFile', [$album->id, $attachment->name]) }}"
                               role="button"><i class="fas fa-eye"></i>&nbsp;
                                عرض</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>
@endsection

@section('footer-scripts')
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
