@section('content')
<div class="container">
        <div class="row">
            <div class="span2">
               <div class="thumbnail"> {{ $member->getGravatar(array('img' => true, 's' => 128)) }}</div>
            </div>
            <div class="span8">
                <ul class="unstyled">
                    <li><strong>{{ $member->username }}</strong></li>
                    <li><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
                    <li>@foreach ($member->listGroups() as $group)
                        {{ $group }}
                    @endforeach</li>
                    <li>Last active {{ $member->lastActive() }}</li>
                </ul>
            </div>
            @if (Auth::user()->isAdmin() && Auth::user()->id != $member->id)
            <div class="span2">
                    <div class="btn-group btn-block">
                        <button class="btn"><i class="icon-asterisk"></i> Controls</button>
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('members_suspend', $member->id) }}"><i class="icon-ban-circle"></i> Suspend member</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('members_group', array('uid' => $member->id,'do' => 'change')) }}"><i class="icon-edit"></i> Change group</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('members_delete', $member->id) }}"><i class="icon-remove"></i> Delete member</a></li>
                        </ul>
                    </div>
            </div>
            @endif
        </div>
        <hr />
    <ul class="nav nav-tabs">
        <li  class="active"><a href="{{ route('members_profile', $member->username) }}">About</a></li>
        <li><a href="{{ route('members_activity', $member->username) }}">Recent Activities</a></li>
        <li><a href="{{ route('members_stats', $member->username) }}">Statistics</a></li>
    </ul>

    <table class="table table-striped">
        <tbody>
        @if (Auth::check() && Auth::user()->username == $member->username)
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