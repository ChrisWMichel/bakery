

    @foreach($orders as $order)
        <h4 class="blue-font re-order-msg" id="re-order-msg-{{$order->id}}"></h4>

            <table class="table table-striped table-bordered tbl-pastOrders" id="order-block-{{$order->id}}">
                <thead>
                <tr>
                    <td class="boldFont">
                        Ordered on: {{Carbon\Carbon::parse($order->created_at)->format('m/d/Y')}}
                    </td>
                    <td>&nbsp;</td>
                    <td><a href="#" class="btn btn-xs btn-danger delete-order pull-right" id="{{$order->id}}">X</a> </td>
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
                            <td colspan="2" class="text-cell"><textarea class="past-notes" id="past-notes-{{$order->id}}">{{$order->notes}}</textarea></td>
                            <td align="center"><input type="button" id="{{$order->id}}" class="btn btn-sm setBtn re-order" value="Re-order"></td>
                        </tr>

                </tfoot>

             </table>

            @endforeach



<script>
    $('.re-order').on('click', function (e) {
        e.preventDefault();
        const orderID = $(this).attr('id');

        const data = {
            'order_id' : orderID,
            'message' : $('#past-notes-' + orderID).val()
        };

        const url = 're_order';
        $.ajax({
            url    : url,
            type   : 'post',
            data    : data,
            success: function (data) {
                $('#re-order-msg-' + orderID).html('Order has been placed. Email will be sent with confirmation.');
            },
            error  : function () {
                console.log('problem with loading past order page.');
            }
        });
    });

    $('.delete-order').on('click', function (e) {
        e.preventDefault();
        const order_id = $(this).attr('id');

        console.log('ID: ' + order_id);
        $('table#order-block-' + order_id).addClass('transparent');
        const url = 'delete_order/' + order_id;
        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
               // console.log(data);

                $('#re-order-msg-' + order_id).html('Order has been marked for deletion.');

            },
            error  : function () {
                console.log('problem with loading past order page.');
            }
        });
    })
</script>