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
                  <label class="col-md-12 control-label">Category <span class="required-field">*</span></label>
                  <div class="col-md-12">

                    {!! Form::select("category", $categories, null, array("class" => "form-control")) !!}
                  </div>
              </div>


                             <div class="form-group">
                                 <label class="col-md-12 control-label">Visibility <span class="required-field">*</span></label>
                                 <div class="col-md-3">
                                   <?=Form::selectRange('visibility', 0, 20)?>
                                 </div>
                             </div>

               <div class="form-group">
                   <label class="col-md-12 control-label">Available</label>
                   <div class="col-md-3">
                     <?=Form::checkbox('available', 1, TRUE);?>
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
                      <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </div>

               {!! Form::close() !!}
       </div>
   </div>
</fieldset>
@endsection
