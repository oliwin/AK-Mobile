@extends('index')
@section('content')
<div class="block-form">
    <fieldset>
      <legend>Edit object <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         {{ Form::model($object, array('route' => array('objects.update', $object['_id']), 'files' => false, 'method' => 'PUT')) }}
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
               <?=Form::checkbox('available', 1, ($object["available"] == "1"));?>
            </div>
         </div>
         <div class="form-group prototype-list">

             <div class="col-md-12 row">
                @if(count($prototypes))
                       <label class="col-md-12 control-label">Choose prototype <span class="required-field">*</span></label>
                @foreach($prototypes as $k => $v)
                <div class="item">
                   <div class="col-md-11">
                      <label>{{$v}}</label></div>
                      <div class="col-md-1">
                      {{Form::radio('prototype_id', $k, FALSE)}}
                    </div>
                </div>
                @endforeach
                 @else
                     <p class="no-rows">There are not prototypes</p>
                @endif
          </div>
             </div>
         <div class="form-group fields-list" id="FieldsInPrototype">
           <div class="list">@include('object.parameters')</div>
         </div>
         <div class="form-group">
            <div class="col-md-12">
               <input type="hidden" name="action" value="edit"/>
               <button type="submit" class="btn btn-primary">Update</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
    </fieldset>
</div>
@endsection
