<header>
<nav class="navbar navbar-default navbar-fixed-top bg-faded">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('welcome') }}">Dylan Clements</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    @if(!Auth::check())
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
      <li class="dropdown" id="menuLogin">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Login</a>
            <div class="dropdown-menu" style="padding:17px;">
              <form class="form" id="formLogin"> 
                <input name="username" id="username" type="text" placeholder="Username"> 
                <input name="password" id="password" type="password" placeholder="Password"><br>
                <button type="button" id="btnLogin" class="btn">Login</button>
              </form>
              or
            </div>
          </li>
      </ul>
    </div>

    @else
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::guard('web')->user()->hasRole('admin'))
        <li><a href="{{ route('admin') }}">Admin</a></li>
        @endif
        <li><a href="{{ route('forum') }}">Forum</a></li>
        <li><a href="{{ route('account') }}">Account</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
      </ul>
    </div>
    @endif<!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

</header>