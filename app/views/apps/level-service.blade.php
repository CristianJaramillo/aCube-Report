@section('level-service')
	<div class="row-fluid">
		<div class="col-xs-12">
	        <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-asterisk fa-fw"></i> 
                        Niveles de servicio
                    </h3>
                </div>
	            <div class="list-group">
                    <a href="#" class="list-group-item">
                        <span class="badge" id="tClient">00:00:00</span>
                        Tiempo de espera
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge" id="tCall">00:00:00</span>
                        Duración promedio
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge" id="tAbandon">00:00:00</span>
                        Espera previo a abandono
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="badge" id="g">0</span>
                        Desbordes
                    </a>
	            </div>
            </div>
		</div>
    </div>
@endsection