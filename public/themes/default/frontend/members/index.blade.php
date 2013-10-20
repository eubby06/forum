@section('content')
<div class="conversations">
	<div class="row-fluid">
        <div class="span10">
          	<table class="table table-striped table-hover">
                <tbody>
                    @foreach ($members as $member)
                    <tr>
                    	<td width="10%"><a href="{{ route('members_profile', $member->username)}}">{{ $member->getGravatar(array('img' => true, 's' => 22)) }} 
                    		<strong>{{ $member->username }}</strong></a></td>
                        <td width="10%">@foreach ($member->listGroups() as $group)
                        						{{ $group }}
                        				@endforeach</td>
                        <td width="10%"><span {{ $member->isOnline() ? 'class="online">online' : 'class="offline">offline' }} </span></td>
						<td width="15%">Last active {{ $member->lastActive() }}</td>
						<td width="10%">{{ $member->posts->count() }} posts</td>
                        <td width="15%">
                        	@if ($member->id == Auth::user()->id)
                        		<button class="btn btn-small" disabled >Start Private Conversation</button>
                        	@else
                        		<a class="btn btn-small" class="title" href="{{ route('start_conversation', $member->username) }}">Start Private Conversation</a>
                        	@endif
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
          	</table>
        </div>
        <div class="span2">
         	<div class="scrubber">
                    <a class="btn btn-primary"><i class="icon-plus icon-white"></i> Create Member</a>
            </div>
        </div>
    </div>
</div>
@stop



    