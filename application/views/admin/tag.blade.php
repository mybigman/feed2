<form action="{{URL::current()}}" method="post" accept-charset="utf-8" class="row-fluid">
  <legend>Update Tag: {{Input::old('name',isset($name)?$name:'')}}</legend>
  @if(count($errors->all()) != 0)
    <div class="alert">{{implode('<br>',$errors->all())}}</div>
  @endif
  <div class="well">
    <label>Name</label>
    <input type="text" name="name" class="span12" value="{{Input::old('name',isset($name)?$name:'')}}" required>
    <label>Description</label>
    <textarea name="description" class="span12" required rows="3">{{Input::old('description',isset($description)?$description:'')}}</textarea>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn">Submit</button>
  </div>
</form>