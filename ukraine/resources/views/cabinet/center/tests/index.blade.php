@extends('cabinet.center.index')

@section('content_right_block')

    @include("cabinet.center.common.modal-message")
    @include("cabinet.center.common.print")

    <div class="row">
        <div class="col-md-12">

            @if(count($tests))

                <table class="table registered-clients table-bordered" id="registered-clients-table">
                    <thead>
                    <tr>
                        <th class="no-print">

                        </th>
                        <th>
                            № Транзакции
                        </th>
                        <th>
                            Дата отравки

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
                        <th class="no-print">
                            Действие
                        </th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($tests as $index => $client)
                        <tr class="no-print" id="result_{{$client->id}}">
                            <td class="no-print">
                                <input type="checkbox" class="check" name="item[{{$client->id}}]"
                                       value="{{$client->id}}">
                            </td>
                            <td>
                                {{$client->transaction_id}}
                            </td>
                            <td>

                                {{$client->created_at->format("d/m/Y H:m")}}

                            </td>
                            <td>
                                {{$client->client()->first()->name}} {{$client->client()->first()->secondname}} {{$client->client()->first()->patronymic}}
                            </td>
                            <td>
                                {{$client->client()->first()->type_work}}
                            </td>
                            <td>
                                <strong>
                                    {{$client->client()->first()->unique_code}}
                                </strong>
                            </td>
                            <td>
                                {{$client->client()->first()->profession}}
                            </td>
                            <td>
                                {{$client->client()->first()->factory_name}}
                            </td>
                            <td class="no-print" style="width: 177px">
                                <a class="btn btn-success inline"
                                   href="{{ url('/cabinet/center/test/conclusion/'.$client->client_id) }}">Заключение
                                </a>
                                <a class="btn btn-primary inline"
                                   href="{{ url('/cabinet/center/test/'.$client->id) }}"><img
                                            src="{{url("images/replay.png")}}">
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="notification-center">Нет записей</p>
            @endif

            <div class="counter-bottom">Всего пройдено тестов: <strong>{{$tests->count()}}</strong></div>
        </div>
    </div>

@endsection