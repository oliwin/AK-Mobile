<div class="control-group content-fields-multi">

    @if($field["type"] == "3" || $field["type"] == "5")
        @foreach($field["value"] as $id => $value)
            <div class="col-md-12" style="margin-bottom: 15px">
                <input placeholder="Enter default value (not required)" type="text" name="field_array[]" class="form-control" value="{{$value}}">
            </div>
        @endforeach

    @elseif($field["type"] == "2" || $field["type"] == "6")

        <div class="fields-list">
            <label class="col-md-12 control-label">Children</label>
            @foreach($all as $id => $p)
                <div class="item">
                    <div class="col-md-4">{{$p['name']}}</div>
                    <div class="col-md-8">
                        <input
                                @if(in_array((string)$p["_id"], $field["children"])) checked @endif
                        type="checkbox"
                                name="parameters[{{(string)$p['_id']}}]"></div>
                </div>
            @endforeach
        </div>
    @endif
</div>