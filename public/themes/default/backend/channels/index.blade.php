@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Forum Channels</legend>
								<p class="muted">Channels are used to categorize conversations on your forum. <br />You can create as many channels as needed, and rearrange/nest them by dragging and dropping below.</p>

								<p><a href="{{ route('admin_channels_create') }}" class="btn"><i class="icon-plus"></i> Create Channel</a></p>

								<table class="table">
									@foreach ($channels as $channel)
									<tr>
								   		<td width="75%">
								   			@if (is_null($channel->deleted_at))
								   			<strong>{{ $channel->name }}</strong>
								   			@else
								   			<span class="muted"><strong>{{ $channel->name }}</strong> <i>(trashed)</i></span>
								   			@endif

								   		</td>
								   		<td width="10%"><a href="{{ route('admin_channels_edit', $channel->id) }}" class="btn btn-small"><i class="icon-edit"></i> edit</a></td>
								   		<td width="15%">
								   			@if (is_null($channel->deleted_at))
								   			<a href="{{ route('admin_channels_delete', $channel->id) }}" class="btn btn-small"><i class="icon-trash"></i> delete</a>
								   			@else
								   			<a href="{{ route('admin_channels_restore', $channel->id) }}" class="btn btn-small"><i class="icon-refresh"></i> restore</a>
								   			@endif
								   		</td>
								   	</tr>
									@endforeach
	                        	</table>
                        	</fieldset>

                    </div>
                </div>

            </div>

        </div>
</div>
@stop