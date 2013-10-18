@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Create Group</legend>

								{{ Form::open(array('route' => array('admin_groups_edit_post', $group->id))) }}
								<table class="table">
									<table class="table">
									<tr>
								   		<td>Group name</td>
								   		<td>{{ Form::text('name', $group->name, array('class' => 'span10')) }}</td>
								   	</tr>
								   	<tr>
								   		<td>Global Permission</td>
								   		<td>
							   			<label class="checkbox">
							   				{{ Form::checkbox('can_moderate', 1, ($group->can_moderate) ? true : false) }} Give this group a 'moderate' permission on all existing channels</label>

							   			<span class="muted">You can manage channel-specific permissions on the channels page.</span>
							   			</td>
								   	</tr> 	
								   	<tr>
								   		<td colspan="2"><a href="{{ route('admin_groups') }}" class="btn">Cancel</a>
								   			{{ Form::submit('Save Changes', array('class'=>'btn btn-primary')) }}</td>
								   	</tr>
	                        	</table>
	                        	{{ Form::close() }}

                        	</fieldset>

                    </div>
                </div>

            </div>

        </div>
</div>
@stop