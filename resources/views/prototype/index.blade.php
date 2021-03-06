@extends('index')
@section('content')
@include('common.search')
@include('common.action_buttons')
<h4>Prototypes</h4>
@if(count($prototypes))
<table class="table">
   <thead>
      <tr>
         <th>Id</th>
         <th>Name</th>
         <th>Prefix</th>
         <th>Status</th>
         <th>Action</th>
         <th>Objects</th>
      </tr>
   </thead>
   <tbody>
      @foreach ($prototypes as $index => $prototype)
      <tr>
         <th>{{ $prototype->id }}</th>
         <td>{{ $prototype->name}}</td>
         <td>{{ $prototype->prefix }}</td>
         <td>@if($prototype->available == "1") <span class="active">Available</span> @else <span class="completed">Not Available</span> @endif</td>
         <td>
            <a class="label label-info" href="prototypes/{{$prototype->id}}/edit">Edit</a>
            <form action="{{ URL::route('prototypes.destroy', $prototype->id) }}" method="POST">
               <input type="hidden" name="_method" value="DELETE">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <button class="delete label label-danger">Delete</button>
            </form>
         </td>
         <td>
            <a class="label label-warning" href=" prototypes/{{$prototype->id}}/objects">Show</a>
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
@else
<p class="notification-center">There are not rows</p>
@endif
{!!$prototypes->render()!!}
@endsection
