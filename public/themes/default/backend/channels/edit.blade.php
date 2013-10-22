@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Edit Channel</legend>
								{{ Form::open(array('route' => array('admin_channels_edit_post', $channel->id))) }}
								<table class="table">
									<table class="table">
									<tr>
								   		<td>Channel name</td>
								   		<td>{{ Form::text('name', $channel->name, array('class' => 'span10')) }}</td>
								   	</tr>
								   	<tr>
								   		<td>Channel Slug</td>
								   		<td>{{ Form::text('slug', $channel->slug, array('class' => 'span10')) }}</td>
								   	</tr>
								   	<tr>
								   		<td>Channel Description</td>
								   		<td>{{ Form::textarea('description', $channel->description, array('class' => 'span10','rows' => '4')) }}</td>
								   	</tr>
								    <tr>
								   		<td>Subscription</td>
								   		<td><label class="checkbox">{{ Form::checkbox('subscription', 1, ($channel->subscribe_new_user) ? true : false) }} Subscribe new users by default</label></td>
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
												
									   					<?php $val = str_replace('can',$gname,$key) ?>
									   					<td><input type="checkbox" value="{{ $val }}" name="permission[]" {{ ($permissions[$gname][$key] == 1) ? 'checked="checked"' : '' }} {{ ($value) ? '' : 'disabled'}} /></td>
									   					@endforeach
									   				</tr>

									   				<?php 
									   					//get group
									   					$gmodel = new Eubby\Models\Group();
									   					$group = $gmodel->where('name', $gname)->first(); 
									   				?>

									   				@if ($group && $group->subGroups->count() > 0)
								   						@foreach ($group->subGroups as $subgroup)
								   						<?php $sname = strtolower($subgroup->name); ?>

									   					<tr>
										   					<td>--- {{ ucfirst($subgroup->name) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $sname.'_view', ($permissions[$sname]['can_view'] == 1) ? true : false ) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $sname.'_reply', ($permissions[$sname]['can_reply'] == 1) ? true : false ) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $sname.'_start', ($permissions[$sname]['can_start'] == 1) ? true : false ) }}</td>
										   					<td>{{ Form::checkbox('permission[]', $sname.'_moderate', ($permissions[$sname]['can_moderate'] ==1) ? true : false ) }}</td>
										   				</tr>
										   				@endforeach
									   				@endif
								   				@endforeach
								   			</tbody>
								   		</table>
								   		</td>
								   	</tr>
								   	<tr>
								   		<td colspan="2"><a href="{{ route('admin_channels') }}" class="btn">Cancel</a>
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