@section('content')
<div class="container">
        <div class="row">
            <div class="span2">
               <div class="thumbnail"> {{ $member->getGravatar(array('img' => true, 's' => 128)) }}</div>
            </div>
            <div class="span8">
                <ul class="unstyled">
                    <li><strong>{{ $member->username }}</strong> <i class="muted">{{ $member->isSuspended() ? '(suspended)' : '' }}</i></li>
                    <li><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
                    <li>@foreach ($member->listGroups() as $group)
                        {{ $group }}
                    @endforeach</li>
                    <li>Last active {{ $member->lastActive() }}</li>
                </ul>
            </div>
             @include('theme::'.Settings::getTheme().'.frontend.user.control')
        </div>
        <hr />
    <ul class="nav nav-tabs">
        <li  class="active"><a href="{{ route('members_profile', $member->username) }}">About</a></li>
        <li><a href="{{ route('members_activity', $member->username) }}">Recent Activities</a></li>
        <li><a href="{{ route('members_stats', $member->username) }}">Statistics</a></li>
    </ul>

    <table class="table table-striped">
        <tbody>
        @if (Acl::check() && Acl::getUser()->username == $member->username)
            <tr>
                <td colspan="2"><a href="{{ route('settings') }}" class="btn btn-primary">Edit Profile</a></td>
            </tr>
        @endif

        @if (!is_null($profile))
            <tr>
                <td width="20%">Location</td>
                <td width="60%">{{ $profile->location }}</td>
            </tr>
            <tr>
                <td width="20%">About</td>
                <td width="60%">{{ $profile->about }}</td>
            </tr>
        @endif
        
        </tbody>
    </table>

</div> <!-- /container -->
@stop