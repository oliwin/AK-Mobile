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
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-12">
               <?=Form::checkbox('available', 1, TRUE);?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-12 prototype-list">
               @if(count($fields) > 0)
               <h4>Parameters<span class="help-block">fields with visibility = 1</span></h4>
               @foreach($fields as $k => $v)
               <div class="row item">
                  <div class="col-md-11">
                     <span>{{$v["name"]}}</span>
                  </div>
                  <div class="col-md-1">{{Form::checkbox('parameters[]', App\Helpers\Helper::getMongoIDString($v["_id"]))}}</div>
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
</fieldset>
</div>
@endsection
