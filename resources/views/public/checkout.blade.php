<div class="container-fluid">

<h2 class="page-header">Check Out</h2>
    <div class="checkout-page">
        <div class="col-lg-5">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>

                @foreach($cart as $row)
                    <tr>
                        <td>{{$row->name}}</td>
                        <td>{{$row->qty}} </td>
                        <td>${{number_format($row->subtotal, 2) }}</td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td>Subtotal</td>
                        <td>${{number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td>Tax (7%)</td>
                        <td>${{number_format($tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td>Total</td>
                        <td>${{number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-lg-5 pull-right">
            <div class="emailBtn">
                <h4 class="email-msg"></h4>
            <input type="email" name="cust_email" value="{{$email}}" placeholder="Enter email" required>
            <input type="button" class="btn btn-sm setBtn" id="check-email" value="submit">
            </div>
            <div class="form-group">
                <div class="error text-center alert-danger hidden">
                    <ul></ul>
                </div>
            </div>
            <div class="cust-form">
                <h4>Please fill out form. This is a one time deal.</h4>
                <form action="#" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="firstname" class="form-control" placeholder="First name" required><br>
                        <input type="text" name="lastname" class="form-control" placeholder="Last name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="Phone number" required><br>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <textarea class="form-control" id="newMessage" placeholder="Add notes for this order."></textarea><br>
                    <div class="form-group">
                        <input type="submit" id="custFrm" class="btn btn-sm setBtn" value="Submit" required>
                    </div>
                </form>

            </div>
            <div class="existing_customer">
                <form action="#" method="post">
                    {{ csrf_field() }}
                    <textarea class="form-control" id="attachMessage" placeholder="Add notes for this order."></textarea><br>
                    <div class="form-group">
                        <input type="button" id="existing_custFrm" class="btn btn-sm setBtn" value="Submit" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="processing">
        <div class="col-lg-12 text-center">
            <img src="{{asset('processing.gif')}}">
        </div>
    </div>
    <div class="order-complete">
        <div class="col-lg-12 text-center">
            <h3 class="blue-font">Your order has been submitted.</h3>
            <h3 class="blue-font">We'll email you to let you know when it'll be ready.</h3>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('.cust-form').hide();
        $('.processing').hide();
        $('.order-complete').hide();
        $('.existing_customer').hide();

        $('#check-email').on('click', function (e) {
            //e.preventDefault();
            const email = $('input[name=cust_email]').val();
            if(email === ''){
                $('.email-msg').html('You need to enter an email.');
                return;
            }else(
                $('.emailBtn').hide()
            );


            const url = 'search_cust_email/' + email;
            $.ajax({
                url    : url,
                type   : 'get',
                success: function (data) {
                    if (data === 'empty') {
                        $('.cust-form').fadeIn('slow');
                        $('input[name=email]').val(email);
                    }else{
                        $('.existing_customer').fadeIn('slow');
                    }
                    //console.log(data);
                },
                error  : function () {
                    console.log('problem with loading page.');
                }
            });
        });

        $('#custFrm').on('click', function (e) {
            e.preventDefault();
            $('.error').addClass('hidden');
            data = {
                'firstname': $('input[name=firstname]').val(),
                'lastname' : $('input[name=lastname]').val(),
                'message'  : $('#newMessage').val(),
                'phone'    : $('input[name=phone]').val(),
                'email'    : $('input[name=email]').val(),
            };
            $('.checkout-page').hide();
            $('.processing').show();
            const url = "{{route('customer.store')}}";
            $.ajax({
                url    : url,
                type   : 'post',
                data   : data,
                success: function (data) {
                    $('.processing').hide();
                    $('.order-complete').show();
                },
                error  : function (data) {
                    $('.checkout-page').show();
                    $('.processing').hide();
                    let response = JSON.parse(data.responseText);
                    printErrorMsg(response);
                    data.responseText = [];
                }
            });
        });

        function printErrorMsg(msg) {
            $(".error").find("ul").html('');
            $('.error').removeClass('hidden');
            $.each(msg, function (key, value) {
                $(".error").find("ul").append('<li>' + value + '</li>');
            });
        }

        $('#existing_custFrm').on('click', function (e) {
            e.preventDefault();
            data = { 'message' : $('#attachMessage').val()};

            $('.checkout-page').hide();
            $('.processing').show();

            const url = "{{route('customer.store')}}";
            $.ajax({
                url    : url,
                type   : 'post',
                data   : data,
                success: function (data) {
                    $('.processing').hide();
                    $('.order-complete').show();
                },
                error  : function (data) {
                    //$('.checkout-page').show();
                    //$('.processing').hide();

                }
            });
        })
    })

</script>