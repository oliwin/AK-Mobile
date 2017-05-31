@extends('home')

@section('content_right_block')

    <div class="row">

        <div class="col-md-8">

            <h4>Редактирование анкеты тестируемого</h4>

            {{ Form::model($client, array('route' => array('test.update', $client->id), 'method' => 'PUT')) }}

            <div class="form-group">
                <label>
                    Имя
                </label>
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Фамилия
                </label>
                {!! Form::text('secondname', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Отчество
                </label>
                {!! Form::text('patronymic', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Дата рождения
                </label>
                <div class="input-group date" id="datetimepicker">
                    {!! Form::text('datebirth', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                </div>
            </div>

            <div class="form-group">
                <label>
                    Пол
                </label><br>
                <label class="radio-inline">
                    <input type="radio" name="sex"
                           value="1" <?=(old('sex') == "1" || $client->sex == "1") ? "checked" : "";?> /> Мужской
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex"
                           value="2" <?=(old('sex') == "2" || $client->sex == "2") ? "checked" : "";?>/> Женский
                </label>
            </div>

            <div class="form-group">
                <label>
                    Профессия
                </label>
                {!! Form::text('profession', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Идентификационный код
                </label>
                {!! Form::text('code', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Адрес центрального офиса
                </label>
                {!! Form::text('address_office', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Вид работ
                </label>
                <?=Form::select('type_work[]', $typeWorks, null, ['multiple' => "multiple", 'id' => 'type_work', "class" => "selectpicker form-control"]);?>
            </div>

            <div class="form-group">
                <label>
                    Наименование предприятия
                </label>
                {!! Form::text('factory_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>


            <div class="form-group">
                <label>
                    Код ЕДРПОУ предприятия
                </label>
                {!! Form::text('factory_edrpou', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Цех
                </label>
                {!! Form::text('factory_departament', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Статус прохождения
                </label>
                <?=Form::select('status_pass', [1 => "Первый раз", 2 => "Повторно"], old('payment_type'), ["placeholder" => "Выбрать...", "class" => "form-control"]);?>
                <a class="details-link" target="_blank" href="{{ url('/cabinet/statistic') }}">Просмотреть
                    историю</a>
            </div>

            <div class="form-group">
                <label>
                    Оплата
                </label>
                <?=Form::select('payment_type', [1 => "Платно", 2 => "Бесплатно"], old('payment_type'), ["placeholder" => "Выбрать...", "class" => "form-control"]);?>
            </div>

            {{ Form::submit('Обновить', ['class' => 'btn btn-success']) }}
            {!! Form::close() !!}
        </div>

        <div class="col-md-4">
            <a href="{{ URL::previous() }}" class="btn btn-success back-link">Назад</a>
        </div>

    </div>

@endsection