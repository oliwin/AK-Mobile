<div id="search" class="row">
  {{ Form::open(array('url' => $search_path, 'class' => 'form-inline', 'method' => 'GET')) }}
    <div class="col-md-2" style="width: 70px !important;">
      {{Form::text('_id', null, array("placeholder" => "ID", "class" => "form-control"))}}
    </div>
    <div class="col-md-2">
      {{Form::text('name', null, array("placeholder" => "Name\Prefix", "class" => "form-control"))}}
    </div>
    @if(isset($categories))
      <div class="col-md-2">
        {{Form::select('category_id', $categories, null, array("class" => "form-control"))}}
      </div>
    @endif
    @if(isset($prototypes_list))
    <div class="col-md-2">
      {{Form::select('prototype_id', $prototypes_list, null, array("class" => "form-control"))}}
    </div>
    @endif
    <div class="col-md-2" style="width: 120px !important;">
      {{Form::select('available', ["0" => "Status", "1" => "Available", "2" => "Not available"], null, array("class" => "form-control"))}}
    </div>
    <!--<div class="col-md-2" style="width: 100px !important;">
      {{Form::select('limit', array('10' => '10', '25' => '25', '50' => '50', '100' => '100'), null, array("class" => "form-control"))}}
    </div>-->
    <div class="col-md-2">
      <input type="submit" name="search" value="Search" class="btn btn-success">
    </div>
  {{ Form::close() }}
</div>
