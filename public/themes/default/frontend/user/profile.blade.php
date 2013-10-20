@section('content')
<div class="container">
        <div class="row">
            <div class="span2">
               <div class="thumbnail"> {{ $member->getGravatar(array('img' => true, 's' => 128)) }}</div>
            </div>
            <div class="span10">
                <ul class="unstyled">
                    <li><strong>{{ $member->username }}</strong></li>
                    <li><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
                    <li>@foreach ($member->listGroups() as $group)
                        {{ $group }}
                    @endforeach</li>
                    <li>Last active {{ $member->lastActive() }}</li>
                </ul>
            </div>
        </div>
        <hr />
    <ul class="nav nav-tabs">
        <li><a href="{{ route('password_settings') }}">Recent Activities</a></li>
        <li class="active"><a href="{{ route('notifications') }}">Statistics</a></li>
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