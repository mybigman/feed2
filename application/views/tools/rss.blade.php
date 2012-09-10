@if(!empty($posts))
<?xml version="1.0"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
   <channel>
      <title>{{$title}}</title>
      <link>{{URL::home()}}</link>
      <description>{{$description}}</description>
      <language>en-us</language>
      <pubDate>{{date(DateTime::RSS,current($posts)->created_at->sec)}}</pubDate>
      <lastBuildDate>{{date(DateTime::RSS,current($posts)->updated_at->sec)}}</lastBuildDate>
      <atom:link href="{{URL::current()}}" rel="self" type="application/rss+xml" />
      @foreach($posts as $post)
      <item>
         <title>{{$post->title}}</title>
         <link>{{URL::to($post->slug)}}</link>
         <description><![CDATA[{{$post->md_excerpt}}]]></description>
         <pubDate>{{date(DateTime::RSS,$post->created_at->sec)}}</pubDate>
         <guid>{{URL::to($post->slug)}}</guid>
      </item>
      @endforeach
   </channel>
</rss>
@else
<?xml version="1.0"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
   <channel>
      <title>{{$title}}</title>
      <link>{{URL::home()}}</link>
      <description>{{$description}}</description>
      <language>en-us</language>
      <atom:link href="{{URL::current()}}" rel="self" type="application/rss+xml" />
   </channel>
</rss>
@endif
