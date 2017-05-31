<div class="col-sm-3 col-md-3">

    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="{{url('cabinet/center/filials')}}"><span
                                class="glyphicon glyphicon-globe">
                            </span>Региональные центры</a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
                <div class="panel-body">
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight"><span
                                class="glyphicon glyphicon-circle-arrow-right">
                            </span>Результаты тестов</a>
                </h4>
            </div>
            <div id="collapseEight" class="panel-collapse collapse {{Request::is('cabinet/center/tests')  ? 'in' : '' }}">
                <div class="panel-body">
                    <table class="table">
                        <tr class="{{ Request::is('cabinet/center/tests') && $status == 1 ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/center/tests?status=1')}}">С результатом</a>
                            </td>
                        </tr>
                        <tr class="{{ Request::is('cabinet/center/tests') && $status == 2 ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/center/tests?status=2')}}">На повторном рассмотрении</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

