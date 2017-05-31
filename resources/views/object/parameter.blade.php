@if (count($parameter['children']) > 0)

    @php
        $parent_id = (string) $parameter["_id"];
    @endphp

    <ul class="parameters-list-objects">

        @foreach($parameter['children'] as $parameter)

            @include('field.parameter', $parameter)
            <li>
                <label>{{ $parameter['name']}} </label>
                <input class="form-control" type="hidden" name="children[]"
                   value="<?=$parent_id?>">
                <input type="text" class="form-control" name="values[]" value="{{$parameter["value"]}}">

                <input class="form-control" type="hidden" name="parameters[]"
                       value="{{(string)$parameter["_id"]}}">
            </li>
        @endforeach
    </ul>

@endif