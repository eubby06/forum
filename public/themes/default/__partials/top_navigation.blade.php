<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="{{ route('home') }}">{{ Eubby\Models\Settings::find(1)->title }}</a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              @if (Provider::getAcl()->isGuest())
                  <li><a href="{{ route('join') }}"><i class="icon-cog icon-white"></i>  Sign Up</a></li>
                  <li><a href="{{ route('login') }}"><i class="icon-off icon-white"></i> Log In</a></li>
                  <li><a href="{{ route('start_conversation') }}"><i class="icon-fire icon-white"></i> Start New Conversation</a></li>
              @else
                  <li><a href="{{ route('members_profile', Acl::getUser()->username) }}">
                    {{ Provider::getAcl()->getGravatar(array('img' => true, 's' => 20)) }}
                    <strong>{{ Acl::getUser()->username }}</strong></a></li>
                  <li><a href="{{ route('settings') }}"><i class="icon-cog icon-white"></i>  Settings</a></li>
                  @if (Provider::getAcl()->isAdmin())
                  <li><a href="{{ route('admin_dashboard') }}"><i class="icon-lock icon-white"></i>  Administration</a></li>
                  @endif
                  <li><a href="{{ route('logout') }}"><i class="icon-off icon-white"></i> Logout</a></li>
                  <li><a href="{{ route('start_conversation') }}"><i class="icon-fire icon-white"></i> Start New Conversation</a></li>
              @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
</div>