<div class="col-md-12" id="filter">

    {{ Form::open(array('url' => 'offers/my', 'class' => 'form-inline', 'method' => 'GET')) }}
    <div class="form-group">
		{{__("pending")}}
        {{Form::select('status', [1 => __("pending"), 2 => __("accepted"), 3 => __("archived")], (isset($search->status) ? $search->status : 1), ["class" => "form-control"])}}
    </div>
    <button type="submit" class="btn btn-success">@lang('index.show')</button>
    {{ Form::close() }}
</div>
