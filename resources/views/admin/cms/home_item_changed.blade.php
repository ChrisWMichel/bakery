<h4 class="update-message green-background"></h4>
<div class="form-group">
    {!! Form::label('item', 'Item Name:') !!}<br>
    {!! Form::select('itemID',  $item_list, $item_id, ['placeholder'=> 'Choose item:', 'class' => 'change-item']) !!}
</div>

<div class="form-group image-backend">
    <div class="grid_img" id="image-special">
        <img src="{{asset($path)}}" alt=""  id="image-target"/>
    </div>
</div>
<div class="image-target"></div>

<div class="form-group submit-special">
    <input type="button" class="btn btn-primary pull-right add-special-frm" value="Update Special">
</div>


<script>
    /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/

    //$('.submit-special').hide();


    $('.change-item').on('change', function (e) {
        e.preventDefault();
        const item_id =  $('select[name=itemID]').val();

        const url = 'item_selected/' + item_id;

        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
                $('.image-backend').hide();
                $('.image-target').html(data);
                $('.submit-special').show();
            },
            error  : function (data) {
                console.log('something went wrong.');
            }
        });
    });

    $('.add-special-frm').on('click', function (e) {
        e.preventDefault();
        const item_id = $('select[name=itemID]').val();

        const url = 'update_item/' + item_id;
        console.log('item changed. ID: ' + item_id);
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
