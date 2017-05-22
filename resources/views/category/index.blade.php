@extends('index')
@section('content')
    <h4>Categories</h4>

    <div id="actions-block">
        <a class="btn btn-success" href="{{url("categories/create")}}">Create +</a>
    </div>

    @if(count($categories))
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $index => $field)
                <tr>
                    <th>{{ $field['_id'] }}</th>
                    <td>{{ $field['name']}}</td>
                    <td>
                        <a class="label label-info" href="categories/{{$field['_id']}}/edit">Edit</a>
                        <form action="{{ URL::route('categories.destroy', $field['_id']) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="delete label label-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="notification-center">There are not rows</p>
    @endif
@endsection
