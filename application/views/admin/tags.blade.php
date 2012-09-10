<legend>Tags</legend>
{{HTML::link(URL::to('admin/newtag'),'New Tag',['class' => 'btn'])}}
<hr>
<div class="row-fluid">
<table class="table-condensed table-bordered table-striped span12">
	<thead>
    <tr>
      <th class="span11">Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($tags->results as $tag)
    <tr>
      <td>{{$tag->name}}</td>
      <td>{{HTML::link(URL::to('admin/tags/'.$tag->slug),'Edit',['class'=>'btn btn-mini'])}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="row-fluid">
{{$tags->links()}}
</div>