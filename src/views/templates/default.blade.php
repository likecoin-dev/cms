<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{$title}} {{Pongo::system('version')}}</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="" />
	<meta name="description" content="">	
	<meta name="keywords" content="" />
	<meta name="generator" content="" />
	<meta name="robots" content="index,follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" />
	
	{{Render::asset('css/lib.css')}}
	{{Render::asset('css/main.css')}}
	{{Render::styles('header')}}

	{{Render::asset('js/lib/modernizr.min.js')}}
	@section('header-js')
	@show

	{{Render::scripts('header')}}
	{{Render::bootJs('cms/bootstrap.js')}}

</head>
<body>
		
	@yield('layout')

	@yield('sidebar')

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
	<!-- <script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X');ga('send','pageview');
	</script> -->

	{{Render::asset('js/lib/jquery.min.js')}}
	{{Render::asset('js/lib/underscore.min.js')}}
	{{Render::asset('js/lib/bootstrap.min.js')}}

	{{Render::asset('js/plugins.min.js')}}
	{{Render::asset('js/pongo.min.js')}}
	
	{{Render::scripts('footer')}}
	@yield('footer-js')

</body>
</html>