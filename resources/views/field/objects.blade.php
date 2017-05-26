<div class="fields-list row">
    @foreach($field["value"] as $k => $v)
        <div class="col-md-4">{{$v['name']}}</div>
        <div class="col-md-8">
            {{Form::checkbox('field_object['.\App\Helpers\Helper::getMongoIDString($v['_id']).']', $v["default"], array("class" => "form-control"))}}
        </div>
    @endforeach
</div>