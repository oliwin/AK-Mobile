@extends('home')

@section('content_right_block')

    <!-- If registered -->
    @if (session('unique_code'))
        <div class="registered-unique-code-client">
            <p>Новый тестируемый - зарегистрирован! Уникальный код:</p>
            <div class="unique_code">{{ session('unique_code') }}</div>
            <a class="btn btn-danger" href="{{ url('/cabinet/test') }}">Новая анкета</a>
            <a class="btn btn-default" href="{{ url('/cabinet/statistic') }}">Список тестрируемых</a>
        </div>
    @else
        <!-- End -->
            <div class="row">
                <div class="col-md-8">

                    <h4>Регистрационная форма</h4>

                    <?=Form::open(array('route' => 'test.store', 'novalidate' => "novalidate", 'method' => 'post'))?>

                        <div class="form-group">
                            <label>
                                Идентификационный код
                            </label>
                            <div class="form-inline">
                                {!! Form::text('code', null, ['class' => 'form-control', 'id' => "IDN", 'maxlength' => 10, 'minlength' => 10, 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                Фамилия
                            </label>
                            {!! Form::text('secondname', null, ['class' => 'form-control', 'id' => 'secondname', 'required' => 'required']) !!}
                        </div>

                    <div class="form-group">
                        <label>
                            Имя
                        </label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => "name", 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        <label>
                            Отчество
                        </label>
                        {!! Form::text('patronymic', null, ['class' => 'form-control', 'id' => 'patronymic', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        <label>
                            Дата рождения
                        </label>
                        <div class="form-inline">
                            <div class="form-group">
                                <select id="selectDate" name="day" style="width:auto;" class="form-control selectWidth">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option class="">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                {{ Form::selectMonth('month', 7, ['class' => 'form-control', 'id' => 'month']) }}
                            </div>
                            <div class="form-group">
                                {!! Form::selectRange('year', 1900, date("Y"), 1960, ["class" => 'form-control', 'id' => 'year']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            Пол
                        </label><br>
                        <label class="radio-inline">
                            <input type="radio" id="male" name="sex" value="1" <?=(old('sex') == "1") ? "checked" : "";?> />
                            Мужской
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="female" name="sex" value="2" <?=(old('sex') == "2") ? "checked" : "";?>/>
                            Женский
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Профессия
                        </label>
                        {!! Form::text('profession', null, ['class' => 'form-control', 'id' => 'profession', 'required' => 'required']) !!}
                    </div>

                        <div class="form-group">
                            <label>
                                Вид работ
                            </label>
                            <?=Form::select('type_work[]', $work_types, null, ['multiple' => "multiple", 'id' => 'type_work', "class" => "selectpicker form-control"]);?>
                        </div>

                    <div class="form-group">
                        <label>
                            Адрес центрального офиса
                        </label>
                        {!! Form::text('address_office', null, ['class' => 'form-control', 'id' => 'address_office', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        <label>
                            Наименование предприятия
                        </label>
                        {!! Form::text('factory_name', null, ['id' => 'factory_name', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>


                    <div class="form-group">
                        <label>
                            Код ЕДРПОУ предприятия
                        </label>
                        {!! Form::text('factory_edrpou', null, ['id' => 'factory_edrpou', 'class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label>
                            Цех
                        </label>
                        {!! Form::text('factory_departament', null, ['id' => 'factory_departament', 'class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label>
                            Статус прохождения
                        </label>
                        <?=Form::select('status_pass', [1 => "Первый раз", 2 => "Повторно"], old('status_pass') ? old('status_pass') : 1, ['id' => 'status_pass', "placeholder" => "Выбрать...", "class" => "form-control"]);?>
                        <a class="details-link" target="_blank" href="{{ url('/cabinet/statistic') }}">Просмотреть
                            историю</a>
                    </div>

                    <div class="form-group">
                        <label>
                            Оплата
                        </label>
                        <?=Form::select('payment_type', [1 => "Платно", 2 => "Бесплатно"], old('payment_type') ? old('payment_type') : 1, ['id' => 'payment', "placeholder" => "Выбрать...", "class" => "form-control"]);?>
                    </div>

                    {{ Form::submit('Зарегистрировать', ['class' => 'btn btn-success']) }}
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4">
                    <a href="{{ URL::previous() }}" class="btn btn-success back-link">Назад</a>
                </div>
            </div>
    @endif

@endsection