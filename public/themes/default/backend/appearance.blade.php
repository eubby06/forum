@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">
                    		{{ Form::open(array('route' => 'admin_appearance_post')) }}
							<fieldset> 
								<legend>Forum Appearance</legend>
								<table class="table">
									<tr>
								   		<td>Choose from Themes</td>
								   		<td>{{ Form::select('theme', array('default' => 'Default', 'snow' => 'Snow'), $settings->theme) }}</td>
								   	</tr>
								   	<tr>
								   		<td colspan="2">{{ Form::submit('Set Theme', array('class'=>'btn btn-primary')) }}</td>
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