@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Forum Groups</legend>
								<p class="muted">Channels are used to categorize conversations on your forum. <br />You can create as many channels as needed, and rearrange/nest them by dragging and dropping below.</p>

								<p><a href="{{ route('admin_groups_create') }}" class="btn"><i class="icon-plus"></i> Create Group</a></p>

								<table class="table">
									@foreach ($groups as $group)
									<tr>
								   		<td width="75%"><strong>{{ ucfirst($group->name) }}</strong></td>
								   		<td width="10%"><a href="{{ route('admin_groups_edit', $group->id) }}" class="btn btn-small"><i class="icon-edit"></i> edit</a></td>
								   		<td width="15%"> 
								   			@if ($group->isDefault())
								   				<a href="#" class="btn btn-small" disabled>
								   			@else
								   				<a href="{{ route('admin_groups_delete', $group->id) }}" class="btn btn-small">
								   			@endif
								   				<i class="icon-remove"></i> remove</a></td>
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