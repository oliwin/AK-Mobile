@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Create parameter<a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         <?=Form::open(array('route' => 'fields.store', 'novalidate' => "novalidate", 'method' => 'POST', 'files' => true))?>
         <div class="form-group">
            <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Default value <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('default', null, ['class' => 'form-control input-disable', 'required' => 'required', 'id' => "default_value", 'placeholder' => "Default Value"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-12">
               <?=Form::checkbox('available', 1, TRUE);?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-4 select-parameter-type">
               <label class="col-md-12 control-label">Value parameter <span class="required-field">*</span></label>
               {{Form::select('type', \App\Helpers\Helper::parameterTypes(), 0, array("class" => "form-control"))}}
            </div>
            <div class="col-md-4">
               <label class="col-md-12 control-label">Type values parameter <span class="required-field">*</span></label>
               {{Form::select('type_value', \App\Helpers\Helper::parameterTypesValue(), 0, array("class" => "form-control"))}}
            </div>
         </div>
          <div class="form-group">
            <div class="col-md-12 content-fields-multi row">
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
               <button type="submit" class="btn btn-primary">Add</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
</fieldset>
</div>
@endsection
