@section('summary')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            <div class="row-fluid">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-asterisk fa-fw"></i> 
                                Categoria de llamada
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

		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
			
            <div class="row-fluid">
				
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
	                
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-asterisk fa-fw"></i> 
                                Niveles de servicio
                            </h3>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                            </a>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-asterisk fa-fw"></i> 
                                Grabaciones de llamada
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tbody id="recording-sounds">
                                    <tr>
                                        <td class="text-center">
                                            Sin grabaciones disponibles.
                                        </td>
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