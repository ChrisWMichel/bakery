<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}} "/>

    <link rel="icon" type="image/png" href="{{asset('favicon.png')}}" sizes="32x32">
    <title>Your Bakery</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}} "/>
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet" type="text/css"  media="all" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"  media="all" />
    <link href="{{asset('css/public.css')}}" rel="stylesheet" type="text/css"  media="all" />
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

    <style>
        .active { color: #beac7c!important;}

    </style>

</head>
<body>
<div class="header">
    <div class="header_img">
        <img src="images/header_img.jpg" alt="" />
    </div>
</div>
<div class="header_bottom">

    <div class="wrap">
        <div class="logo">
            <a href="index.html"><img src="images/logo.png" alt="" /></a>
        </div>
        <div class="menu nav">
            <ul>
                <li class="pages active" id="home"><a href="#">Home</a></li>
                <li class="pages" id="about"><a href="#">About</a></li>
                <li class="pages" id="menu"><a href="#">Menu</a></li>
                <li class="pages" id="hours"><a href="#">Hours</a></li>
                <li class="pages" id="contact"><a  href="#">Contact</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>

<!---start-content---->

<div class="mainLayout">


</div>


<!---End-main---->
<!---Footer---->
<div class="container">
    <footer class="footer">
        <div class="container">
            <p class="text-center">Your Bakery | All rights reserved &copy; | {{date('Y')}}</p>
        </div>
    </footer>
</div>

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/public.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    window.addEventListener("beforeunload", function () {
        document.body.classList.add("animate-out");
    });

    $( window ).on('load', function(e) {
        e.preventDefault();
        loadHome();

        function loadHome(){
            $.ajax({
                url: 'get_pages',
                type: 'GET',
                data: 'id=home',
                success: function(data){
                    $('.mainLayout').html(data).fadeOut(1).delay(20).fadeIn('slow');
                },
                error: function(data){
                    //console.log(data);
                    $('.mainLayout').html('Something went wrong onload.');
                }
            })
        }
    });
    $(document).ready(function () {
        $('.pages').on('click', function(e){
            $('.mainLayout').fadeOut('fast');

            e.preventDefault();
            let page = $(this).attr('id');

            loadPage(page);
            $(this).parents('.nav').find('.active').removeClass('active').end().end().addClass('active');

            function loadPage(page){
                $.ajax({
                    url: 'get_pages',
                    type: 'GET',
                    data: 'id=' + page,
                    success: function(data){
                        if(page === 'menu'){
                            $('.header_img').hide();
                            $('.logo').hide();
                        }
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
</body>
</html>