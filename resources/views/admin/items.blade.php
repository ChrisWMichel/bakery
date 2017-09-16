@extends('layouts.admin_layout')

@section('content')
    @include('includes.tinyeditor')
    <h3>Add/Edit <a href="#" id="view-cat"> Categories</a></h3>
<div class="col-sm-5 col-md-offset-2">
    <div class="display-category">
            <table id="categoryTbl" class="table-striped table-bordered table-hover">
                <tr>
                    <th>Name</th>
                </tr>
                @foreach($categories as $category)
                    <tr>
                        <td><input type="text" value="{{$category->name}}" name="{{$category->id}}" id="{{$category->id}}" disabled></td>
                        <td align='center'><input type="button" id="{{$category->id}}"  value="Edit" class="btn btn-sm btn-primary editBtn"></td>
                        @if($category->show_cat == 1)
                            <td align='center'><input type="button" id="{{$category->id}}"  value="Showing" class="btn btn-sm btn-success hideBtn visible"></td>
                        @else
                            <td align='center'><input type="button" id="{{$category->id}}"  value="Hidden" class="btn btn-sm btn-warning showBtn visible"></td>
                        @endif

                    </tr>
                @endforeach
                <tr>
                    <form action="#">
                        {{ csrf_field() }}
                        <td>
                            {!! Form::text('name', null, ['required' => 'required']) !!}
                        </td>
                       <td>
                        &nbsp;<input type="button" class="btn btn-primary btn-sm" id="empty-cat" value="Add Category">
                       </td>
                    </form>
                </tr>
            </table>
    </div>
</div>
    <br><br>
<div class="hide-page">
    <div class="panel panel-default add-item-panel">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="#" id="show-add-items">Add Item</a> </h3>
        </div>
        <div class="hide-add-item">
            <div class="panel-body">
                <h3 class="form-message green-background">Item has been added successfully.</h3>

                <div class="form-group">
                    <div class="error text-center alert-danger hidden">
                        <ul></ul>
                    </div>
                </div>
                {!! Form::open(['method'=>'POST', 'action'=>'ItemController@store', 'id' => 'item-form', 'novalidate' => 'novalidate']) !!}
                    {{ csrf_field() }}
                    <div class="form-group">

                        {!! Form::label('category_id', 'Category:') !!}<br>
                        {!! Form::select('category_id',  $cat_list, null, ['placeholder'=> 'Pick Category:']) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('item', 'Item Name:') !!}
                        {!! Form::text('item', null, ['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <p>Recommended: to maintain uniformity when items are displayed; make <span class="yellowbkg">image size H.171 X W.228</span></p>
                    <div class="form-group">
                        {!! Form::label('description', 'Description:') !!}<br>
                        {!! Form::textarea('description', NULL, ['class' => 'form-control', 'id' => 'item-desc', 'rows' => 8, 'required' => 'required']) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('price', 'Price:') !!}
                        {!! Form::text('price', NULL, ['required' => 'required']) !!}
                        {!! Form::label('volume', 'Unit:') !!}
                        {!! Form::text('volume', NULL, ['required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Add Item', ['class' => 'btn btn-primary pull-right add-item-frm']) !!}
                    </div>
                {!! Form::close() !!}


            </div>
        </div>
    </div>
    @include('includes.validate_form')
    <br><br>
    <div class="menu nav">
        <ul>
            @foreach($categories as $category)
                @if($category->show_cat == 1)
                    <li class="pages" id="{{$category->id}}"><a href="#">{{$category->name}}</a></li>
                @endif
            @endforeach
                <div class="clear"></div>
        </ul>

    </div>

    <div class="display-items">

    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/admin_items.js')}}"></script>
    <script>
        //$(window).resize(toggleMenu);

        $('#empty-cat').on('click', function(){
            const data = {
                'name' : $('input[name=name]').val()
            };
            const url = '{{route("category.store")}}';
            $.ajax({
                url    : url,
                type   : 'post',
                data   : data,
                success: function (data) {
                    $('#categoryTbl').append("<tr><td>"+ data.name +"</td><td align='center'><a href='#' id='"+ data.id +"' class='btn btn-sm btn-danger deleteBtn' onclick='deleteCat(this)'>X</a> </td></tr>");
                    $('input[name=name]').val('');
                },
                error  : function (data) {
                    console.log('Category was not added.');
                    console.log(data);
                }
            })
        });

        $('.editBtn').on('click', function (e) {
            e.preventDefault();
            if($(this).val() === 'Edit'){
                const id = $(this).attr('id');
                $('#' + id).prop("disabled", false);

                $(this).val('Save').removeClass('btn-primary').addClass('btn-warning');
            }else{
                let id = $(this).attr('id');
                const category = $('input[name=' + id + ']').val();
                $(this).val('Edit').removeClass('btn-warning').addClass('btn-primary');
                const data = {
                    id : id,
                    name : category
                };
                const url = 'update_cat/' + id;
                $.ajax({
                    url    : url,
                    type   : 'get',
                    data   : data,
                    success: function (data) {
                        $('input[name=' + id + ']').val(data.name);
                        $('#' + id).prop("disabled", true);
                    },
                    error  : function (data) {
                        console.log('Category was not updated.');
                        console.log(data);
                    }
                })
            }
        });

        function deleteCat(el) {
            const id = el.id;
            const url = 'delete_cat/' + id;
            $.ajax({
                url    : url,
                type   : 'get',
                success: function (data) {
                    const tr = el.closest('tr');
                    $(tr).css("background-color", "#FF3700");
                    $(tr).fadeOut(400, function () {
                        $(tr ).remove();
                    });
                    return false;
                },
                error  : function (data) {
                   console.log('category did not get deleted.');
                }
            })
        }

        $('.visible').on('click', function () {
            const id = $(this).attr('id');

            if($(this).hasClass('showBtn')){
                $(this).val('Showing').removeClass('hideBtn btn-warning').addClass('showBtn btn-success');
            }else{
                $(this).val('Hidden').removeClass('showBtn btn-success').addClass('hideBtn btn-warning');
            }
            const url = 'hide_cat/' + id;

            $.ajax({
                url    : url,
                type   : 'get',
                success: function (data) {
                    //console.log(data)
                },
                error  : function (data) {
                    console.log('something went wrong.');
                }
            })
        });

        /* Add Item Form */
        //$('.add-item-frm').on('click', function (e) {
        $('.add-item-frm').on('click', function (e) {
            e.preventDefault();

            $(".error").find("ul").html('');
            tinyMCE.triggerSave();
            const data = {
                'category_id' : $('select[name=category_id]').val(),
                'item'        : $('input[name=item]').val(),
                'description' : $('#item-desc').val(),
                'price'       : $('input[name=price]').val(),
                'volume'      : $('input[name=volume]').val(),
            };

            const url = '{{route("items.store")}}';
            $.ajax({
                url : url,
                type : 'post',
                data: data,
                success : function (data) {
                    $(".form-message").show('slow').delay(5000).fadeOut();
                   document.getElementById('item-form').reset();
                },
                error  : function (data) {
                    let response = JSON.parse(data.responseText);
                    printErrorMsg(response);
                    data.responseText = [];
                }
            });
        });

        $(document).on('click', '.pages', function (e) {
            e.preventDefault();
            const id = $(this).attr('id');
            $(this).parents('.nav').find('.active').removeClass('active').end().end().addClass('active');
            $('#show-add-items').hide();
            tinymce.remove();
            const url = "items/" + id;
            $.ajax({
                url : url,
                type    : 'get',
                success : function (data) {

                    $('.display-items').html(data);
                    tinymce.init(editor_config);//  tinymce_config
                },
                error   : function () {
                    console.log('problem with loading page.');
                }
            });
        })

    </script>

@endsection