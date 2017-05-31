@extends('home')

@section('content_right_block')

    <div class="row">

        <div class="col-md-11">

            <h4>Данные регионального предриятия</h4>

            {{ Form::model($data, array('route' => array('update.administration', $data->id), 'method' => 'PUT')) }}

            <div class="form-group">
              <div class="col-md-4">
                <label>
                    Номер рег.предприятия
                </label>
                {!! Form::text('number', $data->id, ['class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) !!}

              </div>

              <div class="col-md-4">
                <label>
                    Номер договора
                </label>
                {!! Form::text('agreement', $data->agreement_number, ['class' => 'form-control', 'required' => '', 'disabled' => 'disabled']) !!}

              </div>

              <div class="col-md-4">
                <label>
                    Дата договора
                </label>
                {!! Form::text('agreement_date', $data->agreement_date, ['class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) !!}

              </div>

            </div>

            <div class="clearfix"></div>


            <div class="form-group">
                <label>
                    Код НДРПО
                </label>
                    {!! Form::text('edrpo', $data->edrpo, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>



            <div class="form-group">
                <label>
                    Название центра
                </label>
                {!! Form::text('name', $data->name, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Краткое название предприятия
                </label>
                {!! Form::text('short_name', $data->short_name, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>


            <div class="form-group">
                <div><label>
                    Юридический адрес
                </label></div>
                <div class="col-md-3">
                    {!! Form::text('address[index]', $data->index, ['class' => 'form-control', 'placeholder' => "Индекс", 'required' => 'required']) !!}
                  </div>

                  <div class="col-md-3">
                      {!! Form::text('address[region]',  $data->region, ['class' => 'form-control', 'placeholder' => "Область", 'required' => 'required']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::text('address[city]', $data->city, ['class' => 'form-control', 'placeholder' => "Город", 'required' => 'required']) !!}
                      </div>
                      <div class="col-md-3">
                          {!! Form::text('address[address]', $data->address, ['class' => 'form-control', 'placeholder' => "Улица, дом", 'required' => 'required']) !!}
                        </div>
            </div>

            <div class="form-group">
                <div><label>
                    Почтовый адрес
                </label></div>
                <div class="col-md-3">
                    {!! Form::text('address_p[index]', $data->post_index_p, ['class' => 'form-control', 'placeholder' => "Индекс", 'required' => 'required']) !!}
                  </div>

                  <div class="col-md-3">
                      {!! Form::text('address_p[region]', $data->region_p, ['class' => 'form-control', 'placeholder' => "Область", 'required' => 'required']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::text('address_p[city]', $data->city_p, ['class' => 'form-control', 'placeholder' => "Город", 'required' => 'required']) !!}
                      </div>
                      <div class="col-md-3">
                          {!! Form::text('address_p[address]', $data->address_p, ['class' => 'form-control', 'placeholder' => "Улица, дом", 'required' => 'required']) !!}
                        </div>
            </div>


            <div class="form-group">

                <div><label>
                    ФИО руководителя
                </label>
                    {!! Form::text('manager[name]', $data->fio_manager, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                  <div class="row">
                <div class="col-md-6"><label>
                  Email
                </label>
                    {!! Form::text('manager[email]',   $data->email_manager, ['class' => 'form-control', 'required' => 'required']) !!}
                  </div>
                  <div class="col-md-6"><label>
                    Телефон
                  </label>
                      {!! Form::text('manager[phone]',  $data->phone_manager, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                  </div>

                  <div class="row">

                    <div class="col-md-6"><label>
                      Должность
                    </label>
                        {!! Form::text('manager[job_position]',   $data->manager_job_position, ['class' => 'form-control', 'required' => 'required']) !!}
                      </div>
                      <div class="col-md-6"><label>
                        На основании
                      </label>
                          {!! Form::text('manager[job_agreement]',  $data->manager_job_agreement, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>

                  </div>

            </div>






            <div class="form-group">
                  <div><label>
                    ФИО врача
                </label>
                    {!! Form::text('doctor[name]', $data->doctor_name, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
                <div class="col-md-6"><label>
                  Email
                </label>
                    {!! Form::text('doctor[email]', $data->doctor_email, ['class' => 'form-control', 'required' => 'required']) !!}
                  </div>
                  <div class="col-md-6"><label>
                    Телефон
                  </label>
                      {!! Form::text('doctor[phone]', $data->doctor_phone, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
            </div>


            <div class="form-group">

                <div><label>
                    ФИО инструктора
                </label>
                    {!! Form::text('instructor[name]', $data->instructor_name, ['class' => 'form-control', 'required' => 'required']) !!}
          </div>


                <div class="col-md-6"><label>
                  Email
                </label>
                    {!! Form::text('instructor[email]', $data->instructor_email, ['class' => 'form-control', 'required' => 'required']) !!}
                  </div>
                  <div class="col-md-6"><label>
                    Телефон
                  </label>
                      {!! Form::text('instructor[phone]', $data->instructor_phone, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
            </div>



                        <div class="form-group">

                            <div><label>
                                ФИО бухгалтера
                            </label>
                                {!! Form::text('accounter[name]', $data->accounter_name, ['class' => 'form-control', 'required' => 'required']) !!}
                      </div>


                            <div class="col-md-6"><label>
                              Email
                            </label>
                                {!! Form::text('accounter[email]', $data->accounter_email, ['class' => 'form-control', 'required' => 'required']) !!}
                              </div>
                              <div class="col-md-6"><label>
                                Телефон
                              </label>
                                  {!! Form::text('accounter[phone]', $data->accountant_phone, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                        </div>



            <div class="form-group">
                <div><label>
                    Форма налогообложения
                </label>
                    {!! Form::text('tax_type', $data->tax_type, ['class' => 'form-control', 'required' => 'required']) !!}
                  </div>

                  <div class="col-md-6">
                    <label>
                    Номер лицензии
                    </label>
                      {!! Form::text('licence[number]', $data->licence, ['class' => 'form-control', 'required' => 'required']) !!}
                  </div>

                  <div class="col-md-6">
                    <label>
                    Номер лицензии
                    </label>
                    {!! Form::text('licence[date]', $data->licence_number, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

            </div>

            <div class="form-group">
                <label>
                    Форма собственности
                </label>
                {!! Form::text('busuness_type', $data->IPN, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>


            <div class="form-group">
                <label>
                    Отправлять результаты тестов на почту
                </label>
                {!! Form::text('email', $data->settings()->first()->email_admin, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                <label>
                    Последняя дата внесения изменений
                </label>
                    {!! Form::text('updated_at', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) !!}
            </div>

            {{ Form::submit('Обновить', ['class' => 'btn btn-success']) }}
            {!! Form::close() !!}
        </div>

        <div class="col-md-1">
            <a href="{{ URL::previous() }}" class="btn btn-success back-link">Назад</a>
        </div>

    </div>

@endsection
