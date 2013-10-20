@section('content')
<div class="container">

    <ul class="nav nav-tabs">
        <li>
        <a href="{{ route('settings') }}">Settings</a>
        </li>
        <li class="active"><a href="{{ route('password_settings') }}">Change Password or Email</a></li>
        <li><a href="{{ route('notifications') }}">Notifications</a></li>
    </ul>

    {{ Form::open(array('route' => 'post_password_settings')) }}
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>Your current password</td>
                <td> {{ Form::password('current_password', '', array('class' => 'span8')) }} </td>
            </tr>
            <tr>
                <td>New password</td>
                <td> {{ Form::password('password', '', array('class' => 'span8', 'placeholder')) }} </td>
            </tr>
            <tr>
                <td>Confirm new password</td>
                <td> {{ Form::password('password_confirmation', '', array('class' => 'span8')) }} </td>
            </tr>
            <tr>
                <td>New email <small class="muted">(optional)</small></td>
                <td> {{ Form::text('email', '', array('class' => 'span8', 'placeholder' => 'Enter you new email here...')) }} </td>
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