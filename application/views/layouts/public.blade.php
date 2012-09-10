<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>{{$title}}</title>
	<meta name="description" content="{{$description}}">
	<meta name="viewport" content="width=device-width">
	<link rel="canonical" href="{{URL::full()}}">
	
	<link rel="stylesheet" href="{{URL::to_asset('css/style.css')}}">
	<link rel="stylesheet" href="{{URL::to_asset('css/prettify.css')}}">

	<script src="{{URL::to_asset('js/libs/modernizr-2.5.3.min.js')}}"></script>
	<script src="{{URL::to_asset('js/prettify.js')}}"></script>
</head>
<body onload="prettyPrint()"  itemscope itemtype="http://schema.org/Blog">
<div class="container">
	@render('home.includes.header')
	<div role="main">
			{{$content}}
	</div>
	<footer>
		@render('home.includes.footer')
	</footer>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{URL::to_asset('js/libs/jquery-1.7.2.min.js')}}"><\/script>')</script>

<script>
	var _gaq=[['_setAccount','UA-34093492-1'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
