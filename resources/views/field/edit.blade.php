@extends('index')

@section('content')

<div class="block-form">

  <fieldset>
             <legend>Edit prototype field <a class="back-link" href="{{URL::previous()}}">Back</a>
             </legend>

       <div class="row">

         {{ Form::model($field, array('route' => array('fields.update', $field->id), 'files' => false, 'method' => 'PUT')) }}

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
                 <label class="col-md-12 control-label">Value <span class="required-field">*</span></label>
                   <div class="col-md-3">
                       {!! Form::text('value', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Value"]) !!}
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
               <div class="form-group">
                 @if($prototypes->count())
                    @foreach($prototypes as $key => $name)
                    <div class="row">
                      <div class="col-md-12">
                        <label>{{$name}}</label>
                        {{Form::checkbox('prototype_id[]', $key)}}
                      </div>
                    </div>
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
