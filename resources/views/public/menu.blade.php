
<div class="main wrap">
    <div class="checkIfOpen" id="{{$openClose->open}}"></div>
    <div class="cartContent" id="{{$cart_content}}"></div>

        <div class="col-sm-8">
            <div class="menu-emailBtn">
                <input type="email" name="menu_cust_email" placeholder="Enter email">
                <input type="button" class="btn btn-sm setBtn" id="menu-check-email" value="submit">
                <span>(Order history)</span>
            </div>
            {{--<h4 class="close-msg tan-background">We ar currently not taking orders on-line. Check back soon or stop on by.</h4>--}}

            <h4 class="no_order_history"></h4>
            <h4 class="past-orders"></h4>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="container">
                    <nav class="navbar navbar-inverse">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>

                            </div>
                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav">
                                    @foreach($categories as $category)
                                        <li class="cat-menu" id="{{$category->id}}"><a href="#">{{$category->name}}</a></li>

                                    @endforeach

                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cakes
                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            @foreach($categoryCakes as $cake)
                                                <li class="cake-menu" id="{{$cake->id}}" data-toggle="dropdown"><a href="#">{{$cake->name}}</a></li>
                                            @endforeach

                                        </ul>
                                    </li>
                                </ul>
                            </div>{{--.nav-collapse--}}
                        </div>
                    </nav>
                </div>

            </div>
        </div>

<table border="1">
    <tr>
        <td width="70%" class="leftProducts">
                <div id="list-product" class="items_desc">
                {{--<div class="wrap">--}}
                    <div class="display-items">
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
                    </div>

                   {{-- </div>--}} {{--wrap--}}
                </div>{{-- #list-product --}}
            {{--</div>--}}
        </td>

        <td width="30%" class="orderFrm rightOrderList" >
            <div class="orderlist">
                <h3 class="orderTitle">Order Form</h3>
                <div class="order-form"></div>
            </div>
        </td>
    </tr>
</table>
</div>

@include('public.past_orders.past_orders')
<script>
    /*if (($(window).width() < 400)){
        $('div').removeClass('row');
        //$('.price-quantity').removeClass('row');

    }*/
    //let checkIfOpen = null;
    $(document).ready(function () {
        const check = $('.checkIfOpen').attr('id');
        if(check == 0){
            $('.price-quantity').hide();
            $('.menu-emailBtn').hide();
            $('td.rightOrderList').hide();
             checkIfOpen = false;
            $('.close-msg').show();
        }else {
            checkIfOpen = true;
            $('.close-msg').hide();
        }

        const cart_content = $('.cartContent').attr('id');
        if(cart_content){
            url = '/get_order_form';
            $.ajax({
                url : url,
                type : 'get',
                //data : data,
                success : function (data) {
                    $('.nav').find('.active-menu').removeClass('active-menu').end().end().addClass('active-menu');
                    //$(this).addClass('.active-menu');
                    $('.order-form').html(data);
                },
                error   : function (data) {
                    console.log('problem with order form.');
                }
            });
        }

        $('li.cat-menu').first().addClass('active-menu');

        $('.cat-menu').on('click',  function (e) {
            e.preventDefault();
            const cat_id = $(this).attr('id');

            $(this).parents('.nav').find('.active-menu').removeClass('active-menu').end().end().addClass('active-menu');

            const url = 'change_category/' + cat_id;
            $.ajax({
                url     : url,
                type    : 'get',
                success : function (data) {
                    $('.display-items').html(data);
                    //console.log('this is the success function');
                },
                error   : function () {
                    console.log('problem with loading page.');
                }
            });
        });

        $('.cake-menu').on('click', function (e) {
            e.preventDefault();
            const cat_id = $(this).attr('id');

            $('.cat-menu').removeClass('active-menu');
            $(this).parents('.nav').find('.cake-acitve').removeClass('cake-acitve').end().end().addClass('cake-acitve');

            const url = 'change_cake_category/' + cat_id;
            $.ajax({
                url     : url,
                type    : 'get',
                success : function (data) {
                    $('.display-items').html(data);
                    //console.log('this is the success function');
                },
                error   : function () {
                    console.log('problem with loading page.');
                }
            });
        });

        $('.addBtn').on('click', function (e) {
            e.preventDefault();
            const item_id = $(this).attr('id');
            const qty = $('#quant-' + item_id).val();

            data = {
                'item_id' : item_id,
                'quantity'   : qty
            };

            url = '/add_order_form';
            $.ajax({
                url : url,
                type : 'post',
                data : data,
                success : function (data) {
                    $('.order-form').html(data);
                },
                error   : function (data) {
                    console.log('problem with order form.');
                }
            });
        })
    });

    $('#menu-check-email').on('click', function (e) {
        e.preventDefault();
        const email = $('input[name=menu_cust_email]').val();
        $('.menu-emailBtn').hide();

        const url = 'search_cust_email/' + email;
        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
                if (data === 'empty') {
                    $('h4.no_order_history').html('You have no past orders.');
                    //$('input[name=email]').val(email);
                }else{
                    $('.past-orders').html("<button type=\"button\" class=\"btn setBtn btn-sm past-orders\" data-toggle=\"modal\" data-target=\"#myModal\">Past Orders</button>");
                    window.customerID = data.cust_id;
                }
                //console.log(data);
            },
            error  : function () {
                console.log('problem with loading page.');
            }
        });
    });

    $('.past-orders').on('click', function (e) {
        e.preventDefault();
        const cust_id = window.customerID;

        const url = 'get_past_orders/' + cust_id;
        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
                //console.log(data);
                $('.list_past_orders').html(data);
            },
            error  : function () {
                console.log('problem with loading past order page.');
            }
        });
    })
</script>