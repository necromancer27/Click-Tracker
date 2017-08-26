@extends('user')


@section('panel')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-left">
                    <img class="media-object img-circle" src="https://quester.io/wp-content/themes/Quester/images/LiveTrack_icon.svg" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
            </div>
            <h4><strong>Tracker Links</strong> – <small><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{count($trackers)}}</i></small></h4>
            <hr>
            <div class="post-content">
                <ul class="list-group" style="height: 345px; overflow: hidden; overflow-y: scroll;">
                    @foreach($trackers as $tracker)
                        {{--<li class="list-group-item"> {{$tracker}} <a class="pull-right" style="margin-right: 20px" href='open/{{$tracker}}'>open</a> <a class="pull-right" style="margin-right: 50px" href='click/{{$tracker}}'>click</a></li>--}}
                        <li class="list-group-item">
                            Tracker ID : {{$tracker}}
                            <span id='o_link' class="pull-right" data-track='{{$tracker}}' style="margin-right: 20px" onclick="openLink({{$tracker}})"><a href="#"> Open Link</a></span>
                            <span id='c_link' class="pull-right" data-track='{{$tracker}}' style="margin-right: 50px" onclick="clickLink({{$tracker}})"><a href="#"> Click Link</a></span>
                            {{--<a class="pull-right" style="margin-right: 50px" href='click/{{$tracker}}'>click</a>--}}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openLink(track) {
           window.prompt("Copy to clipboard: Ctrl+C, Enter","http://opentracker.dev/open/"+track);
        }

        function clickLink(track) {
            window.prompt("Copy to clipboard: Ctrl+C, Enter","http://opentracker.dev/click/"+track);
        }
    </script>
@endsection




