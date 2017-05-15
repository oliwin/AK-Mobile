@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Create new object <a class="back-link" href="{{URL::previous()}}">Back</a>
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
            <label class="col-md-12 control-label">Prefix <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('prefix', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Prefix"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Category <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::select("category_id", $categories, null, array("class" => "form-control")) !!}
            </div>
         </div>
         <!--<div class="form-group">
            <label class="col-md-12 control-label">Visibility <span class="required-field">*</span></label>
            <div class="col-md-3">
               <?=Form::selectRange('visibility', 0, 20)?>
            </div>
         </div>-->
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-3">
               <?=Form::checkbox('available', 1, TRUE);?>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="form-group prototype-list">
            <div class="col-md-12">
               <h5>Choose ptototype</h5>
               @if($prototypes->count())
               <p class="help-block">Will be dislayed prototypes with visibility = 1</p>
               @foreach($prototypes as $key => $name)
               <div class="row item">
                  <div class="col-md-11">
                     <label>{{$name}}</label>
                  </div>
                  <div class="col-md-1">
                     {{Form::radio('prototype_id', $key)}}
                  </div>
               </div>
               @endforeach
               @endif
            </div>
            <div id="FieldsInPrototype">
               <div class="list">
               </div>
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
