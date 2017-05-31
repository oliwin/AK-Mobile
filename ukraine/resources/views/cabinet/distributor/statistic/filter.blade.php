<!--<div id="filter" class="row-no-padding">

    <?=Form::open(array('url' => 'cabinet/registered', 'method' => 'GET', "role" => "search"))?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-3" style="width: 190px">
                <input type="text" name="name" class="form-control inline-item" placeholder="ФИО" autofocus/>
            </div>
            <div class="col-xs-2">
                <?=Form::select('type_work', $work_types, old('type_work'), ["placeholder" => "Вид работ", "class" => "input-small form-control"]);?>
            </div>
            <div class="col-xs-2" style="width: 95px">
                <input type="text" class="form-control" name="code" maxlength="7" placeholder="Код">
            </div>
            <div class="col-md-1" style="width: 102px">
                <?=Form::select('group', [1 => 1, 2 => 2, 3 => 3, 4 => 4], old('group'), ["placeholder" => "Группа", "class" => "input-small form-control"]);?>
            </div>
            <div class="col-xs-2">
                <input type="text" class="form-control" maxlength="10" name="profession" placeholder="Профессия">
            </div>
            <div class="col-xs-2">
                <input type="text" class="form-control" maxlength="10" name="factory" placeholder="Предприятие">
            </div>

            <div class="col-xs-1" style="width: 48px;">
                <button type="submit" class="btn btn-primary glyphicon glyphicon-search"></button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


</div>-->

@include('cabinet.distributor.statistic.load-file')
