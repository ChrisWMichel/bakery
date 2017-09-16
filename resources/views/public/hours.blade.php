<div class="main">
    <div class="wrap">
        <h2 class="page-header">Hours</h2>

        <h4 class="update-home-message green-background"></h4>
        <div class="col-lg-offset-3 col-lg-6">
            <table class="table table-bordered ">

                <tbody>
                @foreach($hours as $hour)
                    <tr>
                        <td>{{$hour->day}}</td>
                        <td>{{$hour->open}}</td>
                        <td>{{$hour->close}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h4 class="update-message green-background"></h4>
            <div class="form-group">
                {{$message->hours_page}}
            </div>


        </div>
    </div>
</div>
