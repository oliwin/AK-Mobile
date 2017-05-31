<!--@extends('app')
@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif


            <a href="{{ URL::to('logout') }}">Logout</a>


<div>
	{{ Form::open(array('url' => 'login')) }}
            <div>
                <?=Form::text('idRestaurant', null, array('placeholder'=>'Code of restaurant' ))?>
            </div>
			<div>
				<?=Form::text('password', null, array('placeholder'=>'Password' ))?>
            </div>
            <div>
                <?=Form::submit('Login')?>
            </div>
    {!! Form::close() !!}
            </div>

            @endsection
        -->