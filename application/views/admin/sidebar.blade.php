<div class="well sidebar-nav">
  <ul class="nav nav-list">
    <li{{($method=='posts' or $method=='index')?' class="active"':''}}><a href="{{URL::to('admin/posts')}}">Posts</a></li>
    <li{{$method=='categories'?' class="active"':''}}><a href="{{URL::to('admin/categories')}}">Categories</a></li>
  </ul>
</div><!--/.well -->
