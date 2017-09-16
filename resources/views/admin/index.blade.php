@extends('layouts.admin_layout')

@section('content')
    <br>

    <div class="checkIfOpen" id="{{$openClose->open}}"></div>

        <div class="col-lg-4 pull-left">
            <form method="post" action="{{url('toggle_open_close')}}" class="open-frm">
            {{csrf_field()}}
                <input type="hidden" name="checkStore" value="{{$openClose->open}}">
                <input type="submit" class="btn btn-lg check-status" id="openCloseBtn" value="Closed">
            </form>
        </div>
    <div class="business-open col-lg-offset-4 col-lg-8">
        <h3 class="taking-orders">Ready to take orders.</h3>
    </div>
    <div class="clearfix"></div>
<hr>

    <div class="incomingOrders"></div>

@endsection

@section('scripts')
    <script>
        $( window ).on('load', function(e) {
            e.preventDefault();
            const url = 'get_order_updates';
            $.ajax({
                url    : url,
                type   : 'get',
                success: function (data) {
                    $('.incomingOrders').html(data);
                },
                error  : function (data) {
                    console.log('Orders are not being checked');
                }
            })
        });

        $(document).ready(function () {
            const check = $('.checkIfOpen').attr('id');
            if(check != 0){
                $('.check-status').removeClass('btn-danger').addClass('btn-success').val('Opened');
                $('.taking-orders').html('Ready to take orders');
            }else{
                $('#openCloseBtn').removeClass('btn-success').addClass('btn-danger').val('Closed');
                $('.taking-orders').html('Orders are not being accepted.');
            }


            setInterval(function() {

                var url = 'get_order_updates';
                $.ajax({
                    url    : url,
                    type   : 'get',
                    success: function (data) {
                        $('.incomingOrders').html(data);
                    },
                    error  : function (data) {
                        console.log('Orders are not being checked');
                    }
                })

            }, 1000 * 60 * 2);

        });
    </script>
@endsection