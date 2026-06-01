@extends('layouts.auth')

@section('title', 'Enquiries')

@section('content')

<h1 class="text-3xl font-semibold text-indigo-500">Enquiries</h1>
<table class="table my-3">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Property Refrence</th>
      <th scope="col">Message</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($enquiries as $index => $item)
        <tr>
            <th scope="row">{{$index + 1}}</th>
            <td>{{$item->name}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->phone}}</td>
            <td>{{$item->property['title']}}</td>
            <td>{{$item->message}}</td>
            <td>
                <button class="btn btn-warning text-gray-600 text-semibold" id="respondBtn">Respond</button>
            </td>
        </tr>
      @endforeach
  </tbody>
</table>
    
@endsection

