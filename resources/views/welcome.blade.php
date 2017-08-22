<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/login.css">
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <script src="/js/modernizr-2.8.3.min.js"></script>
</head>
<body style="background-size: 100% 270%">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
<div class="form">

    <ul class="tab-group">
        <li class="tab"><a href="#signup">Sign Up</a></li>
        <li class="tab active"><a href="#login">Login</a></li>
    </ul>

    <div class="tab-content">

        <div id="login">
            <h1>Welcome Back!</h1>

            <form action="http://opentracker.dev/login" method="post">
                {{ csrf_field() }}
                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email" name="email"required autocomplete="off"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Password<span class="req">*</span>
                    </label>
                    <input type="password" name="password"required autocomplete="off"/>
                </div>

                {{--@if( $_SESSION['valid_user'] != 1 )--}}
                    {{--<h3 style="color: red">Invalid username or password!!</h3>--}}
                {{--@endif--}}

                <!--<p class="forgot"><a href="#">Forgot Password?</a></p>-->

                <button class="button button-block" name="sub"/>Log In</button>

            </form>

        </div>

        <div id="signup">
            <h1>Sign Up</h1>

            <form action="http://opentracker.dev/signup" method="post">
                {{csrf_field()}}
                <div class="top-row">
                    <div class="field-wrap">
                        <label>
                            First Name<span class="req">*</span>
                        </label>
                        <input type="text" name="fname"  autocomplete="off" required />
                    </div>

                    <div class="field-wrap">
                        <label>
                            Last Name<span class="req">*</span>
                        </label>
                        <input type="text" name="lname"  autocomplete="off" required />
                    </div>
                </div>

                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email" name="email" required autocomplete="off"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Set A Password<span class="req">*</span>
                    </label>
                    <input type="password" name="password"required autocomplete="off"/>
                </div>


                <button type="submit" class="button button-block"/>Get Started</button>

            </form>

        </div>

    </div><!-- tab-content -->

</div>

<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery-1.12.0.min.js"><\/script>')</script>
<script src="/js/plugins.js"></script>
{{--<script src="js/main.js"></script>--}}
<script src="/js/login.js"></script>

</body>
</html>
