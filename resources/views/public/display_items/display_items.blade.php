
<div class="checkCake" id="{{$cake}}"></div>
@foreach($items as $item)

    <div class="listview_1_of_2">
        <div class="displayDescription">
            {!! str_limit($item->description, 500)  !!}
        </div>
        <div class="text list_2_of_1">
            <h3>{{$item->item}}</h3>

            <div class="col-lg-12 display-price">
                <h4>${{$item->price}} {{$item->volume}}</h4>&nbsp;&nbsp;&nbsp;
                <div class="price-quantity">
                    <div id="quantity">Quantity:</div>&nbsp;
                    <input type="text" class="quantity" name="quanity" value="1" id="quant-{{$item->id}}" maxlength="2">&nbsp;&nbsp;&nbsp;
                    <button name="addBtn" class="btn btn-primary btn-xs addBtn" id="{{$item->id}}">ADD</button>
                </div>
            </div>{{--col-lg-8--}}

        </div>
    </div>

@endforeach

<script>
    if (($(window).width() < 400)){
        $('div').removeClass('row');
    }

    if(checkIfOpen == false){
        $('.price-quantity').hide();
        $('.menu-emailBtn').hide();
    }
    $(document).ready(function () {


        $('.addBtn').on('click', function (e) {
            e.preventDefault();
            const item_id = $(this).attr('id');
            const qty = $('#quant-' + item_id).val();

            const cake = $('.checkCake').attr('id');

            data = {
                'item_id' : item_id,
                'quantity': qty
            };
            if (cake) {
                url = '/add_cake_order_frm'
            } else {
                url = '/add_order_form';
            }
            $.ajax({
                url    : url,
                type   : 'post',
                data   : data,
                success: function (data) {
                    $('.order-form').html(data);
                },
                error  : function (data) {
                    console.log('problem with order form.');
                }
            });
        })

    })
</script>