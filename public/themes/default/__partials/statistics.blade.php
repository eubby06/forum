@section('statistics')
<div class="row">
          <ul class="nav nav-pills span9">
              <li><a>Go to top</a></li>
              <li><a>Report a bug</a></li>
              <li><a class="muted">{{ $stats['posts'] }} posts</a></li>
              <li><a class="muted">{{ $stats['conversations'] }} conversations</a></li>
              <li><a href="{{ route('members') }}">{{ $stats['members'] }} members</a></li>
              <li><a>{{ $stats['online'] }} online</a></li>
          </ul>
          <p class="span3 pull-right muted">Powered by FlashGraphics</p>
</div>
@stop