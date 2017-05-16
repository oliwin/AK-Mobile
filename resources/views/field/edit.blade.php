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
            <label class="col-md-12 control-label">Prototypes</label>
            @if($prototypes->count())
               @foreach($prototypes as $k => $v)
               <div>
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
            <label class="col-md-12 control-label">Type</label>
            <div class="col-md-3 select-parameter-type">
               <input type="hidden" name="parent" id="parent_id" value="{{$field->id}}">
               {{Form::select('type', array(1 => "Multi", 2 => "Single"), $field->type, array("class" => "form-control"))}}
            </div>
         </div>

         <div class="form-group content-fields-multi">
            <label class="col-md-12 control-label">Select fields inside</label>
            <div class="col-md-12">
               <div class="fields-list row">
                  @foreach($parents as $k => $v)
                        <div class="col-md-4">{{$v->name}}</div>
                        <div class="col-md-8">
                           {{Form::checkbox('field_child['.$v->id.']', $v->id, $v->checked)}}
                        </div>
                  @endforeach
               </div>

            </div>
         </div>

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
