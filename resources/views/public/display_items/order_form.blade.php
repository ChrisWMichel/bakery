<div class="order-updated">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
            @foreach($cart as $row)
                <tr>
                    <td>{{$row->name}}</td>
                    <td><input type="text" class="quantity" name="quanity" id="{{$row->rowId}}" value="{{$row->qty}}" maxlength="2"> </td>
                    <td>${{number_format($row->price, 2)}}</td>
                    <td class="subtotal" id="{{$row->rowId}}">${{number_format($row->subtotal, 2) }}</td>
                    <td><button class="btn btn-danger btn-xs delete-row" id="{{$row->rowId}}">X</button> </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <button class="btn checkout btn-sm pull-right">Check Out</button>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('input[type=text]').on("change paste keyup", function () {
            id = $(this).attr('id');
            data = {
                qty: $(this).val(),
                id : id
            };

            url = 'order_updated';
            $.ajax({
                url    : url,
                type   : 'post',
                data   : data,
                success: function (data) {
                    $('td#' + id).text('$' + data.subtotal);
                },
                error  : function (data) {
                    console.log('problem with order form.');
                }
            });
        });

        $('.checkout').on('click', function (e) {
            e.preventDefault();
            let page = 'checkout';

            $('.nav').find('.active').removeClass('active');

            loadPage(page);

            function loadPage(page) {
                $.ajax({
                    url    : 'get_pages',
                    type   : 'GET',
                    data   : 'id=' + page,
                    success: function (data) {
                        $('.header_img').show();
                        $('.logo').show();
                        $('.mainLayout').html(data).fadeIn('slow'); //.fadeOut(1).delay(20).fadeIn('slow')
                    },
                    error  : function (data) {
                        //console.log(data);
                        $('.mainLayout').html('Something went wrong.');
                    }
                })
            }
        });

        $('.delete-row').on('click', function (e) {
            e.preventDefault();

            const rowID = $(this).attr('id');
            $(this).closest('tr').hide();

            url = 'delete_row_item/' + rowID;
            $.ajax({
                url    : url,
                type   : 'get',
                success: function (data) {
                    console.log(data);
                },
                error  : function (data) {
                    console.log('problem with order form.');
                }
            });
        })
    })
</script>