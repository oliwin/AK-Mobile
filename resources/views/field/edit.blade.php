@extends('index')
@section('content')
    <div class="block-form">
        <fieldset>
            <legend>Edit parameter <a class="back-link" href="{{URL::previous()}}">Back</a>
            </legend>
            <div class="row">
                {{ Form::model($field, array('route' => array('fields.update', $field['_id']), 'files' => false, 'method' => 'PUT')) }}
                <div class="form-group">
                    <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
                    <div class="col-md-12">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Default value <span class="required-field">*</span></label>
                    <div class="col-md-3">
                        {!! Form::text('default', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Default Value"]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Available</label>
                    <div class="col-md-3">
                        <?=Form::checkbox('available', 1, ($field["available"] == "1"));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Visibility</label>
                    <div class="col-md-3">
                        <?=Form::selectRange('visibility', 0, 20)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Only numbers</label>
                    <div class="col-md-3">
                        <?=Form::checkbox('only_numbers');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Type <span class="required-field">*</span></label>
                    <div class="col-md-3 select-parameter-type">
                        {{Form::select('type', array(1 => "Scalar", 2 => "Object", 3 => "Array"), $field["type"], array("class" => "form-control"))}}
                    </div>
                </div>

                <div class="form-group">
                   <div class="col-md-12 content-fields-multi row">
                   </div>
                </div>

                @if($field["type"] == "2")
                    <div class="form-group content-fields fields-object">
                        @if(count($field["value"]) > 0)
                            <label class="col-md-12 control-label">Select fields inside</label>
                            <div class="col-md-12">
                                <div class="fields-list row">
                                    @foreach($field["value"] as $k => $v)
                                        <div class="col-md-4">{{$v['name']}}</div>
                                        <div class="col-md-8">
                                            {{Form::checkbox('field_object['.\App\Helpers\Helper::getMongoIDString($v['_id']).']', $v["default"], array("class" => "form-control"))}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if($field["type"] == "3")
                    <div class="form-group content-fields fields-array">
                        <label class="col-md-12 control-label">Array parameters</label>

                        <div class="input-append">

                            @foreach($field["value"] as $k => $v)

                                <div class="item-row">
                                    <div class="col-md-6">
                                        {{Form::text('field_array[]', $v, array("class" => "form-control"))}}
                                    </div>
                                    <div class="col-md-6">
                                        <button id="b1" class="btn add-more" type="button">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif

                <div class="form-group">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </fieldset>
    </div>
@endsection
