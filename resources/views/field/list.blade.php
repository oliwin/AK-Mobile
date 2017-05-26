@if(count($fields) > 0)
    <label class="col-md-12 control-label">Select children</label>
    <div class="fields-list">
        @foreach($fields as $k => $v)
            <div class="item">
                <div class="col-md-4">{{$v['name']}}</div>
                <div class="col-md-8"><input type="checkbox"
                                             name="parameters[{{\App\Helpers\Helper::getMongoIDString($v['_id'])}}]"
                                             value="{{$v['default']}}"></div>
            </div>
        @endforeach
    </div>

@else
    <p class="no-rows">There are not parameters in prototype</p>
@endif