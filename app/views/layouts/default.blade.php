<!DOCTYPE html>
<html lang="@yield('lang', 'es')">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title', 'aCube')</title>

    	<!-- Bootstrap CSS -->
   		<link href="{{ asset('bootstrap-3.2.0/css/bootstrap.min.css') }}" rel="stylesheet">

    	<!-- Style this templet -->
    	<!-- Fonts -->
    	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
    	<!-- Bootstrap CSS -->
    	<link href="{{ asset('bootstrap-3.2.0/css/main.css') }}" rel="stylesheet">


    	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
  	</head>
  	<body>
    
	    <header class="bg-acube">
	      <div class="container">
	        <div class="row">
	          <div class="col-sx-12 col-sm-9 col-lg-8">
	            <h1 class="title">aCube - Beta</h1>
	          </div>
	          <div class="col-sx-12 col-sm-3 col-lg-4">
	            <div class="social-buttons">
	              <a href="https://www.facebook.com/intrudercon?fref=ts"><span alt="facebook" class="ease facebook"></span></a>
	              <a href="http://intruder.mx/"><span alt="google" class="ease google"></span></a>
	              <a href="https://twitter.com/intrudercon"><span alt="twitter" class="ease twitter"></span></a>
	              <a href="https://www.youtube.com/"><span alt="youtube" class="ease youtube"></span></a>
	            </div>
	          </div>
	        </div>
	      </div>
	    </header>

	    <nav class="navbar navbar-default" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	        	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        	<span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>  
		        </button>
	          	<a href="{{ route('home') }}" class="navbar-brand">Inicio</a>
	        </div>
	        <div class="collapse navbar-collapse navbar-ex1-collapse">
	        	@yield('item-navbar')
	        </div>        
	      </div>
	    </nav>

	    <br/>

	    <div class="container">
	      @yield('app')
	    </div>

	    <!-- jQuery -->
	    <script src="{{ asset('bootstrap-3.2.0/js/jquery-1.11.0.min.js') }}"></script>
	    <!-- Bootstrap JavaScript -->
		<script src="{{ asset('bootstrap-3.2.0/js/bootstrap.min.js') }}"></script>
		@yield('app-script')
  	</body>
</html>