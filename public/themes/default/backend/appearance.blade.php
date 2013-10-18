@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12 well">

							<fieldset> 
								<legend>Forum Appearance</legend>
								<table class="table">
									<tr>
								   		<td>Choose from Themes</td>
								   		<td>{{ Form::select('theme', array('default' => 'Default')) }}</td>
								   	</tr>
								   	<tr>
								   		<td colspan="2">{{ Form::submit('Set Theme', array('class'=>'btn btn-primary')) }}</td>
								   	</tr>
	                        	</table>
                        	</fieldset>

                    </div>
                </div>

            </div>

        </div>
</div>
@stop