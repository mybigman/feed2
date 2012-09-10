 <form class="form-horizontal" action="{{URL::current()}}" method="post" accept-charset="utf-8">
  <legend>Authentication Required</legend>
  @if(count($errors->all()) != 0)
    <div class="alert">{{implode('<br>',$errors->all())}}</div>
  @endif
  <div class="control-group {{$errors->has('username')?'error':''}}">
    <label class="control-label" for="">Username</label>
    <div class="controls">
      <input type="text" placeholder="derp" value="{{Input::old('username')}}" name="username" required>
    </div>
  </div>
  <div class="control-group {{$errors->has('password')?'error':''}}">
    <label class="control-label" for="">Password</label>
    <div class="controls">
      <input type="password" placeholder="faggot" value="{{Input::old('password')}}" name="password" required>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn">Sign in</button>
    </div>
  </div>
</form>
