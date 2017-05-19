<label class="col-md-12 control-label">Select fields inside</label>
<div class="fields-list">
    @foreach($fields as $k => $name)
        <div class="item">
            <div class="col-md-4">{{$name}}</div>
            <div class="col-md-8"><input type="checkbox" name="field_child[{{$k}}]" value="{{$k}}"></div>
        </div>
    @endforeach
</div>