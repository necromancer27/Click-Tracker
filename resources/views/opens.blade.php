@extends('user')


@section('panel')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-left">
                    <img class="media-object img-circle" src="https://d3ds6z1w6yhmzj.cloudfront.net/img/2017/icon-eye.svg" width="45px" height="45px" style="margin-right:8px;">
            </div>
            <form method="GET" action="{{url('/stats')}}" style="margin-top: 5px">
                <span style="width: 500px"> <strong style="font-size: 21px; margin-top: 20px">Open Trackers</strong></span>
                <span class="pull-right">
                        <input name="type" value="0" hidden>
                        <label style="margin-right: 10px">From </label>   <input name="from" style="margin-right: 20px; width: 180px" placeholder="YYYY-MM-DD hh:mm:ss" >
                        <label style="margin-right: 10px">To </label>   <input name="to" style="margin-right: 20px; width: 180px" placeholder="YYYY-MM-DD hh:mm:ss">
                        <button type="submit" class="btn btn-primary" style="margin-right: 20px">Show</button>
                    </span>

            </form>

            <hr>
            <div class="post-content">
                <ul class="list-group" style="height: 345px; overflow: hidden; overflow-y: scroll;">
                    @foreach($trackers as $tracker)
                        <li class="list-group-item">
                            Tracker ID : {{$tracker->t_id}}
                            <span class="pull-right" style="margin-right: 20px" >{{$tracker->total}}</span><span class="pull-right" style="margin-right: 10px">Total Opens :</span>
                            <span class="pull-right" style="margin-right: 50px">{{$tracker->unique}}</span><span class="pull-right" style="margin-right: 10px">Unique Opens :</span>
                            {{--<span class="pull-right" style="margin-right: 50px">{{$tracker->Latest_open}}</span><span class="pull-right" style="margin-right: 10px">Latest Open :</span>--}}

                            {{--<a class="pull-right" style="margin-right: 50px" href='#'>Unique Clicks : {{$tracker->unique_clicks}}</a>--}}
                            {{--<a class="pull-right" style="margin-right: 80px" href='#'>Latest Clicks : {{$tracker->Latest_click}}</a>--}}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <hr>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-left">
                <a href="#">
                    <img class="media-object img-circle" src="https://www.justin.my/wp-content/uploads/2013/09/how-to-clear-browser-cache.jpg" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                </a>
            </div>
            <h4><strong>Browser Stats</strong></h4>
            <hr>
            <div class="post-content">
                <ul class="list-group">
                    @foreach($browsers as $key=>$value)
                        <li class="list-group-item">

                            {{$value->name}}<span class="pull-right" style="margin-right: 10px">Total Opens : {{$value->count}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <hr>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-left">
                <a href="#">
                    <img class="media-object img-circle" src="https://image.freepik.com/free-icon/cogwheels-laptop-wallpaper_318-39520.jpg" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                </a>
            </div>
            <h4><strong>OS Stats</strong></h4>
            <hr>
            <div class="post-content">
                <ul class="list-group">
                    @foreach($os as $key=>$value)
                        <li class="list-group-item">
                            {{$value->name}}<span class="pull-right" style="margin-right: 10px">Total Opens : {{$value->count}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection

