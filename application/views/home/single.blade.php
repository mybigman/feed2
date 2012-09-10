<article class="single" itemprop="blogPost" itemscope itemtype="BlogPosting">
	<h1 itemprop="headline">{{$post->title}}</h1>
	<div class="button-group">
		<time itemprop="datePublished" class="button single disabled" datetime="{{date(DateTime::W3C,$post->created_at->sec)}}">Created: {{date('M d, Y',$post->created_at->sec)}}</time>
		<time itemprop="dateModified" class="button single disabled" datetime="{{date(DateTime::W3C,$post->updated_at->sec)}}">Updated: {{date('M d, Y',$post->updated_at->sec)}}</time>
    <a itemprop="discussionUrl" href="{{URL::to($post->slug)}}#comments" class="button primary icon comment">Comments</a>
	</div>
	<div itemprop="articleBody">
		{{$post->message}}
	</div>
	<div class="button-group">
	    <span class="button primary" itemprop="keywords">Tags:</span>
		    @foreach($post->tags as $tag)
			    <a href="{{URL::to('tag/'.$tag->slug)}}" class="button">{{$tag->name}}</a>
		    @endforeach
	</div>
</article>
<aside>
	<h2 id="comments">Comments</h3>
	<div id="disqus_thread"></div>
	<script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	    var disqus_shortname = '{{$shortName}}'; // required: replace example with your forum shortname
	    {{$devMode}}

	    /* * * DON'T EDIT BELOW THIS LINE * * */
	    (function() {
	        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
	        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	    })();
	</script>
	<noscript>Please enable JavaScript to view the awesome comments.</a></noscript>
</aside>