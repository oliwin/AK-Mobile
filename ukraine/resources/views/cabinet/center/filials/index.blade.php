@extends('cabinet.center.index')

@section('content_right_block')

    @include("cabinet.center.common.modal-message")
    @include("cabinet.center.common.print")

    <div class="row">
        <div class="col-md-12">

            @if(count($filials))

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
                            Название
                        </th>
                        <th>
                            Город
                        </th>
                        <th>
                            Адрес
                        </th>
                        <th>
                            IPN/биллинг
                        </th>
                        <th>
                            Телефон
                        </th>

                        <th class="no-print">
                            Действие
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($filials as $index => $client)
                        <tr class="no-print" id="result_{{$client->id}}">
                            <td class="no-print">
                                <input type="checkbox" class="check" name="item[{{$client->id}}]"
                                       value="{{$client->id}}">
                            </td>
                            <td>
                                {{$client->id}}
                            </td>

                            <td>
                                {{$client->created_at->format("d.m.Y")}}
                            </td>

                            <td>
                                {{$client->name}} ({{$client->payer}})
                            </td>
                            <td>
                                {{$client->city}}
                            </td>
                            <td>
                                {{$client->address}}
                            </td>
                            <td>
                                {{$client->IPN}} / {{$client->bill}}
                            </td>
                            <td>
                                {{$client->phone}}
                            </td>
                            <td class="no-print">
                                <a class="btn btn-primary"
                                   href="{{ url('/cabinet/center/test/'.$client->id) }}">Детально</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="notification-center">Нет записей</p>
        @endif

        <!--<div class="counter-bottom">Всего тестируемых: <strong>{{$filials->count()}}</strong></div>-->
        </div>
    </div>

@endsection