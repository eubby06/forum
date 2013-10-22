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
        <li><a href="{{ route('members_profile', $member->username) }}">About</a></li>
        <li><a href="{{ route('members_activity', $member->username) }}">Recent Activities</a></li>
        <li class="active"><a href="{{ route('members_stats', $member->username) }}">Statistics</a></li>
    </ul>

    <table class="table table-striped">
        <tbody>
            <tr>
                <td width="5%">Posts</td>
                <td width="75%">{{ $member->stats->posts_count }}</td>
            </tr>
            <tr>
                <td width="5%">Conversation Started</td>
                <td width="75%">{{ $member->stats->conversations_started_count }}</td>
            </tr>
            <tr>
                <td width="5%">Conversation Participated</td>
                <td width="75%">{{ $member->stats->conversations_participated_count }}</td>
            </tr>
        </tbody>
    </table>

</div> <!-- /container -->
@stop