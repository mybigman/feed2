<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Admin Panel</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="{{URL::to_asset('css/style.css')}}">
  <link rel="stylesheet" href="{{URL::to_asset('css/prettify.css')}}">
    <link href="{{URL::to_asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{URL::to_asset('css/select2.css')}}" rel="stylesheet">
    <link href="{{URL::to_asset('css/bootstrap-responsive.css')}}" rel="stylesheet">

  <script src="{{URL::to_asset('js/libs/modernizr-2.5.3.min.js')}}"></script>
    <script src="{{URL::to_asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::to_asset('js/select2.min.js')}}"></script>
    <style> header li {bottom:0;} </style>
</head>
<body>
<div class="container">
  <header>
    <div class="pull-left">
      <h1>{{HTML::link(URL::to('admin'),IoC::resolve('site')->name)}}</h1>
      <p>Admin Panel</p>
    </div>
    <nav class="pull-right"><ul>
      <li>{{HTML::link(URL::to('admin'),'Home',['class'=>'button icon home'])}}</li>
      <li>{{HTML::link(URL::to('admin/posts'),'Posts',['class'=>'button'])}}</li>
      <li>{{HTML::link(URL::to('admin/tags'),'Tags',['class'=>'button'])}}</li>
      <li>{{HTML::link(URL::home(),'Back to Site',['class'=>'button'])}}</li>
    </ul></nav>
  </header>
  <div role="main">
      {{$content}}
  </div>
  <footer>
    <small>Powered by {{HTML::link('#','Feed2')}}</small>
  </footer>
</div>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
<!-- <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script> -->

<script src="{{URL::to_asset('js/plugins.js')}}"></script>
<script src="{{URL::to_asset('js/script.js')}}"></script>
<!-- <script>
  var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script> -->

</body>
</html>
