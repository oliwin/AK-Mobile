@extends('app')
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



@foreach ($restaurants as $user)
    <p>This is user {{ $user->idRestaurant }}</p>
@endforeach


    ID: {{ $id }} Password: {{ $password }}


<div>
	{!! Form::open(array('url' => route('restaurants.store'))) !!}
			<div>
				<?=Form::text('idRestaurant', null, array('placeholder'=>'Code of restaurant' ))?>
			</div>
			<div>
				<?=Form::submit('Register')?>
			</div>
	{!! Form::close() !!}
</div>

@endsection