<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title>Barberia | @yield('title', 'Dashboard')</title>

	<meta name="description" content="Barber Shop">
	<meta name="author" content="">
	<meta name="robots" content="noindex, nofollow">

	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"/>

	<style>
		@import url('//fonts.googleapis.com/css?family=Lato:300,400,400italic,500,500italic,600,600italic,700,700italic');

		body {
			font-family: 'Lato';
		}
	</style>
	{{--@include('partials.styles')--}}

	{{--<link type="text/css" rel="stylesheet"--}}
	{{--href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.1/jquery.qtip.min.css">--}}

</head>
<body>
<div class="text-center hidden-print"><button class="btn" type="button" onclick="window.close()">Cerrar Ventana</button></div>
<div><img width="200px" src="http://barber-shop.ascbarbershop.ascmexico.net/assets/frontend/img/mail/logo.jpg" alt="Logo" /></div>
@yield('content')
<br /><br /><br />
<p class="text-center">© Powered by <img src="http://barber-shop.ascbarbershop.ascmexico.net/assets/frontend/img/mail/asc.png" alt="" />&nbsp;&nbsp; Desarrollo de Software a la medida</p>
</body>
</html>