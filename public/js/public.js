$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*
function printErrorMsg (msg) {
    $(".error").find("ul").html('');
    $('.error').removeClass('hidden');
    $.each( msg, function( key, value ) {
        $(".error").find("ul").append('<li>'+value+'</li>');
    });
}*/

//const divListProduct = document.getElementById('list-product');
//divListProduct.scrollTop = divListProduct.scrollHeight;
$(document).scrollTop(0);


