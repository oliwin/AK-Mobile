<div class="control-group">
    <div class="col-md-12">
        @if (count($parameters) > 0)
            <h4>Parameters</h4>
            <ul class="parameters-list">
                @foreach($parameters as $k => $parameter)
                    <li>
                        <!-- If array with some values -->

                        @if($parameter["type"] == "3" || $parameter["type"] == "5")

                            <label>{{$parameter["name"]}}</label><span class="help-block">(Array)</span>

                            <ul class="parameters-list-array">
                                @foreach($parameter["value"] as $ak => $v)
                                    <li>
                                        <div class="col-md-6">
                                            <input placeholder="Enter default value ({{$parameter["type_value"]}})"
                                                   class="form-control" type="text"
                                                   name="parameters_array[{{(string)$parameter["_id"]}}][]"
                                                   value="{{$v}}">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn remove-more" type="button">-</button>
                                            <button id="b1" class="btn add-more-element-array" type="button">+</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- If another -->
                        @else

                            <label>{{$parameter["name"]}}</label><span class="help-block">(Scalar)</span>

                            <input class="form-control" type="hidden" name="parameters[]"
                                   value="{{(string)$parameter["_id"]}}">

                            <input class="form-control" type="hidden" name="children[]"
                                   value="">

                            <input placeholder="{{$parameter["type_value"]}}" type="text" class="form-control"
                                   name="values[]" value="{{$parameter["value"]}}">

                            @include('field.parameter', ["parameter" => $parameter])

                        @endif
                    </li>
                @endforeach
            </ul>

        @else
            <p class="no-rows">There are not parameters in prototype</p>
        @endif
    </div>
</div>