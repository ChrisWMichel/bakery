@extends('layouts.admin_layout')

@section('content')
    @include('includes.tinyeditor')
    <h2 class="page-header">Contact Page</h2>

    <h4 class="update-home-message green-background"></h4>
    <div class="form-group">
        <div class="error text-center alert-danger hidden">
            <ul></ul>
        </div>
    </div>
    <form action="#" class="update-contact">
        <table border="0" class="contact-frm">
            <tr>
                <td>
                    <label for="name">Business Name:</label>
                </td>
                <td>
                    <input type="text" name="name" value="{{$info->name}}" class="form-control" id="name" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="address">Address:</label>
                </td>
                <td>
                    <input type="text" name="address" value="{{$info->address}}" class="form-control" id="address" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="city">City:</label>
                </td>
                <td>
                    <input type="text" name="city" value="{{$info->city}}" class="form-control" id="city" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="state">State:</label>
                </td>
                <td>
                    <input type="text" name="state" value="{{$info->state}}" class="form-control" id="state" maxlength="2" required>
                </td>

            </tr>
            <tr>
                <td>
                    <label for="zipcode">Zipcode:</label>
                </td>
                <td>
                    <input type="text" name="zipcode" value="{{$info->zipcode}}" class="form-control" id="zipcode" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="phone">Phone:</label>
                </td>
                <td>
                    <input type="text" name="phone" value="{{$info->phone}}" class="form-control" id="phone" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="email">Email:</label>
                </td>
                <td>
                    <input type="text" name="email" value="{{$info->email}}" class="form-control" id="email" required>
                </td>
            </tr>
            <tr>
                <td>
                   &nbsp;
                </td>
                <td>
                    <input type="submit" class="btn btn-primary pull-right update-about-frm" id="update-contact" value="Update">
                </td>
            </tr>
        </table>
    </form>
@endsection

@section('scripts')
    <script src="{{asset('js/admin_items.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('.update-about-frm').on('click', function (e) {
                e.preventDefault();
                $(".error").find("ul").html('');

                const data = {
                    'name': $('input[name=name]').val(),
                    'address': $('input[name=address]').val(),
                    'city': $('input[name=city]').val(),
                    'state': $('input[name=state]').val(),
                    'zipcode': $('input[name=zipcode]').val(),
                    'phone': $('input[name=phone]').val(),
                    'email': $('input[name=email]').val(),
                };

                const url = 'update_contact';
                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        $(".update-home-message").html('Home page has been updated.').show('slow').delay(5000).fadeOut();
                    },
                    error  : function (data) {
                        let response = JSON.parse(data.responseText);
                        printErrorMsg(response);
                        data.responseText = [];
                    }
                });
            })
        })
    </script>

@endsection