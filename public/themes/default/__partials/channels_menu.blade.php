<div class="row">
    <ul class="nav nav-pills span7">
      <li class=""><a href="{{ route('home') }}"><i class="icon-list"></i> All Channels</a></li>

      @foreach (Provider::getChannel()->all() as $channel)
        <li class=""><a href="{{ route('list_conversations', $channel->slug) }}">{{ $channel->name }}</a></li>
      @endforeach

    </ul>
    <form class="navbar-search pull-right span5" action="{{ route('conversation_search') }}" method="get">
        <input id="search" name="keywords" type="text" class="search-query" placeholder="Search for conversation...">
        <button type="submit" class="btn">Search</button>
    </form>
</div>