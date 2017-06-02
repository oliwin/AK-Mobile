
@if (count($parameter['children']) > 0)

    @php
        $parent_id = (string) $parameter["_id"];
    @endphp

    <ul class="parameters-list-objects @if($parameter["type"] == "6") array_objects @endif" id="block_{{$parent_id}}">

        @foreach($parameter['children'] as $parameter)


            <li>
                <label>{{ $parameter['name']}} <span class="help-block">({{\App\Helpers\Helper::getTypeParameterName($parameter["type"])}})</span></label>
                <input class="form-control" type="hidden" name="children[]"
                       value="<?=$parent_id?>">
                <input @if($parameter["type"] == "2" || $parameter["type"] == "6") readonly="true" @endif type="text" class="form-control" name="values[]" value="{{$parameter["value"]}}">

                <input class="form-control" type="hidden" name="parameters[]"
                       value="{{(string)$parameter["_id"]}}">
            </li>

            @include('field.parameter', $parameter)

        @endforeach
    </ul>

@endif
