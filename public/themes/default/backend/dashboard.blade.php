@section('content')
<div class="conversation">

        <div class="row-fluid">
        	
        	 @include('theme::default.backend.__partials.sidebar_menu')

            <div class="span10">

                <div class="row-fluid">
                    <div class="post span12">
                        <div class="span6  well well-small">
							<fieldset> 
								<legend>Forum Statistics</legend>	
								<table class="table">
									<tr>
										<td>Members</td>
										<td>2</td>
									</tr>
								    <tr>
										<td>Conversations </td>
										<td>2</td>
								    <tr>
										<td>Posts </td>
										<td>2</td>
								    <tr>
										<td>New members in the past week </td>
										<td>2</td>
								    <tr>
										<td>New conversations in the past week </td>
										<td>2</td>
								    <tr>
										<td>New posts in the past week </td>
										<td>2</td>
								</table>
							</fieldset>		
                        </div>
                        <div class="span6  well well-small">
							<fieldset> 
								<legend>Software Versions</legend>
								<table class="table">
								    <tr>
										<td>esoTalk version </td>
										<td>1.0.0g3</td>
								    <tr>
										<td>PHP version </td>
										<td>5.4.4</td>
								    <tr>
										<td>MySQL version </td>
										<td>5.5.25</td>
	                        	</table>
                        	</fieldset>
                        </div>
                    </div>
                </div>

            </div>

        </div>
</div>
@stop