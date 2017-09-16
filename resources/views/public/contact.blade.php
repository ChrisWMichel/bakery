<div class="main">
    <div class="wrap">
        <div class="contact_desc">
            <div class="col-lg-6">
                <div class="content_bottom">
                    <div class="company_address">
                        <h2>Location</h2>
                        <p>{{$contact->name}}</p>
                        <p>{{$contact->address}}</p>
                        <p>{{$contact->city}}</p>
                        <p>Phone:{{$contact->phone}}</p>

                        <p>Follow on: <span><a target="_blank" href="https://www.facebook.com/pages/Dorcas-Bakery-Harvard-Il/1447962711959533">Facebook</a></span></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">

                <div id="contact-page" >

                    <div class="error text-center alert alert-danger hidden" id="control-width">
                        <ul></ul>
                    </div>

                </div>

                <div class="contact-form">
                    <h2>Contact Us</h2>
                    <form method="post" action="#" class="left_form" id="contact-form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <span><label>Name</label></span>
                            <span><input name="firstname" id="firstname" type="text" class="textbox form-control"></span>
                        </div>
                        <div class="form-group">
                            <span><label>Email</label></span>
                            <span><input name="email" id="email" type="text" class="textbox form-control"></span>
                        </div>
                        <div class="form-group">
                            <span><label>Message</label></span>
                            <span><textarea name="message" id="message" class="form-control" rows="8"> </textarea></span>
                        </div>
                        <div class="form-group">
                            <span><input type="submit" value="Submit" class="send-message myButton"></span>
                        </div>
                    </form>

                    <div class="clear"></div>
                </div>
                <div class="processing">
                    <div class="col-lg-12 text-center">
                        <img src="{{asset('processing.gif')}}" width="274px" height="274px">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{asset('js/public.js')}}"></script>
<script>
    $('.header_img').show();
    $('.logo').show();
    $('.processing').hide();

    $('#contact-form').on('submit', function(e){
        e.preventDefault();

        //$(".error").find("ul").html('');
       // $('.error').addClass('hidden');

        data = {
            'firstname' : $('#firstname').val(),
            'email'     : $('#email').val(),
            'message'   : $('#message').val()
        };

        $('.contact-form').hide();
        $('.processing').show();

        const url = 'send_message';

        $.ajax({
            url    : url,
            type   : 'post',
            data   : data,
            dataType: "json",
            success: function (data) {
                $('.processing').hide();
                $('#contact-page').html("<h3 style='color: blue; margin-top: 50px;'> Thanks for contacting us " + data.firstname + ". Your message has been sent.</h3>").fadeOut(1).delay(20).fadeIn('slow');
            },
            error  : function (data) {
                let response = JSON.parse(data.responseText); //data.responseText
                printErrorMsg(response);
                //data.responseText = [];
            }
        });
        function printErrorMsg (msg) {
            $(".error").find("ul").html('');
            $('.error').removeClass('hidden');
            $.each( msg, function( key, value ) {
                $(".error").find("ul").append('<li>'+value+'</li>');
            });
        }
    })
</script>