@section('app')

	<div class="row">
	  	<div class="col-xs-12 col-sm-4 col-md-4">
  			<nav class="navbar navbar-default" role="navigation">
				<ul class="nav nav-pills nav-stacked" id="dashboard" role="tablist">
					<li>
				    	<a href="#">
				      		<span class="badge pull-right">42</span>
				      		Home
				    	</a>
				  	</li>
					<li>
					 	<a href="#">
					   		<span class="badge pull-right">42</span>
					   		Home
					 	</a>
					</li>
					<li>
					 	<a href="#">
					   		<span class="badge pull-right">42</span>
					   		Home
					 	</a>
					</li>
					<li>
					 	<a href="#">
					   		<span class="badge pull-right">42</span>
					   		Home
					  	</a>
					</li>
				</ul>
			</nav>
  		</div>
  		
	  	<div class="col-xs-12 col-sm-8 col-md-8">
	  		<div class="row">
	  			<div class="table-responsive">
					<table class="ease table table-bordered" id="table-report">
						<thead class="info">
							<tr>
								<th>#</th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
							</tr>
						</thead>
						<tbody class="ease info">
							<tr>
								<td> Date 1 </td>
								<td> Date 2 </td>
								<td> Date 3 </td>
								<td> Date 4 </td>
								<td> Date 5 </td>
							</tr>
						</tbody>
					</table>
				</div>
	  		</div>
	  	</div>
	</div>
@endsection

@section('item-navbar')
	{{ Form::open(['class' => 'navbar-form navbar-right', 'id' => 'search', 'method' => 'GET', 'role' => 'form', 'route' => 'home']) }}
		<div class="form-group">
			{{ Form::select('queue', array('all' => '-- All Queue --'), 'all', array('class' => 'form-control', 'id' => 'queue', 'required')) }}
		</div>
		<div class="form-group">
			{{ Form::select('queue_member', array('all' => '-- All Queue Memebers --'), 'all', array('class' => 'form-control', 'id' => 'queue_member', 'required')) }}
		</div>
		<div class="form-group">
			{{ Form::input('date', 'date_from', NULL, array('class' => 'form-control', 'id' => 'date_from', 'placeholder' => getDay(), 'required')) }}
		</div>
	    <div class="form-group">
	    	{{ Form::input('date', 'date_to', NULL, array('class' => 'form-control', 'id' => 'date_to', 'placeholder' => getDay(), 'required')) }}
	    </div>

	    {{ Form::input('submit', 'btn', 'Buscar', array('class' => 'btn btn-info', 'id' => 'btn')) }}

	{{ Form::close() }}
@endsection

@section('app-script')
	<!-- Table UI JavaScript -->
	<script src="{{ asset('bootstrap-3.2.0/js/table-ui.js') }}"></script>
	<!-- Start JavaScript -->
	<script type="text/javascript">
		
		$(document).on('ready', start);

		function start(){
			$('#search').tableUI({
				"url_responce": "{{ route('responce') }}",
				"url"     : "{{ route('queue-members') }}"
			});
		}

	</script>
@endsection