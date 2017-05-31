<div class="col-sm-3 col-md-3">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span
                                class="glyphicon glyphicon-book">
                            </span>Регистрация</a>
                </h4>
            </div>
            <div id="collapseOne"
                 class="panel-collapse collapse {{ Request::is('cabinet/test/file') || Request::is('cabinet/test/form')  ? 'in' : '' }}">
                <div class="panel-body">
                    <table class="table">
                        <tr class="{{ Request::is('cabinet/test/form') ? 'active' : '' }}">
                            <td>
                                <a
                                        href="{{url('cabinet/test/form')}}">Регистрация через форму</a>
                            </td>
                        </tr>
                        <tr class="{{ Request::is('cabinet/test/file') ? 'active' : '' }}">
                            <td>
                                <a
                                        href="{{url('cabinet/test/file')}}">Регистрация списком</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span
                                class="glyphicon glyphicon-th">
                            </span>Лист зарегистрированных</a>
                </h4>
            </div>
            <div id="collapseTwo"
                 class="panel-collapse collapse {{ Request::is('cabinet/registered') || Request::is('cabinet/registered?status=2') || Request::is('cabinet/registered?status=3') || Request::is('cabinet/registered?status=4')  ? 'in' : '' }}">
                <div class="panel-body">
                    <table class="table">
                        <tr class="st_1 {{ Request::is('cabinet/registered') && $status == '1' ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/registered?status=1')}}">Не обследованных</a>
                                <!--<span class="badge">42</span>-->
                            </td>
                        </tr>
                        <tr class="st_2 {{ Request::is('cabinet/registered') && $status == '2' ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/registered?status=2')}}">Без заключения</a>
                                <!--<span class="badge">2</span>-->
                            </td>
                        </tr>
                        <tr class="st_3 {{ Request::is('cabinet/registered') && $status == '3' ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/registered?status=3')}}">С заключением <span class="conclusions label label-success label-as-badge">0</span></a>
                            </td>
                        </tr>
                        <tr class="st_4 {{ Request::is('cabinet/registered') && $status == '4' ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/conclusions')}}">Выданы заключения</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span
                                class="glyphicon glyphicon-transfer">
                            </span>Транзакции</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse {{ Request::is('cabinet/transactions') && (isset($status)) ? 'in' : '' }}">
                <div class="panel-body">
                    <table class="table">
                        <tr class="{{ Request::is('cabinet/transactions') && $status == "1" ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/transactions?status=1')}}">Транзакции в ожидании</a>
                            </td>
                        </tr>
                        <tr class="{{ Request::is('cabinet/transactions') && $status == "2" ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/transactions?status=2')}}">Транзакции с ответом</a>
                            </td>
                        </tr>
                        <tr class="{{ Request::is('cabinet/transactions') && $status == "3" ? 'active' : '' }}">
                            <td>
                                <a href="{{url('cabinet/transactions?status=3')}}">Транзакции с повтором</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="{{url('cabinet/statistic')}}"><span
                                class="glyphicon glyphicon-stats">
                            </span>Статистика</a>
                </h4>
            </div>
            <!--<div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <a href="{{url('cabinet/statistic')}}">Статистика</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>-->
        </div>

      <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><span
                                class="glyphicon glyphicon-indent-right">
                            </span>Администрирование</a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse {{ Request::is('cabinet/administration') ? 'in' : '' }}">
                <div class="panel-body">
                    <table class="table">
                      <tr>
                          <td>
                              <a href="{{url('cabinet/administration')}}">Данные о предприятии</a>
                          </td>
                      </tr>

                      <tr>
                          <td>
                              <a href="{{url('cabinet/administration/accounting')}}">Бухгалтерские данные</a>
                          </td>
                      </tr>

                        <tr>
                            <td>
                                <a href="{{url('cabinet/administration/doctors')}}">Врачи</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{url('cabinet/administration/acts')}}">Акты</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight"><span
                                class="glyphicon glyphicon-phone-alt">
                            </span>Контакты</a>
                </h4>
            </div>
            <div id="collapseEight" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <a href="{{url('cabinet/contacts/center')}}">Контакты центра</a>
                            </td>
                        </tr>
                        <!--<tr>
                            <td>
                                <a href="{{url('cabinet/contacts/customer')}}">Контакты заказчика</a>
                            </td>
                        </tr>-->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
