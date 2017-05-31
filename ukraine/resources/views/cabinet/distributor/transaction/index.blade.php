@extends('home')

@section('content_right_block')

@if(count($transactions) > 0)

    @include ('cabinet.distributor.transaction.filter')

    <h4>

        @if(Request::get('status') == 1)Транзакции в ожидании @endif

        @if(Request::get('status') == 2)Транзакции с ответом @endif

        @if(Request::get('status') == 3)Транзакции повторные @endif

    </h4>

    <div class="row registered-clients">
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
                            Дата
                        </th>

                        <th>
                            Заявок
                        </th>

                        @if(Request::get("status") == 3)
                          <th>Дата повтороной отправки</th>
                          <th>Количество отправок</th>
                        @endif

                        <th class="no-print">
                            Действие
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($transactions as $index => $item)

                        <tr class="transaction_{{$item->first()->id}}">

                            <td class="no-print" id="result_{{$item->first()->client_id}}">


                                <input type="checkbox" class="check"
                                       @if($item->first()->status == 1)  @endif name="item[{{$item->first()->client_id}}]"
                                       value="{{$item->first()->client_id}}">

                            </td>

                            <td>
                                  <strong>{{$item->first()->transaction_id}}</strong>
                            </td>
                            <td>
                                <strong> {{$item->first()->created_at->format("d/m/y h:m")}}</strong>
                                <div class="daysAgo">{{\App\Helpers\Helper::diffDateDays($item->first()->created_at)}}</div>
                            </td>
                            <td>

                                {{$item->first()->clients->count()}}
                            </td>

                            @if($item->first()->status == 3)
                              <td>@if(!is_null($item->first()->updated_at)){{$item->first()->updated_at->format("d/m/y h:m")}} @else - @endif</td>
                              <td>{{$item->first()->total_sends}}</td>
                            @endif
                            <!--<td>
                                @if($item->first()->status == 1)<span
                                        class="status yellow btn"> Ожидает ответ</span>@endif

                                @if($item->first()->status == 2)<span
                                        class="status gray btn"> Получен ответ</span>
                                @endif

                                @if($item->first()->status == 3)<span
                                        class="status gray btn">Ошибка транзакции</span>
                                @endif

                            </td>-->
                            <td class="no-print">
                                <a class="btn btn-default" href="{{url('/cabinet/transaction/details/'.$item->first()->transaction_id)}}">Детали</a>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>



        </div>
    </div>

    @else
        <p class="notification-center">Нет транзакций!</p>
    @endif

@endsection
