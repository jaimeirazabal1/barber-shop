<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Barberia | @yield('title', 'Dashboard')</title>

    <meta name="description" content="Barber Shop">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">


    @include('partials.styles')

    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.1/jquery.qtip.min.css">

</head>
<body data-url-api="{{ route('api.index') }}/" data-url="{{ Request::root() }}" data-company="{{ $company }}">
<!-- Page Wrapper -->

<div id="page-wrapper" class="page-loading">
    <!-- Preloader -->
    <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
    <!-- Used only if page preloader enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
    <div class="preloader">
        <div class="inner">
            <!-- Animation spinner for all modern browsers -->
            <div class="preloader-spinner themed-background hidden-lt-ie10"></div>

            <!-- Text for IE9 -->
            <h3 class="text-primary visible-lt-ie10"><strong>Cargando..</strong></h3>
        </div>
    </div>
    <!-- END Preloader -->

    <!-- Page Container -->
    <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">

        @include('partials.sidebar')

        <!-- Main Container -->
        <div id="main-container">

            @include('partials.header')

            <!-- Page content -->
            <div id="page-content">

                @include('flash::message')

                @yield('content')

            </div>
            <!-- END Page Content -->
        </div>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
</div>
<!-- END Page Wrapper -->


@include('partials.javascript')




</body>
</html>