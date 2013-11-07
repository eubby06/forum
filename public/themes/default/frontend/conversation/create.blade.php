@section('content')
<div class="conversation">
        <div class="row-fluid">
            <div class="span12">
                
                {{ Form::open(array('route' => 'post_conversation')) }}
                <div class="row-fluid">
                    <div class="avatar span1">
                        <div class="thumbnail"><img src="http://www.gravatar.com/avatar/9cc2b4c5c1cf6b9cf6e0c7a82e4434e2?d=http%3A%2F%2Flaracasts.com%2Fforum%2Fcore%2Fskin%2Favatar.png&s=64"></div>
                    </div>
                    <div class="span11 well well-small">
                        <div class="info">
                            <a class="poster"><strong>{{ Provider::getAcl()->getUser()->username }}</strong></a>
                            <span class="muted">{{ Provider::getAcl()->getUser()->profile->location }}</span>
                            <input type="submit" class="btn pull-right" value="Start Conversation">
                        </div>
                        <hr />
                        <div class="-create-post">
                         @if ($private_user)
                            <p> {{ Provider::getAcl()->getUser()->getGravatar(array('img' => true, 's' => 22)) }} 
                                <a href="#"><strong>{{ Provider::getAcl()->getUser()->username }}</strong></a> and 
                                {{ $private_user->getGravatar(array('img' => true, 's' => 22)) }} 
                                <a href="#"><strong>{{ $private_user->username }}</strong></a> will be able to view this conversation. 
                                <a class="btn btn-small" href="#">Change</a>
                            </p>
                            {{ Form::hidden('private_user', $private_user->id) }}
                            <hr />
                        @endif

                        {{ Form::select('channel_id', $channels) }}
                        {{ Form::text('title', '', array('class' => 'span12', 'placeholder' => 'Enter a conversation title...')) }}
                        {{ Form::textarea('post', '', array('class' => 'span12')) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
</div>
@stop