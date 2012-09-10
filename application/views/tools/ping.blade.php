<?xml version="1.0"?>
<methodCall>
	<methodName>weblogUpdates.ping</methodName>
	<params>
		<param>
			<value>{{$post->title}}</value>
		</param>
		<param>
			<value>{{URL::to($post->slug)}}</value>
		</param>
	</params>
</methodCall>