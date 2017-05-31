@extends('home')

@section('content_right_block')

        <div class="row">
            <div class="col-md-8">

                <h4>Контакты</h4>

                {!! Form::model($contacts, [
                  'method' => 'PUT',
                  'action' => array('Cabinet\ContactController@update', $id)
              ]) !!}


                <div class="input-group">
                        <label>
                            Техническая поддержка
                        </label>
                        <input type="text" name="phone[]" placeholder="Телефон" class="form-control" value="{{$contacts->phone[0] or ""}}"/>
                    </div>

                    <br>

                    <div class="input-group">
                        <input type="text" name="email[]" placeholder="Email" class="form-control" value="{{$contacts->email[0] or ""}}"/>
                    </div>

                    <br>

                    <div class="input-group">
                        <label>
                            Финансовые вопросы
                        </label>
                        <input type="text" name="phone[]" placeholder="Телефон" class="form-control" value="{{$contacts->phone[1] or ""}}"/>
                    </div>

                    <br>

                    <div class="input-group">
                        <input type="text" name="email[]" placeholder="Email" class="form-control" value="{{$contacts->email[1] or ""}}"/>
                    </div>

                    <br>

                    <div class="input-group">
                        <label>
                            Организационные вопросы
                        </label>
                        <input type="text" name="phone[]" placeholder="Телефон" class="form-control" value="{{$contacts->phone[2] or ""}}"/>
                    </div>

                    <br>

                    <div class="input-group">
                        <input type="text" name="email[]" placeholder="Email" class="form-control" value="{{$contacts->email[2] or ""}}"/>
                    </div>

                    <br>

                    <button type="submit" class="btn btn-default">
                        Обновить
                    </button>
                    {!! Form::close() !!}
            </div>
        </div>

@endsection