@extends('home')

@section('content_right_block')

    @include("cabinet.distributor.common.modal-message")

    <div id="modalSuccess" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Результаты тестирования</h4>
                </div>
                <div class="modal-body">
                    <p>Результаты тестирования переведены в категорию "Без заключения"</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <a href="{{url("cabinet/registered?status=1")}}" type="button"
                       class="btn btn-primary">Просмотреть</a>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Результаты успешно загружены #<span class="code"></span></h4>
                </div>
                <div class="modal-body">
                    <p> Желаете отправить результаты для получения заключения?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
                    <button type="button" class="btn btn-primary">Да</button>
                </div>
            </div>
        </div>
    </div>

    @if(Request::get("status") == 1)
      <h4>Не обследованы</h4>
    @elseif (Request::get("status") == 2)
    <h4>Без заключения</h4>
    @elseif(Request::get("status") == 3)
    <h4>С заключением</h4>

    @else
<h4>Все</h4>
    @endif

          @if(count($clients))

    <div class="row">
        <div class="col-md-12">


                <table class="table registered-clients table-bordered" id="registered-clients-table">
                    <thead>
                    <tr>
                        <th class="no-print">

                        </th>
                        <th>
                            №
                        </th>
                        <th>

                            Дата тестов


                        </th>
                        <th>
                            ФИО
                        </th>
                        <th>
                            Вид работ
                        </th>

                        <th>
                            Код
                        </th>
                        <th>
                            Профессия
                        </th>
                        <th>
                            Предприятие
                        </th>

                        <th>Транзакция</th>
                        <th>Дата транзакции</th>

                        @if(Request::get("status") == 3)
                            <th>Дата заключения</th>
                            <th>Тип заключения</th>
                        @endif

                        <th class="no-print">
                            Регистрация
                        </th>

                          @if(Request::get("status") == 3)

                          <th class="no-print">
                              Заключение
                          </th>

                          @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($clients as $index => $client)
                        <tr class="no-print" id="result_{{$client->unique_code}}">
                            <td class="no-print">
                                <input type="checkbox" class="check" name="item[{{$client->unique_code}}]"
                                       value="{{$client->unique_code}}">
                            </td>
                            <td>
                                {{$client->id}}
                            </td>
                            <td>

                                <span class="@if ($client->status == "2" && $client->results()->first()->created_at->addDays(3) <= \Carbon\Carbon::now()) expired @endif">
                                    {{$client->created_at->format("d/m/y h:m")}}
                                </span>

                                @if ($client->status == "2" && $client->results()->first()->created_at->addDays(3) <= \Carbon\Carbon::now())
                                    <a href="">Отравить повторно</a>
                                @endif

                            </td>
                            <td>
                                {{$client->name}} {{$client->secondname}} {{$client->patronymic}}
                            </td>
                            <td>
                                № {{$client->types()->get()->implode("type", ", ")}}
                            </td>

                            <td>
                                <strong>
                                    {{$client->unique_code}}
                                </strong>
                            </td>
                            <td>
                                {{$client->profession}}
                            </td>
                            <td>
                                {{$client->factory_name}}
                            </td>


							<td><span>@if(isset($client->transaction)) № {{$client->transaction->transaction_id}} @else - @endif</span>




							</td>
							<td>@if(isset($client->transaction)) {{$client->transaction->created_at->format("d/m/y")}} @else - @endif


  @if($client->status == 3)
  <td>
    {{$client->results->created_at->format("d/m/y")}}
  </td>

  <td>
    @if($client->results->type_conclusion == 1)
    Автоматическое
    @else
    Ручное
    @endif
  </td>

  @endif


							</td>

                            <td class="no-print">
                                <a class="btn btn-primary"
                                   href="{{ url('/cabinet/test/'.$client->id) }}">Детали</a>


                            </td>

                            @if($client->status == 3)

                            <td>

                              <a target="_blank" href="{{url('cabinet/center/test/conclusion/'.$client->unique_code)}}"
                                      class="status btn btn-success">Просмотр</a>

                            </td>
                            @endif

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                  @include ('cabinet.distributor.statistic.filter')


        <div class="counter-bottom">Всего: <strong>{{$clients->count()}}</strong></div>
        </div>

    </div>

    @else
        <p class="notification-center">Нет списка зарегистрированных!</p>
                @endif

@endsection
