@extends('home')

@section('content_right_block')

    @include("cabinet.distributor.common.modal-message")


    <div class="graph-filter row">

     <div class="col-md-12">
             <a href="{{url('cabinet/administration/doctors/create')}}" class="btn btn-success">Зарегистрировать врача</a>

     </div>
 </div>

          @if(count($doctors))


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
                          Дата регистрации

                        </th>
                        <th>
                            ФИО
                        </th>
                        <th>
                            Регион
                        </th>

                        <th>
                            Логин/Пароль
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
                                <input type="checkbox" class="check" name="item[{{$doctor->user_id}}]"
                                       value="{{$doctor->user_id}}">
                            </td>
                            <td>
                                {{$doctor->user_id}}
                            </td>
                            <td>

                                {{$doctor->created_at->format("d/m/y h:m")}}

                            </td>
                            <td>

                                {{$doctor->name}}
                            </td>
                            <td>
                                {{$doctor->region->name}}
                            </td>

                            <td>

                                <strong>{{$doctor->details->email}} / {{$doctor->password}}</strong>
                            </td>
                            <td>
                                  {{$doctor->phone}}
                            </td>
                            <td>
                                  {{$doctor->email}}
                            </td>


                            <td class="no-print">
                              {{ Form::open(['url' => ['cabinet/administration/doctors', $doctor->user_id], 'method' => 'delete']) }}
                                <button class="btn btn-default" type="submit">Удалить</button>
                              {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


        <div class="counter-bottom">Всего: <strong>{{$doctors->count()}}</strong></div>
        </div>

    </div>

    @else
        <p class="notification-center">Нет записей</p>
@endif

@endsection
