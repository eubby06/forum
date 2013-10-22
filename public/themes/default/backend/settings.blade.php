@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">
                    		{{ Form::open(array('route' => 'admin_settings_update')) }}
							<fieldset> 
								<legend>Forum Settings</legend>
								<table class="table">
									<tr>
								   		<td>Forum title</td>
								   		<td>{{ Form::text('title', $settings->title) }}</td>
								   	</tr>
								    <tr>
								   		<td>Default forum language</td>
								   		<td>{{ Form::select('language', array('en' => 'English','cn' => 'Chinese'), $settings->language) }}</td>
								   	</tr>
									   <tr>
								   		<td>Home page</td>
								   		<td>
								   		<span class="muted">Choose what people will see when they first visit your forum.</span>
							   			<label>
							   				{{ Form::radio('home_page[]', 'show_conversation_list', ($settings->home_page == 'show_conversation_list') ? true : false) }} Show the conversation list by default</label>
							   			<label>
							   				{{ Form::radio('home_page[]', 'show_channel_list', ($settings->home_page == 'show_channel_list') ? true : false) }} Show the channel list by default</label>
							   			</td>
								   	</tr>
								   <tr>
								   		<td>Registration</td>
								   		<td>								   		
								   			<span class="muted">Customize how users can become members of your forum.</span>
							   			<label>
							   				{{ Form::radio('registration[]', 'close', ($settings->registration == 'close') ? true : false) }} Close registration</label>
							   			<label>
							   				{{ Form::radio('registration[]', 'open', ($settings->registration == 'open') ? true : false) }} Open registration</label>
							   			</td>
								   	</tr>
								   <tr>
								   		<td>Member privacy</td>
								   		<td>								   		
								   			<span class="muted">Make member and online list visible to:</span>
							   			<label>
							   				{{ Form::radio('member_privacy[]', 'members', ($settings->member_privacy == 'members') ? true : false) }} Registered members</label>
							   			<label>
							   				{{ Form::radio('member_privacy[]', 'everyone', ($settings->member_privacy == 'everyone') ? true : false) }} Everyone</label>
							   			</td>
								   	</tr>
								   <tr>
								   		<td>Editing permissions</td>
								   		<td>								   			
								   			<span class="muted">Allow members to edit their own posts:</span>
							   			<label>
							   				{{ Form::radio('editing_permission[]', 'forever', ($settings->editing_permission == 'forever') ? true : false) }} Forever</label>
							   			<label>
							   				{{ Form::radio('editing_permission[]', 'until_someone_reply', ($settings->editing_permission == 'until_someone_reply') ? true : false) }} Until someone replies</label></td>
								   	</tr>
								   	<tr>
								   		<td></td>
								   		<td colspan="2">{{ Form::reset('Cancel', array('class'=>'btn')) }}
								   			{{ Form::submit('Save Changes', array('class'=>'btn btn-primary')) }}</td>
								   	</tr>
	                        	</table>
                        	</fieldset>

                        	{{ Form::close() }}
                    </div>
                </div>

            </div>

        </div>
</div>
@stop