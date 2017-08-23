@extends('user')


@section('panel')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-left">
                <a href="#">
                    <img class="media-object img-circle" src="https://quester.io/wp-content/themes/Quester/images/LiveTrack_icon.svg" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                </a>
            </div>
            <h4><a href="#" style="text-decoration:none;"><strong>Tracker Links</strong></a> – <small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{count($trackers)}}</i></a></small></h4>
            <hr>
            <div class="post-content">
                <ul class="list-group">
                    @foreach($trackers as $tracker)
                        <li class="list-group-item"> http://opentracker/{{$tracker}} <a class="pull-right" style="margin-right: 20px" href='open/{{$tracker}}'>open</a> <a class="pull-right" style="margin-right: 50px" href='click/{{$tracker}}'>click</a></li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection




