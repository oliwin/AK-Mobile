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
                 <label class="col-md-12 control-label">Default value <span class="required-field">*</span></label>
                   <div class="col-md-3">
                       {!! Form::text('default', null, ['class' => 'form-control input-disable', 'required' => 'required', 'placeholder' => "Default Value"]) !!}
                   </div>
               </div>

               <div class="form-group">
                   <label class="col-md-12 control-label">Available</label>
                   <div class="col-md-3">
                     <?=Form::checkbox('available', 1, TRUE);?>
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
                 <label class="col-md-12 control-label">Type <span class="required-field">*</span></label>
                   <div class="col-md-3 select-parameter-type">
                         {{Form::select('type', array(1 => "Multy", 2 => "Single"), 2, array("class" => "form-control"))}}
                   </div>
               </div>


               <div class="form-group">
                 <label class="col-md-12 control-label">Fields for multiply</label>
                   <div class="col-md-3 content-fields-multi">

                   </div>
               </div>

               <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </div>

               {!! Form::close() !!}
       </div>
   </div>
</fieldset>
@endsection
