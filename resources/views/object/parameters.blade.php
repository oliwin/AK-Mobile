<div class="control-group">

    <div class="col-md-12">

        <!-- Object type -->
        @if(isset($parameters[2]))
            <div class="col-md-12">
                <h4>Object</h4>

                @foreach($parameters[2] as $k => $v)
                @foreach($v as $kp => $parameter)
                    <div class="row item">
                        <label>{{$kp}}</label>
                        <div class="col-md-6">
                            <input class="input form-control" name="parameters[{{$k}}][2][]" type="text"
                                   value="{{$parameter}}"/>
                        </div>
                    </div>
                @endforeach
                @endforeach
            </div>
        @endif

    <!-- Scalar type OK -->

        @if(isset($parameters[1]))
            <div class="col-md-12">
                <h4>Scalar</h4>
                @foreach($parameters[1] as $k => $v)
                    @foreach($v as $kp => $parameter)
                        <div class="row item">
                            <div class="col-md-6">
                                <label>{{$kp}}</label>
                                <input class="input form-control" name="parameters[{{$k}}][1]" type="text"
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
                                    <input class="input form-control" name="parameters[{{$k}}][3]" type="text"
                                           value="{{$value}}"/>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>

        @endif
    </div>

</div>