
@if (count($parameter['children']) > 0)

    @php
        $parent_id = (string) $parameter["_id"];
    @endphp

    <ul class="parameters-list-objects @if($parameter["type"] == "6") array_objects @endif" id="block_{{$parent_id}}" >

        @foreach($parameter['children'] as $parameter)


            <li>

                <div class="row">

                    <div class="col-md-2">
                        <label>{{ $parameter['name']}} <span class="help-block">({{\App\Helpers\Helper::getTypeParameterName($parameter["type"])}})</span></label>
                    </div>


                    <input class="form-control" type="hidden" name="children_new[{{$parameter_id}}][]"
                           value="<?=$parent_id?>">

                    @if($parameter["type"] == "2" || $parameter["type"] == "6")

                        <div class="col-md-8">
                            <input readonly="readonly" type="text" class="form-control" name="array_object_new[{{$parent_id}}][{{(string)$parameter["_id"]}}][]" value="{{$parameter["value"]}}">
                        </div>

                    @else
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="values_new[{{$parameter_id}}][]" value="{{$parameter["value"]}}">
                        </div>

                    @endif

                    <input class="form-control" type="hidden" name="parameters_new[{{$parameter_id}}][]"
                           value="{{(string)$parameter["_id"]}}">
                </div>
            </li>

            @include('field.new_object_array_parameter', $parameter)

        @endforeach
    </ul>

@endif