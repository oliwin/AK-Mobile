@extends('cabinet.center.index')

@section('content_right_block')

    <div class="col-sm-12">

    <h4>Протокол № {{$test->id}}</h4>

    <a href="{{ URL::previous() }}" class="btn btn-success back-link">Назад</a>
    <div style="float: right; margin-right: 10px" onclick="return print();" class="btn btn-primary">Печать</div>

        <div class="type-conclusion">Вид робіт: {{$types[$test->type_work]}}</div>
        <div class="personal-conclusion">
        <table class="table table-condensed table-responsive">
            <thead>
            <tr>
                <th>
                    ФИО
                </th>
                <th>
                    Дата рождения
                </th>
                <th>
                    Ідентифікаційний код
                </th>

                <th>
                    Код ЄДРПОУ
                </th>

                <th>
                    Профессия
                </th>

                <th>
                    Место работы
                </th>

            </tr>
            </thead>
            <tbody>

            <tr>
                <td>
                    {{$test->client()->first()->name}} {{$test->client()->first()->secondname}} {{$test->client()->first()->patronymic}}
                </td>
                <td>

                    {{$test->client()->first()->datebirth}}
                </td>
                <td>
                    <strong>{{$test->client()->first()->unique_code}}</strong>
                </td>
                <td>
                    {{$test->client()->first()->factory_edrpou}}
                </td>
                <td>
                    {{$test->client()->first()->profession}}
                </td>
                <td>
                    {{$test->client()->first()->factory_name}}
                </td>
            </tr>
            </tbody>
        </table>
            </div>


        <table style="margin-top: 40px; margin-bottom: 40px" class="table table-hover table-condensed table-responsive">
            <thead>
            <tr>
                <th>
                    Досліджені професійно важливі психофізіологічні якості
                </th>
                <th>
                    Оцінка
                </th>
                <th>
                    Примітка
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($O as $k => $v)
                <tr>
                    <td>
                        {{$k}}
                    </td>
                    <td>
                        {{sprintf("%01.2f", $v)}}
                    </td>
                    <td>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class="table table-condensed table-responsive">
            <tr>
                <th>Чутливий</th>
                <td>0</td>
            </tr>
            <tr>
                <th>Дистимічний</th>
                <td>0</td>
            </tr>
            <tr>
                <th>Демонстративний</th>
                <td>0</td>
            </tr>
            <tr>
                <th>Збудливий</th>
                <td>0</td>
            </tr>
            <tr>
                <th>Що застряє
                </th>
                <td>0</td>
            </tr>
            <tr>
                <th>Педантичний

                </th>
                <td>0</td>
            </tr>
            <tr>
                <th>Замкнутий


                </th>
                <td>0</td>
            </tr>
            <tr>
                <th>Гіпертимний


                </th>
                <td>0</td>
            </tr>
        </table>

        <div class="conclusion-table">
            <table class="table table-condensed table-responsive">
                <thead>
                <tr>
                    <th>
                        Загальна оцінка
                    </th>
                    <th>
                        Група ПФО
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        {{substr($test->Z, 0, 6)}}
                    </td>
                    <td>
                        {{$test->category}}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="conclusion">
            <h4>Заключение:</h4>
            <p>
                <div>Тип работ: {{$conclusion->type_work}}</div>
            <div>Категория: {{$conclusion->category}}</div>
             {{$conclusion->conclusion}}
            </p>
        </div>
    </div>

    <!--<p>Аналітична обробка показників та перевірка проведеного Регіональним Відділом ПФЕ психофізіологічного
        обстеження здійснена Центром психофізіологічної експертизи працівників для виконання робіт підвищеної
        небезпеки ТОВ "Експертно-навчальний центр"</p>-->

@endsection