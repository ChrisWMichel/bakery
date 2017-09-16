
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.display-category').hide();
$('.hide-page').show();
$('.hide-add-item').hide();

$('#show-add-items').on('click', function (e) {
    e.preventDefault();
    $('.hide-add-item').slideToggle('slow');
    $('.menu').toggle('hide');

});

$('#view-cat').on('click', function (e) {
    e.preventDefault();
    $('.display-category').slideToggle('slow');

    $('.hide-page').toggle('hide');
});

/*Prevent user from using '$' sign*/
$(function () {
    $(document).on('keyup keydown keypress', function (event) {
        if (event.charCode === 36) {
            return false;
        }
    });
});

/* Catch form validation */
function printErrorMsg (msg) {
    $(".error").find("ul").html('');
    $('.error').removeClass('hidden');
    $.each( msg, function( key, value ) {
        $(".error").find("ul").append('<li>'+value+'</li>');
    });
}

$('.form-message').hide();





