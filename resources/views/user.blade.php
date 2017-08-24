@extends('layouts.app')

@section('content')
    <div class="mainbody container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div align="center">
                                <img class="thumbnail img-responsive" src="https://lut.im/7JCpw12uUT/mY0Mb78SvSIcjvkf.png" width="300px" height="300px">
                            </div>
                            <div class="media-body" onload="topclick()">
                                <hr>
                                <h3><strong>Secret Token</strong></h3>

                                <p id='s_token' data-token="{{Auth::user()->token}}" onmouseover="secretOpen()" onmouseleave="secretClose()">XXXXXXXXXX</p>
                                <hr>
                                <h3><strong>Top Click Tracker</strong></h3>
                                <p id='top_click'>top click</p>
                                <hr>
                                <h3><strong>Top click rate</strong></h3>
                                <p id="top_percent">Some Percentage</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <span>
                            <h1 class="panel-title pull-left" style="font-size:30px;">{{ Auth::user()->name }} <small>{{Auth::user()->email}}</small></h1>
                            <form  class="pull-right" method="post" action="{{url('/tracker')}}">
                                {{csrf_field()}}
                                <input value="{{Auth::user()->token}}" name="token" hidden >
                                <button class="btn btn-success pull-right" type="submit">
                                        Generate Tracker
                                </button>
                            </form>
                        </span>

                        <br><br><hr>
                        <span class="pull-left">
                            <a href="{{url('/home')}}" class="btn btn-link" style="text-decoration:none;"> Trackers </a>
                            <a href="{{url('/stats?type=0')}}" class="btn btn-link" style="text-decoration:none;"> Opens </a>
                            <a href="{{url('/stats?type=1')}}" class="btn btn-link" style="text-decoration:none;"> Clicks </a>
                        </span>
                    </div>
                </div>
                <hr>
                @yield('panel')
            </div>
        </div>
    </div>
@endsection