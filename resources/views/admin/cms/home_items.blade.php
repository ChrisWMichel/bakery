{{--<form action="#">
    {{ csrf_field() }}
    <div class="form-group">

        {!! Form::label('category_id', 'Category:') !!}<br>
        {!! Form::select('category_id',  $cat_list, $cat_id , []) !!}

    </div>--}}
<h4 class="update-message green-background"></h4>
    <div class="form-group">
        {!! Form::label('item', 'Item Name:') !!}<br>
        {!! Form::select('item_id',  $item_list, null, ['placeholder'=> 'Choose item:', 'class' => 'change-item']) !!}
    </div>

    <div class="image-target"></div>

    <div class="form-group submit-special">
        <input type="button" class="btn btn-primary pull-right update-special-frm" value="Add Special">
    </div>

{{--</form>--}}

<script>
    /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/

    $('.submit-special').hide();


    $('.change-item').on('change', function (e) {
        e.preventDefault();
        const item_id =  $('select[name=item_id]').val();

        const url = 'item_selected/' + item_id;

        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
                $('.image-target').html(data);
                $('.submit-special').show();
            },
            error  : function (data) {
                console.log('something went wrong.');
            }
        });
    });

    $('.update-special-frm').on('click', function (e) {
        e.preventDefault();
        const item_id = $('select[name=item_id]').val();

        const url = 'update_item/' + item_id;
        console.log('home item. ID: ' + item_id);
        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
                $(".update-message").html('Special of the day has been updated.').show('slow').delay(5000).fadeOut();
                $('.submit-special').hide();
            },
            error  : function (data) {
                console.log('something went wrong.');
            }
        });
    })
</script>