@extends('layouts.admin_layout')

@section('content')
    @include('includes.tinyeditor')
    <h2 class="page-header">About Page</h2>

    <h4 class="update-home-message green-background"></h4>
    <div class="form-group">
        <textarea name="description" class="form-control" id="about-body" required rows="8" cols="8">{!! $about->about_page !!}</textarea>
    </div>

    <div class="form-group">
        <input type="button" class="btn btn-primary pull-right update-about-frm" id="update-home" value="Update">
    </div>

@endsection

@section('scripts')
    <script src="{{asset('js/admin_items.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('.update-about-frm').on('click', function (e) {
                e.preventDefault();
                tinyMCE.triggerSave();
                const data = {'body': $('#about-body').val()};

                const url = 'update_about';
                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        $(".update-home-message").html('About page has been updated.').show('slow').delay(5000).fadeOut();
                    },
                    error  : function (data) {
                        console.log('about page was not updated.');
                    }
                });
            })
        })
    </script>

@endsection