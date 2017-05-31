@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Общие данные о представителе</legend>

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Название</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" maxlength="100"
                                               value="{{ old('name') }}" autofocus>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('payer') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Плательщик (название)</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="payer" maxlength="200"
                                               value="{{ old('payer') }}" autofocus>

                                        @if ($errors->has('payer'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('payer') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Регион</label>

                                    <div class="col-md-6">

                                        {!! Form::select('region', array('0' => '', '1' => 'Киевский', '2' => 'Одесский', '3' => 'Винницкий'), [], ["class" => "form-control"]) !!}

                                        @if ($errors->has('region'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('region') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('post_index') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Почтовый индекс</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="post_index" maxlength="5"
                                               value="{{ old('post_index') }}" autofocus>


                                        @if ($errors->has('post_index'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('post_index') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Город</label>

                                    <div class="col-md-6">

                                        {!! Form::select('city', array('0' => '', '1' => 'Киев', '2' => 'Одесса', '3' => 'Винница'), [], ["class" => "form-control"]) !!}

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('city') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Адрес</label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="address" maxlength="50"
                                               value="{{ old('address') }}" autofocus>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('address') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Телефон</label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" maxlength="15" name="phone"
                                               value="{{ old('phone') }}" autofocus>

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('phone') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email_work') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Рабочий E-mail</label>

                                    <div class="col-md-6">

                                        <input type="email" class="form-control" maxlength="50" name="email_work"
                                               value="{{ old('email_work') }}" autofocus>

                                        @if ($errors->has('email_work'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('email_work') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email_addly') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Дополнительный E-mail</label>

                                    <div class="col-md-6">

                                        <input type="email" class="form-control" maxlength="50" name="email_addly"
                                               value="{{ old('email_addly') }}" autofocus>

                                        @if ($errors->has('email_addly'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('email_addly') }}</strong>
                                     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('charter') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Устав</label>

                                    <div class="col-md-6">
                                        <textarea name="charter" id="charter" class="form-control"
                                                  rows="5">{{old('charter')}}</textarea>

                                        @if ($errors->has('charter'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('charter') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Платежные данные</legend>

                                <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Банк</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="bank" maxlength="50"
                                               value="{{ old('bank') }}" autofocus>

                                        @if ($errors->has('bank'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('bill') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Расчетный счет</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" maxlength="50" class="form-control" name="bill"
                                               value="{{ old('bill') }}" autofocus>

                                        @if ($errors->has('bill'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('bill') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('mfo') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">МФО</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50" name="mfo"
                                               value="{{ old('mfo') }}" autofocus>

                                        @if ($errors->has('mfo'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('mfo') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('ipn') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">ИПН</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50" name="ipn"
                                               value="{{ old('ipn') }}" autofocus>

                                        @if ($errors->has('ipn'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('ipn') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('tax_type') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Вид налогообложения</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50" name="tax_type"
                                               value="{{ old('tax_type') }}" autofocus>

                                        @if ($errors->has('tax_type'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('tax_type') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('nps') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">НПС</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50" name="nps"
                                               value="{{ old('nps') }}" autofocus>

                                        @if ($errors->has('nps'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('nps') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('egr') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">ЕГР</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50" name="egr"
                                               value="{{ old('egr') }}" autofocus>

                                        @if ($errors->has('egr'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('egr') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">О руководителе</legend>

                                <div class="form-group{{ $errors->has('fio_manager') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">ФИО руководителя</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="fio_manager" maxlength="50"
                                               value="{{ old('fio_manager') }}" autofocus>

                                        @if ($errors->has('fio_manager'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('fio_manager') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('job_position_manager') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Должность</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50"
                                               name="job_position_manager" value="{{ old('job_position_manager') }}"
                                               autofocus>

                                        @if ($errors->has('job_position_manager'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('job_position_manager') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone_manager') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Контактный телефон</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="15"
                                               name="phone_manager" value="{{ old('phone_manager') }}" autofocus>

                                        @if ($errors->has('phone_manager'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('phone_manager') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                          <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Бухгалтер</legend>

                                <div class="form-group{{ $errors->has('accountant') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">ФИО</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" maxlength="50" name="accountant"
                                               maxlength="50" value="{{ old('accountant') }}" autofocus>

                                        @if ($errors->has('accountant'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('accountant') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('accountant_phone') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Телефон</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="15"
                                               name="accountant_phone" value="{{ old('accountant_phone') }}" autofocus>

                                        @if ($errors->has('accountant_phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('accountant_phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>


                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Инструктор</legend>

                                <div class="form-group{{ $errors->has('instructor') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">ФИО</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="instructor" maxlength="50"
                                               value="{{ old('instructor') }}" autofocus>

                                        @if ($errors->has('instructor'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('instructor') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('instructor_phone') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Телефон</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="instructor_phone" maxlength="15"
                                               value="{{ old('instructor_phone') }}" autofocus>

                                        @if ($errors->has('instructor_phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('instructor_phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Доктор</legend>

                                <div class="form-group{{ $errors->has('doctor') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">ФИО</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="doctor" maxlength="50"
                                               value="{{ old('doctor') }}" autofocus>

                                        @if ($errors->has('doctor'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('doctor') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('doctor_phone') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Телефон</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="15"
                                               name="doctor_phone" value="{{ old('doctor_phone') }}" autofocus>

                                        @if ($errors->has('doctor_phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('doctor_phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('doctor_diplom') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Диплом ВУЗ</label>

                                    <div class="col-md-6">

                                        <textarea name="doctor_diplom" id="doctor_diplom" class="form-control"
                                                  rows="5">{{old('doctor_diplom')}}</textarea>


                                        @if ($errors->has('doctor_diplom'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('doctor_diplom') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('doctor_courses') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Курсы</label>

                                    <div class="col-md-6">

                                        <textarea name="doctor_courses" id="doctor_courses" class="form-control"
                                                  rows="5">{{old('doctor_courses')}}</textarea>


                                        @if ($errors->has('doctor_courses'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('doctor_courses') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('licence') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Номер лицензии</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" maxlength="50" name="licence"
                                               value="{{ old('licence') }}" autofocus>

                                        @if ($errors->has('licence'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('licence') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Данные входа</legend>


                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
         <strong>{{ $errors->first('email') }}</strong>
     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Пароль</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
         <strong>{{ $errors->first('password') }}</strong>
     </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="col-md-4 control-label">Повтор пароля</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation">

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
         <strong>{{ $errors->first('password_confirmation') }}</strong>
     </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Зарегистрировать
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
