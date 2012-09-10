<legend>Posts</legend>
{{HTML::link(URL::to('admin'),'New Post',['class' => 'btn'])}}
<hr>
<div class="row-fluid">
<table class="table-condensed table-bordered table-striped span12">
	<thead>
    <tr>
      <th class="span11">Title</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($posts->results as $post)
    <tr>
      <td>{{$post->title}}</td>
      <td>{{HTML::link(URL::to('admin/posts/'.$post->slug),'Edit',['class'=>'btn btn-mini'])}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<hr>
<div class="row-fluid">
{{$posts->links()}}
</div>