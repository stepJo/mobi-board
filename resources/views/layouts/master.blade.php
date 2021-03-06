<!DOCTYPE html>

<html lang="en">

    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>Project & Task Management System</title>

        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="icon" href="{{ asset('app_assets/img/icon.ico') }}" type="image/x-icon"/>

        <!-- Fonts and icons -->
        <script src="{{ asset('app_assets/js/plugin/webfont/webfont.min.js') }}"></script>

        <script>

            WebFont.load({
                google: {"families":["Open+Sans:300,400,600,700"]},
                custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], 
                urls: ['{{ asset('app_assets/css/fonts.css') }}']},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });

        </script>

        <!-- CSS Files -->
        <link rel="stylesheet" href="{{  asset('app_assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{  asset('app_assets/css/azzara.min.css') }}">

        <!-- App CSS -->
        <link rel="stylesheet" href="{{  asset('css/app.css') }}">

    </head>

    <body class="bg-green-100">

        @yield('content')

        <!--   Core JS Files   -->
        <script src="{{ asset('app_assets/js/core/jquery.3.2.1.min.js') }}"></script>
        <script src="{{ asset('app_assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('app_assets/js/core/bootstrap.min.js') }}"></script>


        <!-- jQuery UI -->
        <script src="{{ asset('app_assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('app_assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

        <!-- jQuery Scrollbar -->
        <script src="{{ asset('app_assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

        <!-- Moment JS -->
        <script src="{{ asset('app_assets/js/plugin/moment/moment.min.js') }}"></script>

        <!-- Chart JS -->
        <script src="{{ asset('app_assets/js/plugin/chart.js/chart.min.js') }}"></script>

        <!-- jQuery Sparkline -->
        <script src="{{ asset('app_assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

        <!-- Chart Circle -->
        <script src="{{ asset('app_assets/js/plugin/chart-circle/circles.min.js') }}"></script>

        <!-- Datatables -->
        <script src="{{ asset('app_assets/js/plugin/datatables/datatables.min.js') }}"></script>

        <!-- Bootstrap Notify -->
        <script src="{{ asset('app_assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

        <!-- Bootstrap Toggle -->
        <script src="{{ asset('app_assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>

        <!-- jQuery Vector Maps -->
        <script src="{{ asset('app_assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('app_assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

        <!-- Google Maps Plugin -->
        <script src="{{ asset('app_assets/js/plugin/gmaps/gmaps.js') }}"></script>

        <!-- Sweet Alert -->
        <script src="{{ asset('app_assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

        <!-- Azzara JS -->
        <script src="{{ asset('app_assets/js/ready.min.js') }}"></script>

        <!-- Azzara DEMO methods, don't include it in your project! -->
        <script src="{{ asset('app_assets/js/setting-demo.js') }}"></script>

        <script src="{{ asset('app_assets/js/demo.js') }}"></script>

        <!-- App Sricpt -->
        <script src="{{ asset('js/app.js') }}"></script>

    </body>

</html>