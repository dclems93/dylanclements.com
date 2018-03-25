<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}"/>
    <script src="{{ URL::to('src/js/jquery.flexslider.js') }}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="page">
			<span class="menu_toggle">
		    <i class="menu_open fa fa-bars fa-lg"></i>
		    <i class="menu_close fa fa-times fa-lg"></i>
		  </span>
    <ul class="menu_items">
        <li><a href="#" onClick="pushLink('/')"><i class="icon fa fa-home fa-3x"></i> Home</a></li>
        <li><a href="#" onClick="pushLink('blog')"><i class="icon fa fa-code fa-3x"></i> Blog</a></li>
        <li><a href="#" onClick="pushLink('projects')"><i class="icon fa fa-coffee fa-3x"></i> Projects</a></li>
    </ul>
    <div id="navbar">
        @if(Auth::user())
            <a href="{{ route('logout') }}">Logout</a>
            @if(!Request::is('projects'))
                <a href="#" onclick="document.getElementById('newpostmodal').style.display='block'">New Post</a>
            @else
                <a href="#" onclick="document.getElementById('newprojectmodal').style.display='block'">New Project</a>
            @endif
        @else
            <a href="#" onclick="document.getElementById('loginmodal').style.display='block'">Login</a>
        @endif
        <a href="#contact">Contact</a>
    </div>
    <main class="content">
        <div class="content_inner invisible_scroll" id="content_inner">
            @yield('content')
            <script src="{{ URL::to('src/js/app.js') }}"></script>
        </div>
    </main>
</div>

@include('include.login-modal')
@if(Auth::user())
    @include('include.new-post-modal')
@endif

<script type="text/javascript" charset="utf-8">
    $(window).load(function() {
        $('.flexslider').flexslider({
            controlNav: false,
            directionNav: false,
            keyboard: false,
            slideshowSpeed: 18000,
            animation: "fade",
            animationSpeed: 1,
            animationLoop: false
        });
    });

    var token='{{ Session::token() }}';
    var urlEdit='{{ route('edit') }}';
    var urlLike='{{ route('like') }}';


</script>
</body>
</html>