@if (count($parameter['children']) > 0)

    @php
        $parent_id = (string) $parameter["_id"];
    @endphp

    <ul class="parameters-list-objects">

        @foreach($parameter['children'] as $parameter)

            <li>
                <label>{{ $parameter['name']}} <span
                            class="help-block">({{\App\Helpers\Helper::getTypeParameterName($parameter["type"])}})</span></label>
                <input class="form-control" type="hidden" name="children[]"
                       value="<?=$parent_id?>">

                <input @if($parameter["type"] == "2" || $parameter["type"] == "6") readonly="true" @endif type="text"
                       class="form-control" name="values[]"

                       value="{{\App\Helpers\Helper::getFieldValue($parameters_object, (string)$parameter["_id"], $parent_id)}}">

                <input class="form-control" type="hidden" name="parameters[]"
                       value="{{(string)$parameter["_id"]}}">
            </li>

            @include('field.parameter_edit', $parameter)

        @endforeach
    </ul>

@endif