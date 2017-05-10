@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Edit object <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         {{ Form::model($object, array('route' => array('objects.update', $object->id), 'files' => false, 'method' => 'PUT')) }}
         <div class="form-group">
            <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
            <div class="col-md-3">
               {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Prefix <span class="required-field">*</span></label>
            <div class="col-md-3">
               {!! Form::text('prefix', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Prefix"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Category <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::select("category_id", $categories, null, array("class" => "form-control")) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Visibility <span class="required-field">*</span></label>
            <div class="col-md-3">
               <?=Form::selectRange('visibility', 0, 20)?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-3">
               <?=Form::checkbox('available', 1);?>
            </div>
         </div>
         <div class="form-group">
            @if($prototypes->count() > 0)
            @foreach($prototypes as $k => $v)
            <div class="row">
               <div class="col-md-12">
                  <label>{{$v->name}}</label>
                  <!--{{Form::hidden('prototype_id', false)}}-->
                  {{Form::radio('prototype_id', $v->id, $v->checked)}} <!-- 'prototype_id['.$v->id.']' -->
               </div>
            </div>
            @endforeach
            @endif
         </div>
         <div class="form-group">
            @if($fields->count() > 0)
            @foreach($fields as $k => $v)
            <span>{{$v->name->name}}</span>
            <input type="text" name="fields[{{$v->field_id}}]" value="{{$v->value}}">
            @endforeach
            @endif
         </div>
         <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
               <button type="submit" class="btn btn-primary">Update</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
</div>
</fieldset>
@endsection
