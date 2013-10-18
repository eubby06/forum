@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Create Channel</legend>
								{{ Form::open(array('route' => 'admin_channels_create_post')) }}
								<table class="table">
									<table class="table">
									<tr>
								   		<td>Channel name</td>
								   		<td>{{ Form::text('name', '', array('class' => 'span10')) }}</td>
								   	</tr>
								   	<tr>
								   		<td>Channel Slug</td>
								   		<td>{{ Form::text('slug', '', array('class' => 'span10')) }}</td>
								   	</tr>
								   	<tr>
								   		<td>Channel Description</td>
								   		<td>{{ Form::textarea('description', '', array('class' => 'span10','rows' => '4')) }}</td>
								   	</tr>
								    <tr>
								   		<td>Subscription</td>
								   		<td><label class="checkbox">{{ Form::checkbox('subscription') }} Subscribe new users by default</label></td>
								   	</tr>
								   <tr>
								   		<td colspan="2">
								   		<table class="table table-striped">
								   			<thead>
								   				<tr>
								   					<th width="60%">&nbsp;</th>
								   					<th width="10%">View</th>
								   					<th width="10%">Reply</th>
								   					<th width="10%">Start</th>
								   					<th width="10%">Moderate</th>
								   				</tr>
								   			</thead>
								   			<tbody>
								   				@foreach ($groups as $gname => $gpermissions)
								   					<tr>
									   					<td><strong>{{ ucfirst($gname) }}</strong></td>
									   					@foreach ($gpermissions as $key => $value)
									   					<td><input type="checkbox" value="{{ str_replace('can',$gname,$key) }}" name="permission[]" {{ $value ? "checked" : "disabled" }}></td>
									   					@endforeach
									   				</tr>

									   				<?php 
									   					//get group
									   					$gmodel = new Eubby\Models\Group();
									   					$group = $gmodel->where('name', $gname)->first(); 
									   				?>

									   				@if ($group && $group->subGroups->count())
								   						@foreach ($group->subGroups as $subgroup)
									   					<tr>
										   					<td>--- {{ ucfirst($subgroup->name) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $subgroup->name.'_view', true) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $subgroup->name.'_reply', true) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $subgroup->name.'_start', true) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $subgroup->name.'_moderate', false) }}</td>
										   				</tr>
										   				@endforeach
									   				@endif
								   				@endforeach
								   			</tbody>
								   		</table>
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