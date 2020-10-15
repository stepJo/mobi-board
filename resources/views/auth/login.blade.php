
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <title>Login</title>
        
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        
        <link rel="icon" href="{{ asset('app_assets/img/icon.ico') }}" type="image/x-icon"/>

        <!-- Fonts and icons -->
        <script src="{{ asset('app_assets/js/plugin/webfont/webfont.min.js') }}"></script>
        
        <script>
            WebFont.load({
                google: {"families":["Open+Sans:300,400,600,700"]},
                custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ["{{ asset('app_assets/css/fonts.css') }}"]},
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

    <body class="login">

        <div id="app">
                    
            <login-form />

        </div>

        <script src="{{ asset('app_assets/js/core/jquery.3.2.1.min.js') }}"></script>

        <script src="{{ asset('app_assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>

        <script src="{{ asset('app_assets/js/core/popper.min.js') }}"></script>

        <script src="{{ asset('app_assets/js/core/bootstrap.min.js') }}"></script>

        <script src="{{ asset('app_assets/js/ready.js') }}"></script>

         <!-- App Sricpt -->
         <script src="{{ asset('js/app.js') }}"></script>

    </body>

</html>