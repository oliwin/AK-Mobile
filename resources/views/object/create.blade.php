@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Create object <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         <?=Form::open(array('route' => 'objects.store', 'novalidate' => "novalidate", 'method' => 'POST', 'files' => true))?>
         <div class="form-group">
            <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Category <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::select("category_id", $categories, null, array("class" => "form-control")) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-3">
               <?=Form::checkbox('available', 1, TRUE);?>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="form-group prototype-list">
               @if(count($prototypes) > 0)
               <label class="col-md-12 control-label">Choose prototype <span class="required-field">*</span></label>
               <div class="col-md-12"><p class="help-block">Will be dislayed prototypes with visibility = 1</p></div>
               @foreach($prototypes as $key => $name)
               <div class="item">
                  <div class="col-md-11">
                     <label>{{$name}}</label>
                  </div>
                  <div class="col-md-1">
                     {{Form::radio('prototype_id', $key)}}
                  </div>
               </div>
               @endforeach
                  @else
                  <p class="no-rows">There are not prototypes</p>
               @endif
            <div id="FieldsInPrototype">
               <div class="list">
               </div>
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
               <input type="hidden" name="action" value="add"/>
               <button type="submit" class="btn btn-primary">Add</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
</fieldset>
@endsection
