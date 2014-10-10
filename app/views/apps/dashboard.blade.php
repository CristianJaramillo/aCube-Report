@section('app')

	@include('apps.form')

	@yield('form')

	@include('apps.message')

	@yield('message')

	@include('apps.summary')

	@yield('summary')

	@include('apps.recording-and-download')

	@yield('recording-and-download')

@endsection