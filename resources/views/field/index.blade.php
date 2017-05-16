@extends('index')
@section('content')
@include('common.search')
@include('common.action_buttons')
<h4>Parameters</h4>
@if(count($fields))
<table class="table">
   <thead>
      <tr>
         <th>Id</th>
         <th>Name</th>
         <th>Prefix</th>
         <th>Prototype</th>
         <th>Status</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      @foreach ($fields as $index => $field)
      <tr>
         <th>{{ $field->id }}</th>
         <td>{{ $field->name}}</td>
         <td>
            {{ $field->prefix }}
            <div class="multi_field">@if($field->type == 1) Multi @endif</div>
         </td>
         <td>@if($field->prototype->count() > 0)
            {{$field->prototype->pluck("name", "id")->implode('name', ', ')}}
            @else - @endif
         </td>
         <td>@if($field->available == "1") <span class="active">Available</span> @else <span class="completed">Not Available</span> @endif</td>
         <td>
            <a class="label label-info" href="fields/{{$field->id}}/edit">Edit</a>
            <form action="{{ URL::route('fields.destroy', $field->id) }}" method="POST">
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
{!!$fields->render()!!}
@endsection
