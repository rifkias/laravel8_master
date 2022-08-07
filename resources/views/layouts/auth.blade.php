<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Simplebar -->
    <link type="text/css" href="{{asset('template/vendor/simplebar.min.css')}}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{asset('template/css/app.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('template/css/app.rtl.css')}}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{asset('template/css/vendor-material-icons.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('template/css/vendor-material-icons.rtl.css')}}" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="{{asset('template/css/vendor-fontawesome-free.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('template/css/vendor-fontawesome-free.rtl.css')}}" rel="stylesheet">


    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133433427-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-133433427-1');
</script>


    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '327167911228268');
fbq('track', 'PageView');
</script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=327167911228268&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code --> --}}






</head>

<body class="layout-login-centered-boxed">





    <div class="layout-login-centered-boxed__form card">
        @yield('main')
        {{-- <div class="alert alert-soft-success d-flex" role="alert">
            <i class="material-icons mr-3">check_circle</i>
            <div class="text-body">An email with password reset instructions has been sent to your email address, if it exists on our system.</div>
        </div>

        <a href="" class="btn btn-light btn-block">
            <span class="fab fa-google mr-2"></span>
            Continue with Google
        </a>

        <div class="page-separator">
            <div class="page-separator__text">or</div>
        </div> --}}


    </div>


    <!-- jQuery -->
    <script src="{{asset('template/vendor/jquery.min.js')}}"></script>

    <!-- Bootstrap -->
    <script src="{{asset('template/vendor/popper.min.js')}}"></script>
    <script src="{{asset('template/vendor/bootstrap.min.js')}}"></script>

    <!-- Simplebar -->
    <script src="{{asset('template/vendor/simplebar.min.js')}}"></script>

    <!-- DOM Factory -->
    <script src="{{asset('template/vendor/dom-factory.js')}}"></script>

    <!-- MDK -->
    <script src="{{asset('template/vendor/material-design-kit.js')}}"></script>

    <!-- App -->
    <script src="{{asset('template/js/toggle-check-all.js')}}"></script>
    <script src="{{asset('template/js/check-selected-row.js')}}"></script>
    <script src="{{asset('template/js/dropdown.js')}}"></script>
    <script src="{{asset('template/js/sidebar-mini.js')}}"></script>
    <script src="{{asset('template/js/app.js')}}"></script>

    <!-- App Settings (safe to remove) -->
    <script src="{{asset('template/js/app-settings.js')}}"></script>





</body>

</html>
