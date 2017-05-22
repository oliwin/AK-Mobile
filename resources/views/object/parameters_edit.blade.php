<div class="control-group">


    <div class="col-md-12">
        <!-- Object type -->
        @if(isset($parameters[2]))
            <div class="col-md-12">
                <h4>Object</h4>

                <?php $a = 0; ?>

                @foreach($parameters[2] as $k => $v)
                    @foreach($v as $ky => $name)
                        @foreach($name as $v => $b)

                            @if($a == 0)
                                <label>{{$v}}</label>
                            @endif

                            <?php $a++; ?>

                            <div class="col-md-12">
                                <label>{{$b["name"]}}</label>
                                <input class="input form-control" name="parameters[2][{{$ky}}]" type="text"
                                       value="{{$b["value"]}}"/>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>

        @endif

    <!-- Scalar type -->

        @if (isset($parameters[1]))
            <div class="col-md-12">
                <h4>Scalar</h4>
                @foreach($parameters[1] as $k => $parameter)
                    <div class="row item">
                        <div class="col-md-6">
                            <label>{{$parameter["name"]}}</label>
                            <input class="input form-control" name="parameters[1][{{$parameter["parameter_id"]}}]" type="text"
                                   value="{{$parameter["value"]}}"/>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    <!-- Array type -->

        @if (isset($parameters[3]))

            <div class="col-md-12">
                <h4>Array</h4>
                @foreach($parameters[3] as $k => $v)
                    @foreach($v["value"] as $kv => $vv)

                        <div class="row item">
                            <div class="col-md-6">
                                <input class="input form-control" name="parameters[3][{{$v["parameter_id"]}}][]"
                                       type="text"
                                       value="{{$vv}}"/>
                            </div>
                        </div>

                    @endforeach
                @endforeach
            </div>
        @endif


    </div>

</div>