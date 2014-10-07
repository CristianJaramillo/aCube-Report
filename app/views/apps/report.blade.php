@section('app')

	<div class="row" id="message-error">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger" role="alert">
				<p>Mensaje de error</p>
			</div>
		</div>
	</div>

	<div class="row">
	  	<div class="col-xs-12 col-sm-6 col-md-3">
	  		<div class="panel panel-acube">

	  			<!-- Primary panel contents -->
	 			<div class="panel-heading">Llamadas</div>

	  			<nav class="navbar navbar-acube dashboard" role="navigation">
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
						   		Finalizadas por el Cliente 
						  	</a>
						</li>
						<li>
						 	<a class="ease" href="#">
						   		<span class="badge pull-right" id="e">0</span>
						   		Finalizadas por el Agente 
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
				<div class="table-responsive">
					<table class="table table-hover table-acube" id="table-description">
						<thead>
							<tr>
								<th>Estado</th>
								<th>Espera</th>
								<th>Duración</th>
							</tr>
						</thead>
						<tbody class="ease table">
							<tr>
								<td colspan="3" style="text-align:center;">Tabla sin contenido</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-9">
			<div class="row-fluid">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="panel panel-acube">
						<!-- Default panel contents -->
			 			<div class="panel-heading">Promedios de Tiempo</div>
			 			<nav class="navbar navbar-acube dashboard" role="navigation">
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
							      		Duración Llamada
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
				<div class="col-xs-12 col-sm-6 col-md-6">
					<!--div class="panel panel-acube"-->
						<!-- Primary panel contents -->
			 			<!--div class="panel-heading">Audio de llamada</div>
			 			<div class="panel-body">
			 				<ul class="nav nav-pills nav-stacked" role="tablist">
			 					<li>
			 						<audio class="center-block" id="complete-recoding" src="audio.mp3" preload="auto" controls></audio>
			 					</li>
			 				</ul>
			 			</div>
					</div-->
				</div>
			</div>
			<div class="row-fluid">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="panel panel-acube">
						<div class="table-responsive">
							<table class="table table-hover table-acube" id="table-report">
								<thead>
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
								<tbody>
									<tr>
										<td colspan="7"><center>Tabla sin contenido!</center></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>	
				</div>
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
			{{ Form::select('event', array(
					'all' => '-- All Events --',
    	    		'TRANSFER' => 'TRANSFER',
    	    		'COMPLETECALL' => 'COMPLETECALL',
    	    		'ABANDON' => 'ABANDON',
        		), 'all', array('class' => 'form-control', 'id' => 'event', 'required', 'title' => 'Event')) }}
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
	<!-- Start UI JavaScript -->
	<script src="{{ asset('bootstrap-3.2.0/js/start.js') }}"></script>
	<!-- Table UI JavaScript -->
	<script src="{{ asset('bootstrap-3.2.0/js/table-ui.js') }}"></script>
	<!-- Start JavaScript -->
	<script type="text/javascript">
		
		$(document).on('ready', start);

		function start(){

			$('#wrapper').startUX({
				"modal": true
			});

			$('#search').tableUI({
				"url_responce": "{{ route('responce') }}",
				"url"     : "{{ route('queue-members') }}"
			});
		}

	</script>
@endsection