<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="{{ route('home') }}">Flash eSports Forum</a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              @if (Auth::guest())
                  <li><a href="{{ route('join') }}"><i class="icon-cog icon-white"></i>  Sign Up</a></li>
                  <li><a href="{{ route('login') }}"><i class="icon-off icon-white"></i> Log In</a></li>
                  <li><a href="{{ route('start_conversation') }}"><i class="icon-fire icon-white"></i> Start New Conversation</a></li>
              @else
                  <li><a href="{{ route('members_profile', Auth::user()->username) }}">
                    {{ Auth::user()->getGravatar(array('img' => true, 's' => 20)) }}
                    <strong>{{ Auth::user()->username }}</strong></a></li>
                  <li><a href="{{ route('settings') }}"><i class="icon-cog icon-white"></i>  Settings</a></li>
                  <li><a href="{{ route('admin_dashboard') }}"><i class="icon-lock icon-white"></i>  Administration</a></li>
                  <li><a href="{{ route('logout') }}"><i class="icon-off icon-white"></i> Logout</a></li>
                  <li><a href="{{ route('start_conversation') }}"><i class="icon-fire icon-white"></i> Start New Conversation</a></li>
              @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
</div>