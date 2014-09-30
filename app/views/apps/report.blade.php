@section('app')

	<div class="row">
	  	<div class="col-xs-12 col-sm-6 col-md-4">
  			<nav class="navbar navbar-default" role="navigation">
				<ul class="nav nav-pills nav-stacked" role="tablist">
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
  		
	  	<div class="col-xs-12 col-sm-6 col-md-8">
	  		<div class="table-responsive">
				<table class="ease table table-bordered">
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
						<tr>
							<td> Date 1 </td>
							<td> Date 2 </td>
							<td> Date 3 </td>
							<td> Date 4 </td>
							<td> Date 5 </td>
						</tr>
						<tr>
							<td> Date 1 </td>
							<td> Date 2 </td>
							<td> Date 3 </td>
							<td> Date 4 </td>
							<td> Date 5 </td>
						</tr>
						<tr>
							<td> Date 1 </td>
							<td> Date 2 </td>
							<td> Date 3 </td>
							<td> Date 4 </td>
							<td> Date 5 </td>
						</tr>
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
@endsection

@section('item-navbar')
	{{ Form::open(['class' => 'navbar-form navbar-right', 'id' => 'search', 'method' => 'POST', 'role' => 'search', 'route' => 'responce']) }}
		<div class="form-group">
			{{ Form::select('queue', $queue, 'all', array('class' => 'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::select('queue_member', $queueMember, 'all', array('class' => 'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::input('date', 'date_from', NULL, array('class' => 'form-control', 'placeholder' => date("d/m/Y"), 'required')) }}
		</div>
	    <div class="form-group">
	    	{{ Form::input('date', 'date_up', NULL, array('class' => 'form-control', 'placeholder' => date("d/m/Y"), 'required')) }}
	    </div>
	    <button type="submit" class="btn btn-info">Buscar</button>
	{{ Form::close() }}
@endsection