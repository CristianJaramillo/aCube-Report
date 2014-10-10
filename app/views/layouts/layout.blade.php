<!DOCTYPE html>
<html lang="@yield('lang')">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>@yield('title')</title>

        <!-- Favicon .ico -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>

        <!-- Custom CSS -->
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet"/>

        <!-- Main CSS -->
        <link href="{{ asset('css/acube.css') }}" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="{{ asset('font-awesome-4.1.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- #wrapper -->
        
        <div class="container-fluid">
            
            <header lass="col-sx-12">
                <div class="row">
                    <div class="col-sx-12 col-sm-9 col-lg-8">
                        <h2 class="title">
                            <img src="{{ asset('img/logo.png') }}" alt="aCube"/>
                                Reporteador Call Center <span>Colas de atención</span>
                        </h2>
                    </div>
                    <div class="col-sx-12 col-sm-3 col-lg-4 text-right">
                        <div class="social-buttons">
                            <a href="https://www.facebook.com/intrudercon?fref=ts">
                                <span alt="facebook" class="ease facebook"></span>
                            </a>
                            <a href="http://intruder.mx/">
                                <span alt="google" class="ease google"></span>
                            </a>
                            <a href="https://twitter.com/intrudercon">
                                <span alt="twitter" class="ease twitter"></span>
                            </a>
                            <a href="https://www.youtube.com/">
                                <span alt="youtube" class="ease youtube"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <div class="container-fluid bg-success" >

            @include('apps.form')
            @yield('form')

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" >
                    @include('apps.category-call')
                    @yield('category-call') 
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    @include('apps.level-service')
                    @yield('level-service') 
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                    @include('apps.recording-and-download')
                    @yield('recording-and-download') 
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 text-center" >
                    @include('apps.table-ui')
                    @yield('table-ui') 
                </div>
            </div>

        </div>
            
        <!-- /#wrapper -->

        <!-- jQuery Version 1.11.0 -->
        <script src="{{ asset('js/jquery-1.11.0.js') }}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <!-- Start JavaScript -->
        <script src="{{ asset('js/start.js') }}"></script>

        <!-- TABLE UI JavaScript -->
        <script src="{{ asset('js/table-ui.js') }}"></script>

        <script>

            $(document).on('ready', start);

            function start() 
            {
                $("body").startUX();

                $('#form-filter').tableUI({
                    "url_response": "{{ route('report') }}",
                    "url"     : "{{ route('queues-and-members') }}"
                });

            }

        </script>

    </body>
</html>
