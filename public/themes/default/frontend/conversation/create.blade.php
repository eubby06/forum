@section('content')
<div class="conversation">
        <div class="row-fluid">
            <div class="span12">
                
                {{ Form::open(array('route' => 'post_conversation')) }}
                <div class="row-fluid">
                    <div class="avatar span1">
                        <div class="thumbnail"><img src="http://www.gravatar.com/avatar/9cc2b4c5c1cf6b9cf6e0c7a82e4434e2?d=http%3A%2F%2Flaracasts.com%2Fforum%2Fcore%2Fskin%2Favatar.png&s=64"></div>
                    </div>
                    <div class="post span11 well well-small">
                        <div class="info">
                            <a class="poster"><strong>nylad</strong></a>
                            <span class="muted">Oct 2 Melbourne, Australia</span>
                            <input type="submit" class="btn pull-right" value="Start Conversation">
                        </div>
                        <hr />
                        <div class="post">
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