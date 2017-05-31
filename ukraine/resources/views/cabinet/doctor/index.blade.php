@extends('home')

@section('content_right_block')

    @include("cabinet.distributor.common.modal-message")

          @if(count($doctors))

    <div class="row">
        <div class="col-md-12">

            @include ('cabinet.distributor.statistic.filter')



                <table class="table registered-clients table-bordered" id="registered-clients-table">
                    <thead>
                    <tr>
                        <th class="no-print">

                        </th>
                        <th>
                            №
                        </th>
                        <th>
                          Дата регистрации

                        </th>
                        <th>
                            ФИО
                        </th>
                        <th>
                            Регион
                        </th>

                        <th>
                            Пароль
                        </th>
                        <th>
                        Телефон
                        </th>
                        <th>
                            Email
                        </th>

                        <th class="no-print">
                            Действие
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($doctors as $index => $doctor)
                        <tr class="no-print" id="result_{{$doctor->user_id}}">
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
                            <td>


                                @if($client->status == 1)<span class="status yellow btn">Не отправлен</span>@endif
                                @if($client->status == 2)<span
                                        class="status gray btn"> На рассмотрении</span>
                                @endif
                                @if($client->status == 3)<a target="_blank" href="{{url('cabinet/center/test/conclusion/'.$client->unique_code)}}"
                                        class="status btn btn-success"> Получен результат</a>
                                @endif
                            </td>


							<td><span>@if(isset($client->results)) № {{$client->results->transaction()->first()->transaction_id}} @else - @endif</span>




							</td>
							<td>@if(isset($client->results)) {{$client->results->transaction()->first()->created_at->format("d/m/y")}} @else - @endif


							</td>

                            <td class="no-print">
                                <a class="btn btn-primary"
                                   href="{{ url('/cabinet/test/'.$client->id) }}">Детали</a>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


        <div class="counter-bottom">Всего: <strong>{{$clients->count()}}</strong></div>
        </div>

    </div>

    @else
        <p class="notification-center">Нет записей</p>
@endif

@endsection
