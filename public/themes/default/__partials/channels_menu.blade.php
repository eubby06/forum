<div class="row">
    <ul class="nav nav-pills span8">
      <li class=""><a href="{{ route('home') }}"><i class="icon-list"></i> All Channels</a></li>

      @foreach (Eubby\Models\Channel::all() as $channel)
        <li class=""><a href="{{ route('list_conversations', $channel->slug) }}">{{ $channel->name }}</a></li>
      @endforeach

    </ul>
    <form class="navbar-search pull-right span4">
        <input type="text" class="search-query" placeholder="Search for conversation...">
    </form>
</div>