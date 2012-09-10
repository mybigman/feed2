<form action="{{URL::current()}}" class="row-fluid" method="post" accept-charset="utf-8">
  <legend>Create Post</legend>
  <hr>
  @if(count($errors->all()) != 0)
    <div class="alert">{{implode('<br>',$errors->all())}}</div>
  @endif
    <label>Title</label>
    <input type="text" name="title" class="span12" value="{{Input::old('title')}}" required>
    <label>Content</label>
    <textarea name="message" class="span12" required rows="10">{{Input::old('message')}}</textarea>
    <label>Tags</label>
    <input type="hidden" name="tags" id="tags" class="span12" value="{{Input::old('tags','miscellaneous')}}" required>
  <div class="form-actions">
    <button type="submit" class="btn">Submit</button>
  </div>
</form>
<script>
var a = $("#category").val();

$("#tags").select2({
    tags: [{{implode(',',$tags)}}],
    
    //should display the default value of the input                        
    initSelection: function(elem,callback){
        callback({text:elem.val()});
    }
                       
});
</script>