@section('content')
<div class="container">

    <ul class="nav nav-tabs">
        <li class="active">
        <a href="#">Settings</a>
        </li>
        <li><a href="{{ route('password_settings') }}">Change Password or Email</a></li>
        <li><a href="{{ route('notifications') }}">Notifications</a></li>
    </ul>

    {{ Form::open(array('route' => 'post_settings')) }}
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>Avatar</td>
                <td>Change your avatar on <a href="#">Gravatar.com</a>. </td>
            </tr>
            <tr>
                <td>Notifications</td>
                <td>
                    <ul class="unstyled">
                        
                        @foreach ($select_notifications as $key => $text)
                            @if (in_array($key, $user_notifications))
                            <li>
                                <label class="checkbox">{{ Form::checkbox('notification[]', $key, true) }} {{ $text }}</label>
                            <li>
                            @else
                            <li>
                                <label class="checkbox">{{ Form::checkbox('notification[]', $key) }} {{ $text }}</label>
                            <li>
                            @endif
                        @endforeach
                    </ul>
                </td>
            </tr>
                        <tr>
                <td>Privacy</td>
                <td>Don't allow other users to see when I am online</td>
            </tr>
                        <tr>
                <td>Location</td>
                <td> {{ Form::text('location', $profile->location, array('class' => 'span8', 'placeholder' => 'Enter your location here...')) }} </td>
            </tr>
            <tr>
                <td>About</td>
                <td>
                    {{ Form::textarea('about', $profile->about, array('class' => 'span8', 'placeholder' => 'Tell a little about yourself...')) }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><button class="btn btn-medium" type="submit">Save Changes</button>
                <button class="btn btn-medium" type="reset">Cancel</button></td>
            </tr>
        </tbody>
    </table>
    {{ Form::close() }}
</div> <!-- /container -->
@stop