@foreach($fields as $k => $name)
  <div class="row">
    <div class="col-md-4">{{$name}}</div>
    <div class="col-md-8"><input type="checkbox" name="field_child[{{$k}}]" value="{{$k}}"></div>
  </div>
@endforeach
