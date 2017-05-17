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
               <?=Form::checkbox('available', 1);?>
            </div>
         </div>

         <div class="form-group prototype-list">
           <div class="col-md-12 row">
            @if($prototypes->count() > 0)
                   <label class="col-md-12 control-label">Choose prototype <span class="required-field">*</span></label>
            @foreach($prototypes as $k => $v)
            <div class="item">
               <div class="col-md-11">
                  <label>{{$v->name}}</label></div>
                  <div class="col-md-1">
                  {{Form::radio('prototype_id', $v->id, $v->checked)}}
                </div>
               </div>
            @endforeach
            </div>
            @endif
          </div>
         </div>
         <div class="form-group fields-list" id="FieldsInPrototype">
           <div class="row list">
              @if($fields->count() > 0)
                   <label class="col-md-12 control-label">Choose parameters <span class="required-field">*</span></label>
                @foreach($fields as $k => $v)

                <div class="item">
                  <div class="col-md-4">
                    <div>{{$v->field_details->name}} </div>
                      <div class="mini-text">({{$v->field_details->prefix}})</div>
                  </div>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="fields[{{$v->field_id}}]" value="{{$v->field_details->default}}">
                  </div>
                </div>

                <!--@if(!is_null($v->children))
                  @foreach($v->children as $k => $child)
                    <div class="child item">
                      <div class="col-md-4">
                      <div>{{$child->name->name}}</div>
                          <div class="mini-text">({{$child->name->prefix}})</div>
                    </div>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="fields[{{$child->field_id}}]" value="{{$child->name->default}}">
                    </div>
                    </div>
                  @endforeach
                @endif-->

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
