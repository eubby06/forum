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
            @include('theme::'.Settings::getTheme().'.frontend.user.control')
        </div>
        <hr />
    <ul class="nav nav-tabs">
        <li><a href="{{ route('members_profile', $member->username) }}">About</a></li>
        <li class="active"><a href="{{ route('members_activity', $member->username) }}">Recent Activities</a></li>
        <li><a href="{{ route('members_stats', $member->username) }}">Statistics</a></li>
    </ul>

    <table class="table table-striped">
        <tbody>
            @if ($member->histories)
                @foreach ($member->histories as $history)
                <tr>
                    <td width="5%" colspan="2">

                        {{ 
                            str_replace(
                            array("--title-start--","--title-end--","--name-start--","--name-end--"), 
                            array('<a href="#">','</a>','<a href="#">','</a>'), 
                            $history->message
                            );
                        }}

                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div> <!-- /container -->
@stop