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
                                            <input placeholder="Enter default value ({{$parameter["type"]}})"
                                                   class="form-control" type="text"
                                                   name="parameters_array[{{(string)$parameter["_id"]}}][]"
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


                            <input class="form-control" type="hidden" name="parameters[]"
                                   value="{{(string)$parameter["_id"]}}">

                            <input class="form-control" type="hidden" name="children[]"
                                   value="">


                            @if($parameter["type"] == "6" || $parameter["type"] == "2")

                                <div class="col-md-8">
                                    <input readonly="readonly" placeholder="{{$parameter["type"]}}" type="text"
                                           class="form-control"
                                           name="values[]" value="{{$parameter["value"]}}">
                                </div>


                                <div class="col-md-2">
                                    <button data-id="{{(string)$parameter["_id"]}}" class="btn btn-success add-more add-more-object-array" type="button">+</button>
                                </div>

                                @else


                                <div class="col-md-10">
                                    <input placeholder="{{$parameter["type"]}}" type="text"
                                           class="form-control"
                                           name="values[]" value="{{$parameter["value"]}}">
                                </div>

                            @endif

                            </div>


                        @endif

                        @include('field.parameter', ["parameter" => $parameter])

                    </li>
                @endforeach
            </ul>

        @else
            <p class="no-rows">There are not parameters in prototype</p>
        @endif
    </div>
</div>