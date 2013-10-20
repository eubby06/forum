@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Create Group</legend>

								{{ Form::open(array('route' => 'admin_groups_create_post')) }}
								<table class="table">
									<table class="table">
									<tr>
								   		<td>Group name</td>
								   		<td>{{ Form::text('name', '', array('class' => 'span10')) }}</td>
								   	</tr>
								   	<tr>
								   		<td>Global Permission</td>
								   		<td>
							   			<label class="checkbox">
							   				{{ Form::checkbox('can_moderate', 1) }} Give this group a 'moderate' permission on all existing channels</label>

							   			<span class="muted">You can manage channel-specific permissions on the channels page.</span>
							   			</td>
								   	</tr> 	
								   	<tr>
								   		<td colspan="2">{{ Form::reset('Cancel', array('class'=>'btn')) }}
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