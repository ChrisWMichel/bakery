@foreach($orders as $order)

    <h3 id="msg-sent-{{$order->id}}" class="blue-font"></h3>
    <div class="customer_info" id="cust-{{$order->id}}">
        <table class="cust-info" border="1">
            <tr>
                <td class="boldFont">{{$order->customer->firstname}} {{$order->customer->lastname}}</td>
            </tr>
            <tr>
                <td>{{$order->customer->phone}}</td>
                <td>{{$order->customer->email}}</td>
            </tr>
            <tr>
                <td colspan="2" class="cust-msg"><textarea class="past-notes" disabled>{{$order->notes}}</textarea></td>
            </tr>
        </table>
        <table class="table table-striped table-bordered tbl-pastOrders" id="order-block-{{$order->id}}">
            <thead>
            <tr>
                <td class="boldFont">
                    Ordered at: {{Carbon\Carbon::parse($order->created_at)->format('g:i A')}}
                </td>
                <td>&nbsp;</td>
                <td><a href="#" class="btn btn-xs btn-warning delete-order pull-right" id="{{$order->id}}">Cancel</a> </td>
            </tr>
            <tr>
                <th>Name</th>
                <th>Qyt</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderedItems as $item)
                <tr>
                    <td>{{$item->item->item}}</td>
                    <td>{{$item->quantity}} </td>
                    <td>${{$item->item->price}}</td>
                </tr>
            @endforeach
            @foreach($order->orderedCakes as $cake)
                <tr>
                    <td>{{$cake->cakeItem->item}} (cake)</td>
                    <td>{{$cake->quantity}} </td>
                    <td>${{$cake->cakeItem->price}}</td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
            <tr>
                <td colspan="1">&nbsp;</td>
                <td><span class="boldFont">Total</span> (w/tax)</td>
                <td class="boldFont">${{$order->total}}</td>
            </tr>

            <tr>
                <form method="post" action="{{url('reply_to_customer')}}">
                    {{csrf_field()}}
                    <td class="text-cell"><textarea name="reply_message" id="mesg-{{$order->id}}" class="past-notes">{{$order->customer->firstname}}, your order will be ready </textarea></td>
                    <td align="center"><input type="submit" id="{{$order->id}}" class="btn btn-success setBtn reply-cust" value="Complete"></td>
                </form>
            </tr>

            </tfoot>

        </table>
        <hr>
    </div>

@endforeach
<audio id="sound">
    <source src="{{asset('Store_Door_Chime.mp3')}}"  type='audio/mpeg'>
</audio>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var newCount = $('.customer_info').length;


    var url = 'check_order_count/' + newCount;
    $.ajax({
        url    : url,
        type   : 'get',
        success: function (data) {
            console.log('count: ' + data );
            if(data === 'true'){
                document.getElementById("sound").play();
            }
        },
        error  : function (data) {
            console.log('Sound notication not working.');
        }
    });


    $('.reply-cust').on('click', function (e) {
        e.preventDefault();
        const order_id = $(this).attr('id');

        const data = {
            'order_id' : order_id,
            'message'   : $('#mesg-' + order_id).val()
        };
        //console.log(data);

        const url = 'reply_to_customer';
        $.ajax({
            url    : url,
            type   : 'post',
            data    : data,
            success: function (data) {
                $('#cust-' + order_id).hide();
                $("#msg-sent-" + order_id).html('Message has been sent.').show('slow').delay(5000).fadeOut();
            },
            error  : function (data) {
                console.log('Email not being sent.');
            }
        })
    });

    $('.delete-order').on('click', function (e) {
        e.preventDefault();
        const order_id = $(this).attr('id');

        const data = {
            'order_id' : order_id,
            'message'   : $('#mesg-' + order_id).val()
        };

        const url = 'cancel_cust_order';
        $.ajax({
            url    : url,
            type   : 'post',
            data    : data,
            success: function (data) {
                $('#cust-' + order_id).hide();
                $("#msg-sent-" + order_id).html('Message has been sent, and order has been deleted.').show('slow').delay(5000).fadeOut();
            },
            error  : function (data) {
                console.log('Email not being sent.');
            }
        })
    })
</script>