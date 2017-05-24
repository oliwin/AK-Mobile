@if (count($parameter['children']) > 0)
    <ul class="parameters-list-objects">
        @foreach($parameter['children'] as $parameter)

            @include('field.parameter', $parameter)
            <li>
                <label>{{ $parameter['name']}}</label>
                <input class="form-control" type="hidden" name="children[]"
                   value="{{$parameter["_id"]}}">
                <input type="text" class="form-control" name="values[]" value="{{$parameter["value"]}}">

                <input class="form-control" type="hidden" name="parameters[]"
                       value="{{(string)$parameter["_id"]}}">
            </li>
        @endforeach
    </ul>
@endif