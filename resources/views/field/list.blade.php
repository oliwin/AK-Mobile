<label class="col-md-12 control-label">Select fields inside</label>
<div class="fields-list">
    @foreach($fields as $k => $v)
        <div class="item">
            <div class="col-md-4">{{$v['name']}}</div>
            <div class="col-md-8"><input type="checkbox" name="field_object[{{\App\Helpers\Helper::getMongoIDString($v['_id'])}}]" value="{{$v['default']}}"></div>
        </div>
    @endforeach
</div>