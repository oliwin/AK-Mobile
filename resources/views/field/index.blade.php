@extends('index')

@section('content')

@include('common.search')

@include('common.action_buttons')

<h4>Prototype Fields</h4>

    @if(count($fields))

        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Prefix</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($fields as $index => $field)

                <tr>
                    <th scope="row">{{ $field->id }}</th>
                    <td>{{ $field->name}}</td>
                    <td>{{ $field->prefix }}</td>
                    <td>@if($field->available == "1") <span class="active">Available</span> @else <span class="completed">Not Available</span> @endif</td>
                    <td><a class="btn btn-primary" href="fields/{{$field->id}}/edit">Edit</a>

                      <form action="{{ URL::route('fields.destroy', $field->id) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-primary">Delete</button>
                    </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @else
        <p class="notification-center">There are not rows</p>
    @endif

    {!!$fields->render()!!}

@endsection
