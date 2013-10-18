@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Forum Settings</legend>
								<table class="table">
									<tr>
								   		<td>Forum title</td>
								   		<td>{{ Form::text('title') }}</td>
								   	</tr>
								    <tr>
								   		<td>Default forum language</td>
								   		<td>{{ Form::select('language', array('en' => 'English')) }}</td>
								   	</tr>
								   <tr>
								   		<td>Forum header</td>
								   		<td>
							   			<label>
							   				{{ Form::radio('header') }} Show the forum title in the header </label>
							   			<label>
							   				{{ Form::radio('header') }} Show an image in the header</label>
								   		</td>
								   	</tr>
								   <tr>
								   		<td>Home page</td>
								   		<td>
								   		<span class="muted">Choose what people will see when they first visit your forum.</span>
							   			<label>
							   				{{ Form::radio('homepage') }} Show the conversation list by default</label>
							   			<label>
							   				{{ Form::radio('homepage') }} Show the channel list by default</label>
							   			</td>
								   	</tr>
								   <tr>
								   		<td>Registration</td>
								   		<td>								   		
								   			<span class="muted">Customize how users can become members of your forum.</span>
							   			<label>
							   				{{ Form::radio('registration') }} Close registration</label>
							   			<label>
							   				{{ Form::radio('registration') }} Open registration</label>
							   			<label>
							   				{{ Form::radio('registration') }} Require users to confirm their email address</label>
							   			</td>
								   	</tr>
								   <tr>
								   		<td>Member privacy</td>
								   		<td>								   		
								   			<span class="muted">Make member and online list visible to:</span>
							   			<label>
							   				{{ Form::radio('privacy') }} Registered members</label>
							   			<label>
							   				{{ Form::radio('privacy') }} Everyone</label>
							   			</td>
								   	</tr>
								   <tr>
								   		<td>Member groups</td>
								   		<td>								   		
								   			<span class="muted">Groups can be used to categorize members and give them certain privileges.</span><br />
							   			<a href="#">Manage Groups</a></td>
								   	</tr>
								   <tr>
								   		<td>Editing permissions</td>
								   		<td>								   			
								   			<span class="muted">Allow members to edit their own posts:</span>
							   			<label>
							   				{{ Form::radio('edit_permission') }} Forever</label>
							   			<label>
							   				{{ Form::radio('edit_permission') }} Until someone replies</label></td>
								   	</tr>
								   	<tr>
								   		<td></td>
								   		<td colspan="2">{{ Form::reset('Cancel', array('class'=>'btn')) }}
								   			{{ Form::submit('Save Changes', array('class'=>'btn btn-primary')) }}</td>
								   	</tr>
	                        	</table>
                        	</fieldset>

                    </div>
                </div>

            </div>

        </div>
</div>
@stop