@section('content')
<div class="container">

      <form class="form-signin span6" action="{{ route('post_join') }}" method="post">
            <fieldset><legend><h2 class="form-signin-heading">Sign Up</h2></legend>
            <input type="text" name="username" value="{{ Input::old('username') }}" class="input-block-level" placeholder="Username">

            <span class="muted">Used to verify your account and subscribe to conversations</span>
            <input type="text" name="email" value="{{ Input::old('email') }}" class="input-block-level" placeholder="Email address">

            <span class="muted">Choose a secure password of at least 6 characters</span>
            <input type="password" name="password" class="input-block-level" placeholder="Password">
            <input type="password" name="password_confirmation" class="input-block-level" placeholder="Confirm Password">

            <hr />
            <span class="muted"> Already have an account? <a href="#">Log in!</a></span>
            <button class="btn btn-large pull-right" type="submit">Sign in</button>
            </fieldset>
      </form>

</div> <!-- /container -->
@stop