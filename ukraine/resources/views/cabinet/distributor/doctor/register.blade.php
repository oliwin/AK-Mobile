@extends('home')

@section('content_right_block')
<div class="row">
    <div class="col-md-8">

        <h4>Добавление врача</h4>

         <?=Form::open(array('url' => 'cabinet/administration/doctors', 'method' => 'post'))?>



        <div class="input-group">
                <label>
                    ФИО
                </label>
                <input type="text" name="name[]" placeholder="ФИО" class="form-control" value=""/>
            </div>

            <br>

            <div class="input-group">
              <label>
                  Телефон
              </label>
                <input type="text" name="phone[]" placeholder="Телефон" class="form-control" value=""/>
            </div>

            <br>

            <div class="input-group">
                <label>
                  Email
                </label>
                <input type="email" name="email[]" placeholder="Emil" class="form-control" value=""/>
            </div>

            <br>
            <div class="input-group">
                <label>
                  Пометка
                </label>
                <textarea name="note[]" class="form-control" placeholder="Введите дополнительную информацию"></textarea>
            </div>

            <br>

            <button type="submit" class="btn btn-default">
              Добавить
            </button>
            {!! Form::close() !!}
    </div>
</div>

@endsection
