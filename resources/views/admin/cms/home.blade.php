@extends('layouts.admin_layout')

@section('content')
    @include('includes.tinyeditor')
    <h2 class="page-header">Home Page</h2>

    {{--<div class="row">--}}
        <div class="col-lg-7">
            <div class="form-group">
            <textarea name="description" class="form-control" id="home-body" required rows="8" cols="8">{!! $home->body !!}</textarea>
            </div>

            <div class="form-group">
                <input type="button" class="btn btn-primary pull-right update-home-frm" id="update-home" value="Update">
                {{--<button class="btn btn-primary pull-right update-home-frm" id="update-home">Update</button>--}}
            </div>
            <h4 class="update-home-message green-background"></h4>
        </div>
        <div class="col-lg-5">
            <h3>Special of the day</h3>

                <form action="#">
                {{ csrf_field() }}
                <div class="form-group">

                    {!! Form::label('category_id', 'Category:') !!}<br>
                    {!! Form::select('category_id',  $cat_list, $item->category_id , ['class' => 'change-cat']) !!}

                    </div>
                    <div class="home-items">
                        <div class="item-changed">
                            <div class="form-group">
                                {!! Form::label('item', 'Item name:') !!}<br>
                                {!! Form::select('item_id',  $item_list, $item->id, ['class' => 'change-item']) !!}
                            </div>
                            <div class="form-group">

                                @if(!empty($path))
                                    <div class="grid_img">
                                        <img src="{{asset($path)}}" alt="" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
       {{-- </div>--}}


@endsection

@section('scripts')
    <script src="{{asset('js/admin_items.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.change-cat', function (e) {
                e.preventDefault();
                const cat_id = $('select[name=category_id]').val();

                const url = 'home_items/' + cat_id;

                $.ajax({
                    url    : url,
                    type   : 'get',
                    success: function (data) {
                        $('.home-items').html(data);
                    },
                    error  : function (data) {
                        console.log('something went wrong retrieving category.');
                    }
                })
            });

            $(document).on('change', '.change-item', function (e) {
                e.preventDefault();
                const item_id = $('select[name=item_id]').val();

                const url = 'home_item_changed/' + item_id;

                $.ajax({
                    url    : url,
                    type   : 'get',
                    success: function (data) {
                        $('.item-changed').html(data);
                        $('.submit-special').show();
                    },
                    error  : function (data) {
                        console.log('something went wrong retrieving item.');
                    }
                });
            });

            $(document).on('click', '.update-home-frm', function (e) {
                e.preventDefault();
                tinyMCE.triggerSave();
                const data = {'body': $('#home-body').val()};

                console.log('update-home-frm');
                const url = 'update_home_body';
                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        $(".update-home-message").html('Home page has been updated.').show('slow').delay(5000).fadeOut();
                    },
                    error  : function (data) {
                        console.log('something went wrong retrieving item.');
                    }
                });
            })
        })
    </script>

@endsection