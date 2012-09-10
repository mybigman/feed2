<?php
Route::get('(:any)','home@single');
Route::get('/', 'home@index');
Route::get('rss', 'home@rss');
Route::get('tag/(:any)','home@tag');
Route::controller('admin');

Event::listen('404', function(){
	$site = IoC::resolve('site');

	return Response::make(
	      View::make('error.404')
	       	->with('title','Huh? - '.$site->name)
	       	->with('description',$site->description)
	       	->render(),
       	404
        );
});

Event::listen('500', function()
{
	return Response::error('500');
});

Route::filter('auth', function(){
	if (Auth::guest()) return Response::error(404);
});

IoC::singleton('site', function(){
	return (object) Config::get('site');
});

View::composer('home.includes.header', function($v){
	$site = IoC::resolve('site');
	$v->name = $site->name;
	$v->description = $site->description;
});

View::composer('home.includes.footer', function($v){
	$site = IoC::resolve('site');
	$v->name = $site->name;
	$v->description = $site->description;
});

View::composer('home.single', function($v){
	$site = IoC::resolve('site');
	$v->shortName = $site->disquss['shortName'];
	$v->devMode = $site->disquss['devMode'] ? 'var disqus_developer = 1;' : '';
});