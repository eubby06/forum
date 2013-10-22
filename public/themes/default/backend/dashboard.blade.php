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
										<td>{{ $stats->count_members }}</td>
									</tr>
									 <tr>
										<td>Channels </td>
										<td>{{ $stats->count_channels }}</td>
								    </tr>
								    <tr>
										<td>Conversations </td>
										<td>{{ $stats->count_conversations }}</td>
									</tr>
								    <tr>
										<td>Posts </td>
										<td>{{ $stats->count_posts }}</td>
									</tr>
								</table>
							</fieldset>		
                        </div>
                        <div class="span6  well well-small">
							<fieldset> 
								<legend>About this software</legend>
								<table class="table">
								    <tr>
										<td>Software version </td>
										<td>{{ Config::get('forum::settings.version') }}</td>
									</tr>
								    <tr>
										<td>Developer </td>
										<td>{{ Config::get('forum::settings.developer') }}</td>
									</tr>
								    <tr>
										<td>License </td>
										<td>{{ Config::get('forum::settings.license') }}</td>
									</tr>
									<tr>
										<td>Repository </td>
										<td><a href="{{ Config::get('forum::settings.repository') }}" target="_blank">
											{{ Config::get('forum::settings.repository') }}</a>
										</td>
									</tr>
	                        	</table>
                        	</fieldset>
                        </div>
                    </div>
                </div>

            </div>

        </div>
</div>
@stop