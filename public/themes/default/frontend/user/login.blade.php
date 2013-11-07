@section('content')
<div class="container">

      {{ Form::open(array('route' => 'post_login', 'class' => 'form-signin span6')) }}
        <fieldset><legend><h2 class="form-signin-heading">Log In</h2></legend>

        <input type="text" name="username" class="input-block-level" placeholder="Username or Email">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
        <label class="checkbox"><input type="checkbox" name="remember_me" value="1"> Remember me</label>

        <hr />
        <span class="muted">  Don't have an account? <a href="#">Sign Up!</a></span>
        <button class="btn btn-large pull-right" type="submit">Log In</button>
        </fieldset>
      {{ Form::close() }}

</div> <!-- /container -->
@stop