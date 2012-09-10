<header>
	<div class="pull-left">
		{{HTML::link(URL::home(),$name,['id'=>'logo'])}}
		<p>{{$description}}</p>
	</div>
	<nav class="pull-right"><ul>
		<li>{{HTML::link(URL::home(),'Home',['class'=>'button icon home'])}}</li>
		<li>{{HTML::link(URL::to('rss'),'RSS',['class'=>'button icon rss'])}}</li>
	</ul></nav>
</header>