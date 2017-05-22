@extends('index')
@section('content')
<div class="block-form">
   <fieldset>
      <legend>Edit prototype <a class="back-link" href="{{URL::previous()}}">Back</a>
      </legend>
      <div class="row">
         {{ Form::model($prototype, array('route' => array('prototypes.update', $prototype['_id']), 'files' => false, 'method' => 'PUT')) }}
         <div class="form-group">
            <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
            <div class="col-md-12">
               {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-12 control-label">Available</label>
            <div class="col-md-3">
               <?=Form::checkbox('available', 1, ($prototype["available"] == "1"));?>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="form-group prototype-list">
            <div class="col-md-12">
               @if(count($fields) > 0)
                  <h4>Parameters<span class="help-block">fields with visibility = 1</span></h4>
                  @foreach($fields as $k => $v)
                     <div class="row item">
                        <div class="col-md-11">
                           <span>{{$v["name"]}}</span>
                           <p style="font-size: 11px; color: #666">@if($v["type"] == "2") Object @elseif($v["type"] == 3) Array @else Scalar @endif</p>
                        </div>
                        <div class="col-md-1">{{Form::checkbox('parameters[]', App\Helpers\Helper::getMongoIDString($v["_id"]))}}</div>
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
</fieldset>
</div>
@endsection
