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
                <button class="btn btn-warning text-gray-600 text-semibold" id="respondBtn" data-email="{{$item->email}}" data-phone="{{$item->phone}}" >Respond</button>
            </td>
        </tr>
      @endforeach
  </tbody>
</table>

<div class="modal fade" id="respondModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Respond to Enquiry</h5>
                <button  type="button" class="btn-close" data-bs-dismiss="modal" ></button>
            </div>

            <div class="modal-body">

              <div x-data="{ copied: false }">
                <div class="flex items-center space-x-2">
                  <!-- Input -->
                  <input type="text" x-model="text"  x-ref="email" id="email" class="border rounded px-2 py-1 w-64">

                  <!-- Copy Button -->
                  <button 
                    @click="navigator.clipboard.writeText($refs.email.value).then(() => { copied = true; setTimeout(() => copied = false, 2000); })" 
                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                  >
                    Copy
                  </button>
                </div>

                <!-- Message -->
                <p x-show="copied" x-transition class="text-green-600 text-sm">
                  ✅ Copied successfully!
                </p>
              </div>

              <div x-data="{ copied: false }">
                  <div class="flex items-center space-x-2">
                    <!-- Input -->
                    <input type="text" x-model="text"  x-ref="phone" id="phone" class="border rounded px-2 py-1 w-64">

                    <!-- Copy Button -->
                    <button 
                      @click="navigator.clipboard.writeText($refs.phone.value).then(() => { copied = true; setTimeout(() => copied = false, 2000); })" 
                      class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                    >
                      Copy
                    </button>
                  </div>

                  <!-- Message -->
                  <p x-show="copied" x-transition class="text-green-600 text-sm">
                    ✅ Copied successfully!
                  </p>
                </div>

            </div>
            <div class="modal-footer">
                <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $('#respondBtn').click(function() {
      var email = $(this).data('email');
      var phone = $(this).data('phone');
      $('#email').val(email);
      $('#phone').val(phone);
      $('#respondModal').modal('show');
    });
  }); 
</script>
    
@endsection

