@extends('home')

@section('content_right_block')

    <h4>Редактирование категории</h4>

    <div class="row registered-clients">
        {{ Form::open(array('url' => 'cabinet/category/update')) }}
            <div class="col-md-12">
                <div class="input-group">
                    <label>
                       Категория
                    </label>
                    {{ Form::selectRange('category', 1, 6, null,  array("class" => "form-control")) }}
                </div>
                <br>
                <div class="input-group">
                    {{ Form::submit("Сохранить", array("class" => "btn btn-success")) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection