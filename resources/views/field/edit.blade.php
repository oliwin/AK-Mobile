@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Edit parameter <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         {{ Form::model($field, array('route' => array('fields.update', $field->id), 'files' => false, 'method' => 'PUT')) }}
         <div class="form-group">
            <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Prefix <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('prefix', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Prefix"]) !!}
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
               <?=Form::checkbox('available', 1);?>
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
         <div class="form-group prototype-list">
            @if($prototypes->count())
            @foreach($prototypes as $k => $v)
            <div class="row item">
               <div class="col-md-11">
                  <span>{{$v->name}}</span>
               </div>
               <div class="col-md-1">
                  {{Form::hidden('prototype_id['.$v->id.']', false)}}
                  {{Form::checkbox('prototype_id['.$v->id.']', $v->id, $v->checked)}}
               </div>
            </div>
            @endforeach
            @endif
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Parent</label>
            <div class="col-md-3 select-parameter-type">
               {{Form::select('type', array(1 => "Multy", 2 => "Single"), 2, array("class" => "form-control"))}}
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-12 content-fields-multi">
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
               <button type="submit" class="btn btn-primary">Update</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
</div>
</fieldset>
@endsection
