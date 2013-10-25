@section('content')
<div class="conversation" id="comment-wrapper">

    @if (Acl::check() && (Acl::getUser()->id == $conversation->user_id))
    <div class="row-fluid">
        <div class="well">
            <fieldset> 
                <legend>Members Allowed to View this Conversation</legend>
                <form method="post" name="subscription" class="form-inline" role="form" action="{{ route('add_subscriber') }}">
                    {{ Form::text('subscriber') }}
                    {{ Form::hidden('conversation_id', $conversation->id) }}
                    {{ Form::submit('Add', array('class' => 'btn')) }}
                </form>
                <hr />
                <span class="muted">
                    @if ($conversation->getPrivateSubscribers()->isEmpty())
                        Everyone can view this conversation.
                    @else
                    Users in this conversation:
                        @foreach ($conversation->getPrivateSubscribers() as $subscriber)
                           <a href="{{ route('members_profile', $subscriber->username) }}">{{ $subscriber->username }}</a> <i class="icon-remove"></i>
                        @endforeach
                    @endif
                </span>
            </fieldset>
        </div>
    </div>
    @endif

        <div class="row-fluid">
            <div class="span10">
                @foreach ($conversation->posts as $post)

                <div class="row-fluid">
                    <div class="avatar span1">
                        @if ($post->user)
                        <div class="thumbnail"><a href="{{ route('members_profile', $post->user->username) }}">
                            {{ $post->user->getGravatar(array('img' => true, 's' => 64)) }}
                        </a></div>
                        @else
                        <div class="thumbnail">[user deleted]</div>
                        @endif
                    </div>
                    <div class="span11 well well-small">
                        <div class="info">
                            @if ($post->user)
                            <a href="{{ route('members_profile', $post->user->username) }}" class="poster"><strong>{{ $post->user->username }}</strong></a>
                            <span class="muted">{{ $post->created_at->diffForHumans() }} {{ ($post->user->profile) ? $post->user->profile->location : 'unavailable location' }}</span>
                            <span class="pull-right">
                                <a href="#" class="-quote" id="{{ $post->id }}">quote</a> | 
                                <a href="#" class="-edit" id="{{ $post->id }}">edit</a> | 
                                <a href="#" class="-delete" id="{{ $post->id }}">delete</a> 
                            </span>
                            @else
                            <span class="muted">[use deleted]</span>
                            @endif
                        </div>
                        <hr />
                        <div class="post" id="message-{{ $post->id }}">{{ $post->getProcessedMessage() }}</div>
                        <hr />
                        <span class="muted">One thing is for sure, there's always darkness after daylight.</span>
                    </div>
                </div>
                @endforeach

               @if (Acl::check() && $user_allowed_to_comment)

                {{ Form::open(array('route' => array('post_reply', $conversation->slug))) }}
                <div class="row-fluid" id="reply">
                    <div class="avatar span1">
                        <div class="thumbnail"><a href="{{ route('members_profile', Acl::getUser()->username) }}">
                            {{ Acl::getUser()->getGravatar(array('img' => true, 's' => 64)) }}
                        </a></div>
                    </div>
                    <div class="span11 well well-small">
                        <div class="info">
                                 <a href="{{ route('members_profile', Acl::getUser()->username) }}" class="poster"><strong>{{ Acl::getUser()->username }}</strong></a>
                            <span class="muted">{{ $post->created_at->diffForHumans() }} {{ (Acl::getUser()->profile) ? Acl::getUser()->profile->location : 'unavailable location' }}</span>
                            <input type="submit" class="btn pull-right" value="Post a Reply">
                        </div>
                        <hr />
                        <div class="form">
                        {{ Form::hidden('conversation_id', $post->conversation_id) }}
                        {{ Form::textarea('message', '', array('class' => 'span12', 'id' => 'message')) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                @else
                <div class="row-fluid">
                    @if (Acl::check() && !$user_allowed_to_comment)
                        <div class="avatar span1">
                            <div class="thumbnail"><a href="{{ route('members_profile', Acl::getUser()->username) }}"><img src="{{ theme_asset('images/avatars/0.png') }}"></a></div>
                        </div>
                        <div class="post span11 well well-small">
                            <div class="info">
                                <span class="muted"><i class="icon-lock"></i> Comment is only allowed to particular groups.</span>
                            </div>
                        </div>
                    @else
                        <div class="post span11 well well-small">
                            <div class="info">
                                <a class="poster" href="{{ route('login') }}"><strong>Login</strong></a>
                                <span class="muted">or</span>
                                <a class="poster" href="{{ route('join') }}"><strong>Sign Up</strong></a>
                                <span class="muted">to reply!</span>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

            </div>
            <div class="span2">
                <div class="scrubber">

                    <div class="btn-group btn-block">
                        <button class="btn"><i class="icon-asterisk"></i> Controls</button>
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href=""><i class="icon-star"></i> Mute conversation</a></li>
                            <li><a href=""><i class="icon-star"></i> Mark as unread</a></li>
                            <li class="divider"></li>
                            <li><a href=""><i class="icon-star"></i> Change channel</a></li>
                        </ul>
                    </div>

                    @if (Acl::check() && Acl::getUser()->hasSubscription($conversation->id))
                        <a class="btn btn-block" href="{{ route('unfollow_conversation', $conversation->slug, 'unfollow') }}"><i class="icon-star"></i> Unfollow</a>
                    @else
                        <a class="btn btn-block" href="{{ route('follow_conversation', $conversation->slug, 'follow') }}"><i class="icon-star"></i> Follow</a>
                    @endif
                    <a class="btn btn-block"><i class="icon-plus"></i> Post a Reply</a>
                </div>
            </div>
        </div>
</div>
@stop