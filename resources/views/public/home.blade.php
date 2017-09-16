
<div class="main">
    <div class="checkIfOpen" id="{{$openClose->open}}"></div>
    <div class="wrap">
        <div class="welcome_desc">
            <div class="section group">
                <div class="col_1_of_2 span_1_of_2">
                    <h3>Welcome to <br> <span>Your Bakery</span></h3>

                    {!! $home->body !!}

                </div>
                <div class="col_1_of_2 span_1_of_2">
                    <div class="grid_img">
                        <img src="{{$path}}" alt="" />
                    </div>
                    <div class="price_desc">
                        <a href="#" id="{{$item->id}}" class="special"><div class="price">${{$item->price}}</div>
                            <div class="price_text"><h4><span>Today Special</span>{{$item->item}}</h4></div>
                            <div class="clear"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $('.header_img').show();
    $('.logo').show();

    $(document).ready(function () {
        const check = $('.checkIfOpen').attr('id');

        $('.special').on('click', function(e){
            e.preventDefault();
            let item_id = $(this).attr('id');

            $('.mainLayout').fadeOut('fast');
            if(check == 0){
                item_id = 'home';
            }

            loadPage(item_id);
            $(this).parents('.nav').find('.active').removeClass('active').end().end().addClass('active');

            function loadPage(item_id){
                $.ajax({
                    url: 'get_pages',
                    type: 'GET',
                    data: 'id=' + item_id,
                    success: function(data){

                            $('.header_img').hide();
                            $('.logo').hide();

                        $('.mainLayout').html(data).fadeIn('slow'); //.fadeOut(1).delay(20).fadeIn('slow')
                    },
                    error: function(data){
                        //console.log(data);
                        $('.mainLayout').html('Something went wrong.');
                    }
                })
            }
        });
    });
</script>