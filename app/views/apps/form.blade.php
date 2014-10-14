@section('form')
	{{ Form::open(['class'=> 'navbar-form navbar-right', 'id' => 'form-filter', 'method' => 'POST', 'role' => 'form', 'route' => 'report']) }}
		<div class="form-group">
            {{ Form::select('queue', array('ALL' => '-- All Queue --'), 'ALL', array('class' => 'form-control', 'id' => 'queue', 'required', 'title' => 'Queue')) }}
        </div>
		<div class="form-group">
            {{ Form::select('queue_member', array('ALL' => '-- All Queue Memebers --'), 'ALL', array('class' => 'form-control', 'id' => 'queue_member', 'required', 'title' => 'Queue Member')) }}
        </div>
		<div class="form-group">
            {{ Form::select('event', array(
										'ALL' => '-- All Events --',
    									'TRANSFER' => 'TRANSFER',
    									'EXITWITHTIMEOUT' => 'DESBORDE',
    									'COMPLETECALL' => 'COMPLETECALL',
    									'ABANDON' => 'ABANDON',), 'ALL', 
    								 array('class' => 'form-control', 'id' => 'event', 'required', 'title' => 'Event')) }}
        </div>
		<div class="form-group">
			{{ Form::input('date', 'date_from', timeTo(), array('class' => 'form-control', 'id' => 'date_from', 'placeholder' => timeTo(), 'required', 'title' => 'Date From')) }}
		</div>
	    <div class="form-group">
	    	{{ Form::input('date', 'date_to', timeTo(), array('class' => 'form-control', 'id' => 'date_to', 'placeholder' => timeTo(), 'required', 'title' => 'Date To')) }}
	    </div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary" id="btnSubmit">Buscar</button>
		</div>
	{{ Form::close() }}
@endsection