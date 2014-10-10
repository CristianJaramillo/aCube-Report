@section('summary')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            <div class="row-fluid">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-clock-o fa-fw"></i> 
                                Panel de Llamadas
                            </h3>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <span class="badge" id="a">0</span>
                                Recibidas
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge" id="b">0</span>
                                Atendidas
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge" id="c">0</span> 
                                Abandonadas
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge" id="d">0</span>
                                Finalizada por el cliente
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge" id="e">0</span>
                                Finalizada por el agente
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge" id="f">0</span>
                                Trasferidas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-clock-o fa-fw"></i> 
                                Historial de Llamadas
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="table-description">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Espera</th>
                                        <th>Duración</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" colspan="3">Tabla sin contenido</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-clock-o fa-fw"></i> 
                                Grabaciones de llamada
                            </h3>
                        </div>
                        <div class="list-group" id="recording-sounds">
                            <a href="#" class="list-group-item text-center">
                                Sin grabaciones disponibles.
                            </a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
			<row class="row-fluid">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
	                <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="tClient">00:00:00</div>
                                    <div>Espera</div>
                                </div>
                            </div>
                        </div>
                    </div>
	            </div>
	            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                	<div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="tCall">00:00:00</div>
                                    <div>Duración</div>
                                </div>
                            </div>
                        </div>
                    </div>
	            </div>	
	            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                	<div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="tAbandon">00:00:00</div>
                                    <div>Abandono</div>
                                </div>
                            </div>
                        </div>
                    </div>
 	 	        </div>
            </row>
        
            @include('apps.table-ui')

			@yield('table-ui')
		
		</div>
	</div>
@endsection