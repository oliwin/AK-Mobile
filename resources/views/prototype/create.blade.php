@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Create prototype <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         <?=Form::open(array('route' => 'prototypes.store', 'novalidate' => "novalidate", 'method' => 'POST', 'files' => true))?>
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
            <label class="col-md-12 control-label">Visibility</label>
            <div class="col-md-3">
               <?=Form::selectRange('visibility', 0, 20)?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-12">
               <?=Form::checkbox('available', 1, TRUE);?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-12 prototype-list">
               @if($prototype_fields->count())
               <span class="help-block">Fields with visibility = 1</span>
               @foreach($prototype_fields as $key => $name)
               <div class="row item">
                  <div class="col-md-11">
                     <span>{{$name}}</span>
                  </div>
                  <div class="col-md-1">{{Form::checkbox('field_id[]', $key)}}</div>
               </div>
               @endforeach
               @endif
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
               <button type="submit" class="btn btn-primary">Add</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
</div>
</fieldset>
@endsection
