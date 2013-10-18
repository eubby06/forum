@section('content')
<div class="container">

    <ul class="nav nav-tabs">
        <li>
        <a href="{{ route('settings') }}">Settings</a>
        </li>
        <li><a href="{{ route('password_settings') }}">Change Password or Email</a></li>
        <li class="active"><a href="{{ route('notifications') }}">Notifications</a></li>
    </ul>

    <p>
        <a class="btn">Delete Selected</a>
        <a class="btn">Hide Selected</a>
    </p>

    <table class="table table-striped">
        <tbody>
            <tr>
                <td width="5%">{{ Form::checkbox('remove') }}</td>
                <td width="75%">Your current password</td>
                <td width="10%"><i class="icon-remove"></i> <a href="#">remove</a></td>
                <td width="10%"><i class="icon-eye-close"></i> <a href="#">hide</a></td>
            </tr>
            <tr>
                <td width="5%">{{ Form::checkbox('remove') }}</td>
                <td width="75%">Your current password</td>
                <td width="10%"><i class="icon-remove"></i> <a href="#">remove</a></td>
                <td width="10%"><i class="icon-eye-close"></i> <a href="#">hide</a></td>
            </tr>
        </tbody>
    </table>

</div> <!-- /container -->
@stop