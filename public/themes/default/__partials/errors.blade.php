@if(Session::has('errors'))
	<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Opps!...</h4>
			@foreach($errors->all() as $error)

			    {{ $error }} <br />
			    
			@endforeach
	</div>
@elseif(Session::has('success'))
	<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>{{ Session::get('success') }}</h4>
	</div>
@endif
