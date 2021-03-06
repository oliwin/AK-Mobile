@extends('index')
@section('content')
    <div class="block-form">
        <fieldset>
            <legend>Create category<a class="back-link" href="{{URL::previous()}}">Back</a>
            </legend>
            <div class="row">
                <?=Form::open(array('route' => 'categories.store', 'novalidate' => "novalidate", 'method' => 'POST', 'files' => true))?>
                <div class="form-group">
                    <label class="col-md-12 control-label">Name <span class="required-field">*</span></label>
                    <div class="col-md-12">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "Name"]) !!}
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
