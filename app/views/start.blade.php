{{-- SETUP PAGE --}}
@if(isset($page))
	
	{{-- LAYOUT --}}
	@if(isset($page->layout))
		@extends($page->layout)
	@endif

	{{-- LANG --}}
	@if(isset($page->lang))
		@section('lang')
			{{ $page->lang }}
		@endsection
	@endif

	{{-- DESCRIPTION --}}
	@if(isset($page->description))
		@section('description')
			{{ $page->description }}
		@endsection
	@endif

	{{-- TITLE --}}
	@if(isset($page->title))
		@section('title')
			{{ $page->title }}
		@endsection
	@endif

	{{-- APP --}}
	@if(isset($page->app))
		@include($page->app)
	@endif
	
@endif