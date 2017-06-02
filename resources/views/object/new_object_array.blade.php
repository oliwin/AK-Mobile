<div class="col-md-12 new">

    <input type="hidden" name="parent_array_object_id[]" value="{{$parameter_id}}">

        @if (count($parameters) > 0)
            <ul style="padding: 0; margin: 0; list-style: none">
                @foreach($parameters as $k => $parameter)
                    <li>
                        <!-- If array with some values -->

                        @if($parameter["type"] == "3" || $parameter["type"] == "5")

                            <label>{{$parameter["name"]}}</label><span class="help-block">(Array)</span>

                            <ul class="parameters-list-array">
                                @foreach($parameter["value"] as $ak => $v)
                                    <li>
                                        <div class="col-md-6">
                                            <input placeholder="Enter default value ({{$parameter["type"]}})"
                                                   class="form-control" type="text"
                                                   name="parameters_array_new[{{$parameter_id}}][{{(string)$parameter["_id"]}}][]"
                                                   value="{{$v}}">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn remove-more" type="button">-</button>
                                            <button class="btn add-more-element-array" type="button">+</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- If another -->
                        @else

                            <div class="row">

                                <div class="col-md-2">
                                    <label>{{$parameter["name"]}}</label><span
                                            class="help-block">({{\App\Helpers\Helper::getTypeParameterName($parameter["type"])}}
                                        )</span>
                                </div>


                                <input class="form-control" type="hidden" name="parameters_new[{{$parameter_id}}][]"
                                       value="{{(string)$parameter["_id"]}}">

                                <input class="form-control" type="hidden" name="children_new[{{$parameter_id}}][]"
                                       value="">


                                @if($parameter["type"] == "2" || $parameter["type"] == "6")

                                    <div class="col-md-10">
                                        <input readonly="readonly" placeholder="{{$parameter["type"]}}" type="text"
                                               class="form-control"
                                               name="values_new[{{$parameter_id}}][]" value="{{$parameter["value"]}}">
                                    </div>

                                @else


                                    <div class="col-md-10">
                                        <input placeholder="{{$parameter["type"]}}" type="text"
                                               class="form-control"
                                               name="values_new[{{$parameter_id}}][]" value="{{$parameter["value"]}}">
                                    </div>

                                @endif

                            </div>


                        @endif

                        @include('field.new_object_array_parameter', ["parameter" => $parameter])

                    </li>
                @endforeach
            </ul>

        @endif
    </div>
