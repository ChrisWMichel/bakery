
@foreach($items as $item)

    <div class="panel-body tan-background" id="panel-{{$item->id}}">

        <div class="form-group">
            <div class="error text-center alert-danger hidden">
                <ul></ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <h5 class="show-msg blue-font"></h5>
                <?php $isChecked = $item->show == 1 ? 'checked="checked"' : null; ?>
                <input type="checkbox" class="show-item" id="{{$item->id}}" {{$isChecked}} name="show_item"><span style="font-weight: bold">Show</span>
            </div>
            <div class="col-sm-7">
                <a href="#" class="btn btn-danger btn-sm pull-right delete-Cakeitem" id="{{$item->id}}">X</a>
            </div>
        </div>

        <h3 class="blue-font" id="frm-msg-{{$item->id}}" ></h3>
        {!! Form::open(['method'=>'POST','action'=> ['CakeItemController@update', $item->id], 'id' => 'item-form', 'novalidate' => 'novalidate']) !!}
        {{ csrf_field() }}

        <div class="form-group">
            {!! Form::label('item', 'Item Name:') !!}
            <input type="text" value="{{$item->item}}" class="form-control" id="item-{{$item->id}}" name="item" required>
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}<br>
            <textarea name="description" class="form-control" id="desc-{{$item->id}}" required rows="8" cols="8">{{$item->description}}</textarea>

        </div>
        <div class="form-group">
            {!! Form::label('price', 'Price:') !!}
            <input type="text" value="{{$item->price}}" name="price" id="price-{{$item->id}}">
            {!! Form::label('volume', 'Unit:') !!}
            <input type="text" value="{{$item->volume}}" name="volume" id="volume-{{$item->id}}">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary pull-right update-cakeItem-frm" id="{{$item->id}}">
        </div>


        {!! Form::close() !!}

    </div>
    <br>
    <hr>
    <br>
@endforeach
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.show-item').on('change', function (e) {
        e.preventDefault();
        const id = $(this).attr('id');

        const url = 'cake_items/' + id + '/edit';
        $.ajax({
            url    : url,
            type   : 'get',
            success: function (data) {
                $('.show-msg').html('updated');
                setTimeout(function () {
                    $('.show-msg').hide();
                }, 5000);
            },
            error  : function (data) {
                console.log('show checkbox was not updated.');
            }
        })
    });

    /* Update item form */
    $('.update-cakeItem-frm').on('click', function (e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        const id = $(this).attr('id');
        const data = {
            'id'        : $(this).attr('id'),
            'item'       : $('#item-' + id).val(),
            'description': $('#desc-' + id).val(),
            'price'      : $('#price-' + id).val(),
            'volume'     : $('#volume-' + id).val(),
        };

        console.log(data);
        const url = 'update_cake_item';
        $.ajax({
            url    : url,
            type   : 'post',
            data   : data,
            success: function (data) {
                $("#frm-msg-" + id).html('Item has been updated successfully.').show('slow').delay(5000).fadeOut();
            },
            error  : function (data) {
                let response = JSON.parse(data.responseText);
                ErrorMsg(response, id);
            }

        });
        function ErrorMsg (msg, id) {
            $(".error" + id).find("ul").html('');
            $('.error' + id).removeClass('hidden');
            $.each( msg, function( key, value ) {
                $(".error" + id).find("ul").append('<li>'+value+'</li>');
            });
        }
    });

    $('.delete-Cakeitem').on('click', function (e) {
        e.preventDefault();
        const id = $(this).attr('id');

        const url = 'delete_cake_item/' + id;
        console.log('delete_cake_item/' + id)

        $.ajax({
            url : url,
            type: 'get',
            success: function (data) {

                $('#panel-' + id).fadeOut();
            },
            error  : function (data) {
                console.log('Cake item was not deleted.');
            }
        });

    })
</script>