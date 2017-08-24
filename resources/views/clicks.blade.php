@extends('user')


@section('panel')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-left" style="margin-top: 3px">
                <a href="#">
                    <img class="media-object img-circle" src="http://freevector.co/wp-content/uploads/2014/09/34267-pay-per-click-optimization-symbol-in-a-circle-200x200.png" width="45px" height="45px" style="margin-right:8px; margin-top:-5px;">
                </a>
            </div>
            <form method="GET" action="{{url('/stats')}}" style="margin-top: 5px">
                <span style="width: 500px"> <a href="#" style="text-decoration:none;"> <strong style="font-size: 21px; margin-top: 20px">Click Trackers</strong></a></span>
                    <span class="pull-right">
                        <input name="type" value="1" hidden>
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
                            Tracker ID : {{$tracker->id}}
                            <span class="pull-right" style="margin-right: 20px"><a href='#'> {{$tracker->total_clicks}}</a></span><span class="pull-right" style="margin-right: 10px">Total Clicks :</span>
                            <span class="pull-right" style="margin-right: 50px"><a href='#'> {{$tracker->unique_clicks}}</a></span><span class="pull-right" style="margin-right: 10px">Unique Clicks :</span>
                            <span class="pull-right" style="margin-right: 50px"><a href='#'> {{$tracker->Latest_click}}</a></span><span class="pull-right" style="margin-right: 10px">Latest Clicks :</span>

                            {{--<a class="pull-right" style="margin-right: 50px" href='#'>Unique Clicks : {{$tracker->unique_clicks}}</a>--}}
                            {{--<a class="pull-right" style="margin-right: 80px" href='#'>Latest Clicks : {{$tracker->Latest_click}}</a>--}}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection


