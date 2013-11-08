@section('content')
<div class="conversation" id="comment-wrapper">

    <div id="-confirm-delete-modal" class="modal hide fade">
        <div class="modal-header">
            <a href="#" data-dismiss="modal" aria-hidden="true" class="close">×</a>
             <h3>Delete</h3>
        </div>
        <div class="modal-body">
            <p>You are about to delete a post.</p>
            <p>Do you want to proceed?</p>
        </div>
        <div class="modal-footer">
          <a href="#" id="-confirm-delete-btn" class="btn danger">Yes</a>
          <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
        </div>
    </div>

    <a href="#" class="back-to-top">Back to Top</a>

    @if (Provider::getAcl()->check() && (Provider::getAcl()->getUser()->id == $conversation->user_id))

    <div class="row-fluid">
        <div class="span10 offset1">
            <span class="muted">Conversation Privacy.</span>
            <a href="#-add-member-form" role="button" data-toggle="modal">Change.</a>
        </div>
    </div>

    <div id="-add-member-form" class="modal hide fade">
        <div class="well">
            <fieldset> 
                <legend>Members Allowed to View this Conversation</legend>
                <form method="post" name="subscription" class="form-inline" role="form" action="{{ route('add_subscriber') }}">
                    {{ Form::text('subscriber', '', array('id' => '-subscriber-username')) }}
                    {{ Form::hidden('conversation_id', $conversation->id, array('id' => '-conversation-id')) }}
                    {{ Form::submit('Add', array('class' => 'btn -add-member')) }}
                </form>
                <span class="-added-members-result alert"></span>
                <hr />
                <span class="muted -added-members">

                        @foreach ($conversation->getPrivateSubscribers() as $subscriber)
                        <span class="{{ $subscriber->username }}">
                            <a href="{{ route('members_profile', $subscriber->username) }}">{{ $subscriber->username }}</a> 
                            <a id="{{ $subscriber->username }}:{{ $conversation->id }}" class="-remove-member" href="#">
                                <i class="icon-remove"></i></a>
                        </span>
                        @endforeach

                </span>
            </fieldset>
        </div>
    </div>
    @endif

        <div class="row-fluid -all-post">
            <div class="span10">
                @foreach ($conversation->posts as $post)

                <div class="row-fluid -single-post-{{ $post->id}}">
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
                                @if (Provider::getAcl()->check() && (Provider::getAcl()->getUser()->id == $conversation->user_id))
                                <span class="pull-right">
                                    <a href="#" class="-quote" id="{{ $post->id }}" data-user="{{ $post->user->username }}">quote</a> | 
                                    <a href="#" class="-edit" id="{{ $post->id }}" >edit</a> | 
                                    <a href="#" class="-delete" id="{{ $post->id }}" >delete</a> 
                                </span>
                                @endif
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

               @if (Provider::getAcl()->check() && $user_allowed_to_comment)

                {{ Form::open(array('route' => array('post_reply', $conversation->slug))) }}
                <div class="row-fluid" id="reply">
                    <div class="avatar span1">
                        <div class="thumbnail"><a href="{{ route('members_profile', Provider::getAcl()->getUser()->username) }}">
                            {{ Provider::getAcl()->getUser()->getGravatar(array('img' => true, 's' => 64)) }}
                        </a></div>
                    </div>
                    <div class="span11 well well-small">
                        <div class="info">
                                 <a href="{{ route('members_profile', Provider::getAcl()->getUser()->username) }}" class="poster"><strong>{{ Provider::getAcl()->getUser()->username }}</strong></a>
                            <span class="muted">{{ $post->created_at->diffForHumans() }} {{ (Provider::getAcl()->getUser()->profile) ? Provider::getAcl()->getUser()->profile->location : 'unavailable location' }}</span>

                            <input type="submit" class="btn pull-right" value="Post a Reply">
                        </div>
                        <hr />
                        <div class="form">
                        {{ Form::hidden('conversation_id', $post->conversation_id) }}
                        {{ Form::textarea('message', '', array('class' => 'span12', 'id' => 'message')) }}
                        </div>
                        <a class="btn btn-small -btn-bold">bold</a>
                        <a class="btn btn-small -btn-italic">italic</a>
                        <a class="btn btn-small -btn-code">code</a>
                    </div>
                </div>
                {{ Form::close() }}

                @else
                <div class="row-fluid">
                    @if (Provider::getAcl()->check() && !$user_allowed_to_comment)
                        <div class="avatar span1">
                            <div class="thumbnail"><a href="{{ route('members_profile', Provider::getAcl()->getUser()->username) }}"><img src="{{ theme_asset('images/avatars/0.png') }}"></a></div>
                        </div>
                        <div class="post span11 well well-small">
                            <div class="info">
                                <span class="muted"><i class="icon-lock"></i> Comment is only allowed to particular groups.</span>
                            </div>
                        </div>
                    @else
                        <div class="span1"></div>
                        <div class="span11 well well-small">
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

                    @if (Provider::getAcl()->check() && Provider::getAcl()->getUser()->hasSubscription($conversation->id))
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