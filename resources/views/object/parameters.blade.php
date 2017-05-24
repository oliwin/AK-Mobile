<div class="control-group">
    <div class="col-md-12">
        @if (count($parameters) > 0)
            <h4>Parameters</h4>
            <ul class="parameters-list">
                @foreach($parameters as $k => $parameter)
                    <li>
                        <!-- If array with some values -->

                        <label>{{$parameter["name"]}}</label><span class="help-block">(Scalar)</span>

                        @if($parameter["type"] == "3")
                            <ul class="parameters-list-array">
                                <p class="help-block">(Array)</p>

                                @foreach($parameter["value"] as $ak => $v)
                                    <li>
                                        <input class="form-control" type="text" name="parameters_array[{{(string)$parameter["_id"]}}][]"
                                               value="{{$v}}">
                                    </li>
                                @endforeach
                            </ul>

                            <!-- If another -->
                        @else

                            <input class="form-control" type="hidden" name="parameters[]"
                                   value="{{(string)$parameter["_id"]}}">

                            <input class="form-control" type="hidden" name="children[]"
                                   value="">

                            <input type="text" class="form-control" name="values[]" value="{{$parameter["value"]}}">

                            @include('field.parameter', $parameter)

                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>