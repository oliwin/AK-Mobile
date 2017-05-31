@extends('home')

@section('content_right_block')
        <div class="row">

            <div class="col-md-10">

                <h4>Регистрационная форма</h4>

                <?=Form::open(array('url' => 'cabinet/test/file/load', 'novalidate' => "novalidate", 'method' => 'post', 'files' => true))?>

                <div class="form-group">
                    <p>Для загрузки результатов и отпраки их на обработку, выберите файл тестов</p>
                    {!! Form::file('file[]', []) !!}
                </div>

                {{ Form::submit('Отправить', ['class' => 'btn btn-success']) }}
                {!! Form::close() !!}
            </div>

            <div class="col-md-2">
                <a href="{{ URL::previous() }}" class="btn btn-success back-link">Назад</a>
            </div>

        </div>

@endsection