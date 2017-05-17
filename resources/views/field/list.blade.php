<label class="col-md-12 control-label">Select fields inside</label>
<div class="fields-list">
    @foreach($fields as $k => $name)
        <div class="row item">
            <div class="col-md-4">{{$name->field_details->name}}</div>
            <div class="col-md-8"><input type="input" class="form-control" name="field_child[{{$name->field_details->id}}]" value="{{$name->field_details->default}}"></div>
        </div>

        @if(!is_null($name->field_details->children))
            @foreach($name->field_details->children as $k => $child)
                <div class="child item">
                    <div class="col-md-4">
                        <div>{{$child->name->name}}</div>
                        <div class="mini-text">({{$child->name->prefix}})</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="field_child[{{$child->field_id}}]" value="{{$child->name->default}}">
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
</div>