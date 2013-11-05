@section('content')
<div class="container">

    <ul class="nav nav-tabs">
        <li>
        <a href="{{ route('settings') }}">Settings</a>
        </li>
        <li><a href="{{ route('password_settings') }}">Change Password or Email</a></li>
        <li class="active"><a href="{{ route('notifications') }}">Notifications</a></li>
    </ul>

    <table class="table table-striped">
        <tbody>

            @foreach ($notifications as $notification)
            <tr>
                <td width="70%"><strong>{{ $notification->user->username }}</strong> {{ $notification->message }}</td>
                <td width="10%"><i class="icon-search"></i> <a href="{{ route('view_conversation', $notification->notifiable->slug) }}">view</a></td>
                <td width="10%"><i class="icon-remove"></i> <a href="{{ route('remove_notification', $notification->id) }}">remove</a></td>
                <td width="10%"><i class="icon-eye-close"></i> <a href="{{ route('hide_notification', $notification->id) }}">hide</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div> <!-- /container -->
@stop