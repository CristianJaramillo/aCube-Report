@section('app')

	<div class="row" id="message-error">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger" role="alert">
				<p>Mensaje de error</p>
			</div>
		</div>
	</div>

	<div class="row">
	  	<div class="col-xs-12 col-sm-4 col-md-4">
	  		<div class="panel panel-acube">

	  			<!-- Primary panel contents -->
	 			 <div class="panel-heading">Llamadas</div>

	  			<nav class="navbar navbar-default" id="dashboard" role="navigation">
					<ul class="nav nav-pills nav-stacked" role="tablist">
						<li>
					    	<a class="ease" href="#">
					      		<span class="badge pull-right" id="a">0</span>
					      		Recibidas
					    	</a>
					  	</li>
						<li>
						 	<a class="ease" href="#">
						   		<span class="badge pull-right" id="b">0</span>
						   		Atendidas
						 	</a>
						</li>
						<li>
						 	<a class="ease" href="#">
						   		<span class="badge pull-right" id="c">0</span>
						   		Abandonadas
						 	</a>
						</li>
						<li>
						 	<a class="ease" href="#">
						   		<span class="badge pull-right" id="d">0</span>
						   		Completadas por Agente 
						  	</a>
						</li>
						<li>
						 	<a class="ease" href="#">
						   		<span class="badge pull-right" id="e">0</span>
						   		Completadas por Cliente 
						  	</a>
						</li>
						<li>
						 	<a class="ease" href="#">
						   		<span class="badge pull-right" id="f">0</span>
						   		Transferidas 
						  	</a>
						</li>
					</ul>
				</nav>
				<!-- Default panel contents -->
	 			<div class="panel-heading">Promedios de Tiempo</div>
	 			<nav class="navbar navbar-default" id="dashboard" role="navigation">
					<ul class="nav nav-pills nav-stacked" role="tablist">
						<li>
					    	<a class="ease" href="#">
					      		<span class="badge pull-right" id="tClient">00:00:00</span>
					      		Espera del Cliente
					    	</a>
					  	</li>
					  	<li>
					    	<a class="ease" href="#">
					      		<span class="badge pull-right" id="tCall">00:00:00</span>
					      		Duración LLamada
					    	</a>
					  	</li>
					  	<li>
					    	<a class="ease" href="#">
					      		<span class="badge pull-right" id="tAbandon">00:00:00</span>
					      		Espera de Abandono
					    	</a>
					  	</li>
					</ul>
				</nav>
			</div>
  		</div>
  		
	  	<div class="col-xs-12 col-sm-8 col-md-8">
	  		<div class="table-responsive">
				<table class="ease table table-bordered table-hover" id="table-report">
					<thead class="acube">
						<tr>
							<th>Fecha</th>
							<th>Cola</th>
							<th>Agente</th>
							<th>Origen</th>
							<th>Espera</th>
							<th>Duraci&oacute;n</th>
							<th>Finalizo</th>
						</tr>
					</thead>
					<tbody class="ease acube-no">
						<tr>
							<td colspan="7"><center>Tabla sin contenido!</center></td>
						</tr>
					</tbody>
				</table>
			</div>
	  	</div>
	</div>
@endsection

@section('item-navbar')
	{{ Form::open(['class' => 'navbar-form navbar-right', 'id' => 'search', 'method' => 'POST', 'role' => 'form', 'route' => 'responce']) }}
		<div class="form-group">
			{{ Form::select('queue', array('all' => '-- All Queue --'), 'all', array('class' => 'form-control', 'id' => 'queue', 'required', 'title' => 'Queue')) }}
		</div>
		<div class="form-group">
			{{ Form::select('queue_member', array('all' => '-- All Queue Memebers --'), 'all', array('class' => 'form-control', 'id' => 'queue_member', 'required', 'title' => 'Queue Member')) }}
		</div>
		<div class="form-group">
			{{ Form::input('date', 'date_from', NULL, array('class' => 'form-control', 'id' => 'date_from', 'placeholder' => getDay(), 'required', 'title' => 'Date From')) }}
		</div>
	    <div class="form-group">
	    	{{ Form::input('date', 'date_to', NULL, array('class' => 'form-control', 'id' => 'date_to', 'placeholder' => getDay(), 'required', 'title' => 'Date To')) }}
	    </div>

	    {{ Form::input('submit', 'btn', 'Buscar', array('class' => 'btn btn-acube ease', 'id' => 'btn')) }}

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