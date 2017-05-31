@extends('home')

@section('content_right_block')

    <h4>Подробности транзакции</h4>


    <a href="{{ URL::previous() }}" class="btn btn-success back-link">Назад</a>
        <div style="float: right; margin-right: 10px" onclick="return print();" class="btn btn-primary">Печать</div>


    <div class="row registered-clients">
        <div class="col-md-12">

            @if(count($transaction) > 0)


                <div class="filter-table-statistic">
                    <div class="col-xs-2" style="width: 70px">ID: <span
                                class="date">{{$transaction->first()->transaction_id}}</span></div>
                    <div class="col-xs-2" style="width: 130px">Заявок: <span
                                class="date">{{$transaction->first()->clients->count()}}</span></div>
                    <div class="col-xs-3">Дата транзакции: <span
                                class="date">{{$transaction->first()->created_at->format("d/m/y h:m")}}</span></div>
                    <div class="col-xs-2" style="width: 250px">Статус:
                        @if($transaction->first()->status == 1)<span
                                class="status yellow btn"> Ожидает ответ</span>@endif

                        @if($transaction->first()->status == 2)<span
                                class="status gray btn"> Получен ответ</span>
                        @endif

                        @if($transaction->first()->status == 3)<span
                                class="status gray btn">Отравлен повторно</span>
                        @endif
                    </div>
                </div>


@if($transaction->first()->clientDetails()->count() > 0)
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
                            ФИО
                        </th>
                        <th>
                            Оценка Z / Категория
                        </th>
                        <th>
                            Статус
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($transaction->first()->clientDetails()->get() as $index => $item)

                        <tr>
                        <td class="no-print">
                            <input type="checkbox" class="check"
                                   value="{{$item->id}}">
                        </td>

                        <td>
                            {{$item->unique_code}}
                        </td>

                            <td>
                                {{$item->created_at->format("d/m/y h:m")}}
                            </td>

                        <td>
                              {{$item->secondname}} {{$item->name}} {{$item->patronymic}}
                        </td>
                        <td>
                            {{ number_format($transaction->first()->results()->get()->first()->Z, 2, '.', '')}} / {{$transaction->first()->results()->get()->first()->category}}
                        </td>
                        <td>
                            @if($item->status == 1)
                                Получен результат
                            @endif

                                @if($item->status == 0)
                                    В рассмотрении
                                @endif
                        </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

                  @endif


            @else
                <p class="notification-center">Нет записей</p>
            @endif

        </div>
    </div>

@endsection
