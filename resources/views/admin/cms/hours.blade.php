@extends('layouts.admin_layout')

@section('content')

    <h2 class="page-header">Hours Page</h2>

    <h4 class="update-home-message green-background"></h4>
    <div class="col-lg-offset-3 col-lg-6">
        <table class="table table-bordered ">
            <thead>
            <tr>
                <th>Days</th>
                <th>Open</th>
                <th>Close</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hours as $hour)
            <tr>
                <td>{{$hour->day}}</td>
                <td><input type="text" class="hr-open" id="open-{{$hour->id}}" value="{{$hour->open}}"></td>
                <td><input type="text" class="hr-close" id="close-{{$hour->id}}" value="{{$hour->close}}"></td>
                <td><input type="button" class="btn btn-sm btn-primary hr-submit" id="{{$hour->id}}" value="Update"></td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <h4 class="update-message green-background"></h4>
        <div class="form-group">
            <textarea name="description" class="form-control update-msg" rows="4">{{$message->hours_page}}</textarea>
        </div>

        <div class="form-group">
            <input type="button" class="btn btn-primary pull-right update-hour-msg" value="Update">
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/admin_items.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('.hr-submit').on('click', function (e) {
                e.preventDefault();
                const id = $(this).attr('id');

                const data = {
                    'id'    : id,
                    'open'  : $('#open-' + id).val(),
                    'close'  : $('#close-' + id).val()
                };


                const url = 'update_hours';
                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {

                        $(".update-home-message").html(data +' hours has been updated successfully.').show('slow').delay(5000).fadeOut();
                    },

                });
            });

            $('.update-hour-msg').on('click', function (e) {
                e.preventDefault();
                const message = $('.update-msg').val();

                const data = {
                    'message'   : message
                };

                const url = 'update_hours_message';
                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        $(".update-message").html('Message has been updated successfully.').show('slow').delay(5000).fadeOut();
                    },

                });
            })
        })
    </script>

@endsection