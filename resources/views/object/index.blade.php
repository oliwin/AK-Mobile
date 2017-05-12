@extends('index')
@section('content')
@include('common.search')
@include('common.action_buttons')
<h4>Objects</h4>
@if(count($objects))
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
      @foreach ($objects as $index => $object)
      <tr>
         <td>{{ $object->id }}</td>
         <td>{{ $object->name}}</td>
         <td>{{ $object->prefix }}</td>
         <td>@if(!is_null($object->prototypes)) {{$object->prototypes->name}} @else - @endif</td>
         <td>@if($object->available == "1") <span class="active">Available</span> @else <span class="completed">Not Available</span> @endif</td>
         <td>
            <a class="label label-primary" href="objects/{{$object->id}}/edit">Edit</a>
            <form action="{{ URL::route('objects.destroy', $object->id) }}" method="POST">
               <input type="hidden" name="_method" value="DELETE">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <button class="delete label label-danger">Delete</button>
            </form>
            <a class="label label-warning" href="{{url("objects/".$object->id."/clone")}}">Clone</a>
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
@else
<p class="notification-center">There are not rows</p>
@endif
{!!$objects->render()!!}
@endsection
