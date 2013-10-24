@section('content')
<div class="conversations">
          <table class="table table-striped table-hover">
                <tbody>
                    @if (count($conversations) > 0)
                        @foreach ($conversations as $conversation)
                        <tr>
                            <td width="2%"><i class="icon-star-empty"></i></td>
                            <td width="15%"><span class="alert alert-info">{{ $conversation->channel->name }}</span></td>
                            <td width="40%"><a class="title" href="{{ route('view_conversation', $conversation->slug) }}">{{ $conversation->title }}</a></td>
                            <td width="15%"><i class="icon-comment"></i> {{ $conversation->posts_count }} replies 
                                @if ($conversation->unread)
                                <span class="alert alert-error">{{ $conversation->unread }} new</span>
                                @endif
                                 </td>
                                 @if ($conversation->lastPoster())
                            <td width="20%"><a href="{{ route('members_profile', $conversation->lastPoster()->username) }}">
                                {{ $conversation->lastPoster()->getGravatar(array('img' => true, 's' => 22)) }}
                                {{ $conversation->lastPoster()->username }}</a> <span class="muted">posted</span>  {{ $conversation->lastPost()->created_at->diffForHumans() }}</td>
                                @else
                            <td width="20%">[user deleted]</td>
                                @endif
                        </tr> 
                        @endforeach
                    @else

                        @if (isset($searchError) && $searchError == true)
                            <tr>
                                <td>
                                    <p><strong>No conversations matching your search were found.</strong></p>
                                    <p class="muted">
                                    Reduce the number of gambits or search keywords you're using to find a broader range of conversations.
                                    Note that keywords less than 4 characters in length, and common English words such as 'the' and 'for', aren't included in the search criteria.</p>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    <p><strong>This channel has no conversation.</strong></p>
                                </td>
                            </tr>  
                        @endif

                    @endif
                </tbody>
          </table>
</div>
@stop