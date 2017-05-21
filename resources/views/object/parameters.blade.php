<div class="control-group">

    <div class="col-md-12">
        <!-- Scalar type -->
        @if(isset($parameters[2]))
            <div class="col-md-12">
                <h4>Scalar</h4>
                @foreach($parameters[2] as $k => $v)
                    @foreach($v as $kp => $parameter)
                        <div class="row item">
                            <div class="col-md-6">
                                <label>{{$kp}}</label>
                                <input class="input form-control" name="parameters[{{$k}}]" type="text"
                                       value="{{$parameter}}"/>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endif

    <!-- Array type -->

        @if(isset($parameters[1]))
            <div class="col-md-12">
                <h4>Object</h4>
                @foreach($parameters[1] as $k => $v)
                    @foreach($v as $kp => $parameter)
                        <div class="row item">
                            <div class="col-md-6">
                                <label>{{$kp}}</label>
                                <input class="input form-control" name="parameters[{{$k}}]" type="text"
                                       value="{{$parameter}}"/>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                </div>
        @endif

    <!-- Object type -->

        @if(isset($parameters[3]))
            <div class="col-md-12">
            <h4>Array</h4>
            @foreach($parameters[3] as $k => $v)
                @foreach($v as $kp => $parameter)
                        @foreach($parameter as $vk => $value)
                    <div class="row item">
                        <div class="col-md-6">
                            <input class="input form-control" name="parameters[{{$k}}][]" type="text"
                                   value="{{$value}}"/>
                            <input class="input form-control" name="parameters_array_name" type="hidden"
                                   value="{{$kp}}"/>
                        </div>
                    </div>
                        @endforeach
                @endforeach
            @endforeach
                </div>

        @endif
    </div>

</div>