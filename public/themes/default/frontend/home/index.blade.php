@section('content')
<div class="conversations">
          <table class="table table-striped table-hover">
                <tbody>
                    @foreach ($conversations as $conversation)
                    <tr>
                        <td width="2%"><i class="icon-star-empty"></i></td>
                        <td width="15%"><span class="alert alert-info">{{ $conversation->channel->name }}</span></td>
                        <td width="48%"><a class="title" href="{{ route('view_conversation', $conversation->slug) }}">{{ $conversation->title }}</a></td>
                        <td width="15%"><i class="icon-comment"></i> {{ $conversation->posts_count }} replies 
                            @if ($conversation->unread)
                            <span class="alert alert-error">{{ $conversation->unread }} new</span>
                            @endif
                             </td>
                        <td width="20%"><a href="{{ route('members_profile', $conversation->lastPoster()->username) }}">
                            {{ $conversation->lastPoster()->getGravatar(array('img' => true, 's' => 22)) }}
                            {{ $conversation->lastPoster()->username }}</a> <span class="muted">posted</span>  {{ $conversation->lastPost()->created_at->diffForHumans() }}</td>
                    </tr> 
                    @endforeach
                </tbody>
          </table>
</div>
@stop