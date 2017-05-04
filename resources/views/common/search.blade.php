<div id="search" class="row">

  {{ Form::open(array('url' => Request::url(), 'class' => 'form-inline', 'method' => 'GET')) }}
    <div class="col-md-9">
      {{Form::text('name', null, array("placeholder" => "Search...", "class" => "form-control"))}}
    </div>
    <div class="col-md-1">
      {{Form::select('limit', array('10' => '10', '25' => '25', '50' => '50', '100' => '100'), null, array("class" => "form-control"))}}
    </div>
    <div class="col-md-2">
      {{Form::submit('Search', array("class" => "btn btn-success"))}}
    </div>
  {{ Form::close() }}
</div>
