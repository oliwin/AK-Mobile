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
         <th>Category</th>
         <th>Prototype</th>
         <th>Status</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      @foreach ($objects as $index => $object)
      <tr>
         <td><strong>{{ $object['_id'] }}</strong></td>
         <td>{{ $object['name']}}</td>
         <td>{{\App\Helpers\Helper::inArray($object['category_id'], $categories)}}</td>
         <td>{{\App\Helpers\Helper::inArray($object['prototype_id'], $prototypes)}}</td>
         <td>@if($object['available'] == "1") <span class="active">Available</span> @else <span class="completed">Not Available</span> @endif</td>
         <td>
            <a class="label label-info" href="objects/{{$object['_id']}}/edit">Edit</a>
            <form action="{{ URL::route('objects.destroy', $object['_id']) }}" method="POST">
               <input type="hidden" name="_method" value="DELETE">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <button class="delete label label-danger">Delete</button>
            </form>
            <a class="label label-warning" href="{{url("objects/".$object['_id']."/clone")}}">Clone</a>
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
@else
<p class="notification-center">There are not rows</p>
@endif
@endsection
