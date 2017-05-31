@extends('home')

@section('content_right_block')
        <div class="row">
            <div class="col-md-8"><h4>Загрузка результата</h4></div>
            <div class="col-md-8">
                <?=Form::open(array('route' => 'test.store', 'novalidate' => "novalidate", 'method' => 'post', 'files' => true))?>

                <div class="form-group">
                    <p>Для загрузки результатов и отпраки их на обработку, выберите файл тестов</p>
                    {!! Form::file('file', []) !!}
                </div>

                {{ Form::submit('Отправить', ['class' => 'btn btn-success']) }}
                {!! Form::close() !!}
            </div>
        </div>
@endsection