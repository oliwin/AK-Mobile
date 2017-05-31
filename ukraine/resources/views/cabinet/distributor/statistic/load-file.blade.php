<div class="col-md-12 filter-table">
@if(Request::is('cabinet/registered') && $status == '1')

        <div class="row" style="margin-bottom: 20px">
            <div class="filter-table-statistic">
                <div class="col-xs-2" style="width: 130px">Дата: <span class="date"><?=date("d.m.y")?></span></div>
                <!--<div class="col-xs-2" style="width: 90px">Всего: <span id="row-selected">{{$clients->count()}}</span>
                </div>-->
                <div class="col-xs-2" style="width: 120px">Загружено: <span id="row-uploaded">0</span></div>
                <div class="col-xs-2" style="width: 130px">Отправлено: <span id="row-sent">0</span></div>
            </div>

            <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only">40% Complete (success)</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3" style="width: 177px; padding-left: 0px">
                <div style="position:relative;">
                    <?=Form::open(array('url' => 'loadResultTest', 'method' => 'POST', 'files' => true))?>
                    <a class='btn btn-success' href='javascript:;'>
                        Загрузить результаты

                        <input class="fileupload"
                               style='width: 162px;height: 32px;position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                               type="file" name="files[]" multiple>
                    </a>
                    &nbsp;
                    <span class='label label-info' id="upload-file-info"></span>
                    {!! Form::close() !!}
                </div>
            </div>
          </div>

@endif

          <div class="row">
            <div class="col-xs-2" style="width: 123px;">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" data-toggle="dropdown">
                        Выбрать
                    </button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="checkAll"><a href="#">Выделить все</a></li>
                        <li><a id="uncCheckAll" href="#">Отменить все</a></li>
                    </ul>
                </div>
            </div>
@if(Request::is('cabinet/registered') && $status == '1')

            <div class="col-xs-2">
                <button class="btn btn-success" id="button-selected" disabled type="button">

                    <div id="fountainG">
                        <div id="fountainG_1" class="fountainG"></div>
                        <div id="fountainG_2" class="fountainG"></div>
                        <div id="fountainG_3" class="fountainG"></div>
                        <div id="fountainG_4" class="fountainG"></div>
                        <div id="fountainG_5" class="fountainG"></div>
                        <div id="fountainG_6" class="fountainG"></div>
                        <div id="fountainG_7" class="fountainG"></div>
                        <div id="fountainG_8" class="fountainG"></div>
                    </div>

                    <div class="ccc">Отправить
                        (<span>0</span>)
                    </div>
                </button>
            </div>
            @endif

            <div class="col-xs-2">
                    <div onclick="return print();" class="btn btn-success">Печать</div>
            </div>

        </div>

    </div>
