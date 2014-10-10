@section('app')

	@include('apps.form')

	@yield('form')

	@include('apps.message')

	@yield('message')

	@include('apps.summary')

	@yield('summary')

@endsection