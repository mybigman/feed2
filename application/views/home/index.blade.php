@if(count($posts->results) > 0)
	<div itemprop="blogPosts">
	@foreach($posts->results as $post)
		<article itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
			<h2 itemprop="headline">{{HTML::link(URL::to($post->slug),$post->title,['itemprop'=>'url'])}}</h2>
			<div itemprop="description">
				{{$post->md_excerpt}}
			</div>
			<div class="button-group pull-right">
				<time itemprop="dateModified" datetime="{{date(DateTime::W3C,$post->updated_at->sec)}}" class="button disabled">{{date('M d, Y',$post->updated_at->sec)}}</time>
		    <a itemprop="url" href="{{URL::to($post->slug)}}" class="button primary">Read More</a>
			</div>
		</article>
	@endforeach
	</div>
	{{$posts->links()}}
@else
	<article>
		<h2>Hello World</h2>
		<p>This is a new born blog. No posts yet, so come back later!
	</article>
@endif