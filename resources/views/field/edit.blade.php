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
                        {!! Form::text('default', null, ['class' => 'form-control', 'required' => 'required', 'id' => "default_value", 'placeholder' => "Default Value"]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Available</label>
                    <div class="col-md-3">
                        <?=Form::checkbox('available', 1, ($field["available"] == "1"));?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 select-parameter-type">
                        <label class="col-md-12 control-label">Value parameter <span class="required-field">*</span></label>
                        {{Form::select('type', \App\Helpers\Helper::parameterTypes(), $field["type"], array("class" => "form-control"))}}
                    </div>
                    <div class="col-md-4 parameters-type-value">
                        <label class="col-md-12 control-label">Type values parameter <span class="required-field">*</span></label>
                        {{Form::select('type_value', \App\Helpers\Helper::parameterTypesValue(), $field["type_value"], array("id" => "parameters-type-value", "class" => "form-control"))}}
                    </div>
                </div>

                @include("field.list-parameters")

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
