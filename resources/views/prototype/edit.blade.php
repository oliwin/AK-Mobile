@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Edit prototype <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         {{ Form::model($prototype, array('route' => array('prototypes.update', $prototype->id), 'files' => false, 'method' => 'PUT')) }}
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
         <!--<div class="form-group">
            <label class="col-md-12 control-label">Visibility</label>
            <div class="col-md-3">
               <?=Form::selectRange('visibility', 0, 20)?>
            </div>
         </div>-->
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-3">
               <?=Form::checkbox('available', 1);?>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="form-group prototype-list">
            <div class="col-md-12">
               @if($prototype_fields->count())
               <h4>Parameters</h4>
               @foreach($prototype_fields as $k => $v)
               <div class="row item">
                  <div class="col-md-11">
                     <span>{{$v->name}}</span>
                  </div>
                  <div class="col-md-1">
                     {{Form::hidden('field_id['.$v->id.']', false)}}
                     {{Form::checkbox('field_id['.$v->id.']', $v->id, $v->checked)}}
                  </div>
               </div>
               @endforeach
               @endif
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
