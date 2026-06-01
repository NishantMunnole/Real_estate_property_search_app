@extends('layouts.auth')

@section('title', 'Proerpties')

@section('content')
    <div class="container-fluid">
        <!-- Button trigger modal -->


        <div class="d-flex justify-content-between align-items-center">
            <h3 class="text-3xl font-semibold text-indigo-500">Properties</h3>
            @if (Auth::user())
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#propertyModal">
                    Add Property
                </button>
            @endif
        </div> 

        <div class="row w-1/3 my-5">
            <input type="email" class="form-control" id="search_key" aria-describedby="emailHelp" placeholder="Search property by city" autocomplete="off" />
        </div>

        <div class="my-5">
            <div id="properties_container">
                <div class="row">
                    @foreach ($properties as $item)
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card mb-3" style="max-width: 100%;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div  class="d-flex justify-content-center align-items-center overflow-hidden bg-light" style="height:180px;" >
                                            <img src="{{ asset('property-images/' . $item->image) }}" class="img-fluid rounded-start" alt="{{$item->image}}">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title text-2xl font-semibold d-flex justify-content-between">
                                            <span>{{ $item->title }}</span>
                                            <span class="text-gray-400">₹{{ round($item->price) }}</span>
                                        </h5>
                                        <p class="card-text">{{ Str::limit($item->description, '100', '...') }}</p>
                                        <p><strong>PROPERTY TYPE: </strong>{{ $item->type['name'] }} | <strong>City:</strong> {{ $item->city}}</p>
                                        @if ($item->updated_at)
                                            <p class="card-text"><small class="text-muted">Updated {{ $item->updated_at->diffForHumans() }}</small></p>
                                        @else
                                            <p class="card-text"><small class="text-muted">Updated {{ $item->created_at->diffForHumans() }}</small></p>
                                        @endif
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-outline-info view_property"
                                                data-id = '{{ $item->id }}'
                                                data-title = '{{ $item->title }}'
                                                data-price = '{{ $item->price }}'
                                                data-city = '{{ $item->city }}'
                                                data-propertyType = '{{ $item->type['id'] }}'
                                                data-description = '{{ rawurlencode($item->description) }}'
                                                data-image='{{ asset('property-images/' . $item->image)}}'>
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            @if (Auth::user())
                                            <button type="button" class="btn btn-outline-success view_edit_button" 
                                                data-id = '{{ $item->id }}'
                                                data-title = '{{ $item->title }}'
                                                data-price = '{{ $item->price }}'
                                                data-city = '{{ $item->city }}'
                                                data-propertyType = '{{ $item->type['id'] }}'
                                                data-description = '{{ rawurlencode($item->description) }}'
                                                data-image='{{ asset('property-images/' . $item->image)}}'>
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger delte_property" data-id="{{$item->id}}" data-name="{{$item->title}}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            @else
                                                <button class="btn btn-warning enquire_btn" data-val='@json($item)'>Enquire</button>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="propertyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-3xl fs-bold" id="staticBackdropLabel">Add Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="propertyAddForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="propertyTitle" class="form-label">Property Title</label>
                            <input class="form-control @error('propertyTitle') is-invalid @enderror" type="text" placeholder="Enter Property Name" value="{{ old('propertyTitle') }}" id="propertyTitle" name="propertyTitle" required/>
                            @error('propertyTitle')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="propertyDescription" class="form-label">Property Descriptioin</label>
                            <textarea class="form-control @error('propertyDescription') is-invalid @enderror" placeholder="Enter Property Description" id="propertyDescription" name="propertyDescription" rows="3" value="{{ old('propertyDescription') }}"></textarea>
                            @error('propertyDescription')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input 
                                    class="form-control @error('price') is-invalid @enderror" 
                                    type="number" 
                                    placeholder="Enter Property Price" 
                                    id="price" 
                                    name="price" 
                                    value="{{ old('price') }}"
                                />
                               <span class="input-group-text">.00</span>
                            </div>
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="propertyType" class="form-label">Property Type</label>
                            <select class="form-select @error('propertyType') is-invalid @enderror" id="propertyType" name="propertyType" value="{{ old('propertyType') }}">
                                <option value="">Select Property Type</option>
                                @foreach ($propertyType as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('propertyType')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input class="form-control @error('city') is-invalid @enderror" type="text" placeholder="Enter City" id="city" name="city" value="{{ old('city') }}"/>
                            @error('city')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Updload Property Image</label>
                            <input class="form-control @error('images') is-invalid @enderror" type="file" id="images" name="images">
                            @error('images')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control @error('propertyDescription') is-invalid @enderror" placeholder="Enter Property Description" id="propertyDescription" name="propertyDescription" rows="3" value="{{ old('propertyDescription') }}"></textarea>
                            <button 
                                type="button" 
                                class="my-2 bottom-4 right-2 bg-none border-1 border-yellow-700 text-yellow-700 px-3 py-1 rounded-md text-sm hover:bg-yellow-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-gold-500 transition-all"
                                onclick="generateDescription()"
                            >
                                ✨ AI Generate
                            </button>
                            @error('propertyDescription')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div class="relative mx-auto mt-6">
                            <!-- Textarea -->
                            <textarea 
                                id="propertyDescription" 
                                name="propertyDescription" 
                                rows="4" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-20 @error('propertyDescription') is-invalid @enderror"
                                placeholder="Enter description here..."
                                value="{{ old('propertyDescription') }}"
                            ></textarea>

                            <!-- Button inside textarea -->
                            <button 
                                type="button" 
                                class="absolute bottom-4 right-2 bg-none border-1 border-yellow-700 text-yellow-700 px-3 py-1 rounded-md text-sm hover:bg-yellow-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-gold-500 transition-all"
                                onclick="generateDescription()"
                            >
                                ✨ AI Generate
                            </button>
                            @error('propertyDescription')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Property</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Edit/View Modal -->
        <div class="modal fade" id="propertyEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-bold text-3xl" id="edit_staticBackdropLabel">
                        
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="propertyEditForm" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-body max-h-[75vh] overflow-auto">
                        <div class="container">
                            <div class="row">
                                <input type="hidden" id="property_id" name="property_id"/>
                                <div class="image-wrapper">
                                    <img 
                                        src=""
                                        class="edit_image"
                                        id="edit_image"
                                        alt="Property Image"
                                    >
                                </div>
                            </div>
                            <div class="row_details my-2">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="propertyTitle" class="form-label">Property Title</label>
                                            <input 
                                                class="form-control @error('propertyTitle') is-invalid @enderror" 
                                                type="text"
                                                placeholder="Enter Property Title"
                                                id="edit_propertyTitle"
                                                name="propertyTitle"
                                                required
                                                @if (!Auth::user())
                                                    readonly
                                                @endif
                                                />
                                                @error('propertyTitle')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input 
                                                class="form-control @error('price') is-invalid @enderror" 
                                                type="number" 
                                                placeholder="Enter Property Price" 
                                                id="edit_price" 
                                                name="price" 
                                                @if (!Auth::user())
                                                    readonly
                                                @endif
                                            />
                                            @error('price')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="propertyType" class="form-label">Property Type</label>
                                            <select 
                                                class="form-select @error('propertyType') is-invalid @enderror" 
                                                id="edit_propertyType"
                                                name="propertyType"
                                                @if (!Auth::user())
                                                    disabled
                                                @endif
                                            >
                                                <option value="">Select Property Type</option>
                                                @foreach ($propertyType as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('propertyType')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input 
                                                class="form-control @error('city') is-invalid @enderror"
                                                type="text"
                                                placeholder="Enter City"
                                                id="edit_city"
                                                name="city"
                                                value="{{ old('city') }}"
                                                @if (!Auth::user())
                                                    readonly
                                                @endif
                                            />
                                            @error('city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="propertyDescription" class="form-label">Property Descriptioin</label>
                                            <textarea 
                                                class="form-control @error('propertyDescription') is-invalid @enderror" 
                                                placeholder="Enter Property Description" 
                                                id="edit_propertyDescription" 
                                                name="propertyDescription" 
                                                rows="8" 
                                                value="{{ old('propertyDescription') }}"
                                                @if (!Auth::user())
                                                    readonly
                                                @endif
                                            >
                                            </textarea>
                                            @error('propertyDescription')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if (Auth::user())
                            <button type="submit" class="btn btn-primary">Update Property</button>                            
                        @else
                            <button type="button" class="btn btn-warning">Enquire</button>
                        @endif
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>

        {{-- View Modal --}}
        <div class="modal fade" id="propertyViewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-semibold text-3xl text-info" id="view_staticBackdropLabel">
                        
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body max-h-[75vh] overflow-auto">
                    <div class="container">
                        <div class="row">
                            <div class="image-wrapper">
                                <img 
                                    src=""
                                    class="view_image"
                                    id="view_image"
                                    alt="Property Image"
                                >
                            </div>
                        </div>
                        <div class="row_details my-2">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="propertyTitle" class="form-label">Property Title</label>
                                        <input 
                                            class="form-control" 
                                            type="text"
                                            placeholder="Enter Property Title"
                                            id="view_propertyTitle"
                                            name="propertyTitle"
                                            readonly
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input 
                                            class="form-control" 
                                            type="text" 
                                            placeholder="Enter Property Price" 
                                            id="view_price" 
                                            name="price" 
                                            readonly
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="propertyType" class="form-label">Property Type</label>
                                        {{-- <select 
                                            class="form-select" 
                                            id="view_propertyType"
                                            name="propertyType"
                                            disabled
                                        >
                                            <option value="">Select Property Type</option>
                                            @foreach ($propertyType as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select> --}}
                                        <input 
                                            class="form-control" 
                                            type="text"
                                            placeholder="Enter Property Title"
                                            id="view_propertyType"
                                            name="propertyTitle"
                                            readonly
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input 
                                            class="form-control"
                                            type="text"
                                            placeholder="Enter City"
                                            id="view_city"
                                            name="city"
                                            value="{{ old('city') }}"
                                            readonly
                                        />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="propertyDescription" class="form-label">Property Descriptioin</label>
                                        <textarea 
                                            class="form-control" 
                                            placeholder="Enter Property Description" 
                                            id="view_propertyDescription" 
                                            name="propertyDescription" 
                                            rows="8" 
                                            value="{{ old('propertyDescription') }}"
                                            readonly
                                        >
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
        </div>

        {{-- Enquire Modal --}}
        <div class="modal fade" id="enquiryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-3xl fs-bold" id="enquireModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="enqireForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="propertyId" name="propertyId"/>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span class="text-red-500">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" placeholder="Enter name" required/>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address <span class="text-red-500">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" name="email" required/>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" min="10" max="10"/>
                            @error('phone')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Send Message</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>


        {{-- Delete modal --}}

        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Confirm Delete
                        </h5>

                        <button 
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>

                    <div class="modal-body">

                        Are you sure you want to delete this property?

                    </div>

                    <div class="modal-footer">

                        <button 
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button 
                            type="button"
                            class="btn btn-danger"
                            id="confirmDeleteBtn"
                        >
                            Delete
                        </button>

                    </div>

                </div>

            </div>
        </div>

        

    @if ($errors->any())
    <script>
        $(document).ready(function () {
            $('#propertyModal').modal('show');
        });
    </script>
    @endif

    <script>        
        function generateDescription(e){

            $('#global-loader').removeClass('loader-hidden');
            
            let isValid = true;

            // Remove old errors
            $('.is-invalid').removeClass('is-invalid');
            $('.custom-error').remove();

            // Property Title
            if ($('#propertyTitle').val().trim() === '') {

                showError(
                    '#propertyTitle',
                    'Property title is required'
                );

                isValid = false;
            }

            // Price
            if ($('#price').val().trim() === '') {

                showError(
                    '#price',
                    'Price is required'
                );

                isValid = false;
            }

            // Property Type
            if ($('#propertyType').val() === '') {

                showError(
                    '#propertyType',
                    'Please select property type'
                );

                isValid = false;
            }

            // City
            if ($('#city').val().trim() === '') {

                showError(
                    '#city',
                    'City is required'
                );

                isValid = false;
            }

            if(isValid){
                $('#global-loader').removeClass('loader-hidden');

                let data = {
                    title : $('#propertyTitle').val(),
                    price : $('#price').val(),
                    type  : $('#propertyType option:selected').text(),
                    city : $('#city').val(),
                };

                $.ajax({
                    url: "{{ route('properties.generateDescription') }}",
                    type:'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#global-loader').addClass('loader-hidden');
                        if(response.success){
                            $('#propertyDescription').val(response.description);
                        }
                        else{
                            showToast(response.message, 'success');
                        }
                    },
                    error: function(xhr,status, error){
                        $('#global-loader').addClass('loader-hidden');
                        console.log(error);
                    }
                })
            }


        }

        // Reusable function
        function showError(field, message) {

            $(field).addClass('is-invalid');

            $(field).after(
                `<div class="custom-error text-danger mt-1">
                    ${message}
                </div class=>`
            );
        }

        window.isAuthenticated = @json(Auth::check());

        $(document).ready(function() {
            function showToast(message, type = 'success') {
                
                $('#liveToast')
                    .removeClass('text-bg-success text-bg-danger text-bg-warning')
                    .addClass(`bg-${type}`);
    
                $('#toastMessage').text(message);
    
                let toast = new bootstrap.Toast(
                    $('#liveToast')
                );
    
                toast.show();
            }

            $('#propertyAddForm').on('submit', function (e) {
                
                e.preventDefault();

                let isValid = true;

                // Remove old errors
                $('.is-invalid').removeClass('is-invalid');
                $('.custom-error').remove();

                // Property Title
                if ($('#propertyTitle').val().trim() === '') {


                    showError(
                        '#propertyTitle',
                        'Property title is required'
                    );

                    isValid = false;
                }

                // Description
                if ($('#propertyDescription').val().trim() === '') {

                    showError(
                        '#propertyDescription',
                        'Property description is required'
                    );

                    isValid = false;
                }

                // Price
                if ($('#price').val().trim() === '') {

                    showError(
                        '#price',
                        'Price is required'
                    );

                    isValid = false;
                }

                // Property Type
                if ($('#propertyType').val() === '') {

                    showError(
                        '#propertyType',
                        'Please select property type'
                    );

                    isValid = false;
                }

                // City
                if ($('#city').val().trim() === '') {

                    showError(
                        '#city',
                        'City is required'
                    );

                    isValid = false;
                }

                // Image
                if ($('#images').val() === '') {

                    showError(
                        '#images',
                        'Please upload image'
                    );

                    isValid = false;
                }

                // Prevent submit
                if (!isValid) {
                    e.preventDefault();
                }
                else{
                    let formData = new FormData(this);
                    
                    $.ajax({
                        url: "{{ route('properties.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'Accept' : 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#global-loader').addClass('loader-hidden');
                            $('#propertyModal').modal('toggle');
                            if(response.success){
                                showToast(response.message, 'success');
                            }
                            else{
                                showToast(response.message, 'success');
                            }
                        },
                        error: function(xhr,status, error){
                            $('#global-loader').addClass('loader-hidden');
                            let message = xhr.responseJSON?.message || error || 'Something went wrong';

                            showToast(message, 'danger');
                        }
                    })
                }

            });


            $('input, textarea, select').on('input change', function () {

                $(this).removeClass('is-invalid');

                $(this)
                    .siblings('.custom-error')
                    .remove();

            });

            $('body').on('click', '.view_edit_button', function(e){

                $('#global-loader').removeClass('loader-hidden');
                // let data = $(this).attr('data-val');
                let id = $(this).data('id');
                let title = $(this).data('title');
                let description = decodeURIComponent($(this).data('description'));
                let propertyType = $(this).data('propertytype');
                let city = $(this).data('city');
                let price = $(this).data('price');
                let image = $(this).attr('data-image');
                // let parsedData = JSON.parse(data);

                $('#property_id').val(id);
                $('#edit_staticBackdropLabel').html(title ? title: 'Edit Details');
                $('#edit_propertyTitle').val(title ? title : 'Property Title' );
                $('#edit_propertyDescription').val(description);
                $('#edit_price').val(price);
                $('#edit_propertyType').val(propertyType);
                $('#edit_city').val(city);
                $('#edit_image').attr('src', image);

                setTimeout(()=>{
                    $('#global-loader').addClass('loader-hidden');
                    $('#propertyEditModal').modal('toggle');
                },[500]);
            });

            $('body').on('click', '.view_property', function(e){

                $('#global-loader').removeClass('loader-hidden');

                let id = $(this).data('id');
                let title = $(this).data('title');
                let description = decodeURIComponent($(this).data('description'));
                let propertyType = $(this).data('propertytype');
                let city = $(this).data('city');
                let image = $(this).attr('data-image');


                $('#property_id').val(id);
                $('#view_staticBackdropLabel').html(title ? title : 'View Details');
                $('#view_propertyTitle').val(title ? title : 'Title Not Available' );
                $('#view_propertyDescription').val(description);
                $('#view_price').val(`₹${Math.round(price)}`);
                $('#view_propertyType').val(propertyType);
                $('#view_city').val(city);
                $('#view_image').attr('src', image);

                setTimeout(() => {
                    $('#global-loader').addClass('loader-hidden');
                    $('#propertyViewModal').modal('toggle'); 
                }, 500);

            })


            $('#propertyEditForm').on('submit', function(e){
                e.preventDefault();

                let isValid = true;

                // Remove old errors
                $('.is-invalid').removeClass('is-invalid');
                $('.custom-error').remove();

                // Property Title
                if ($('#edit_propertyTitle').val().trim() === '') {

                    showError(
                        '#edit_propertyTitle',
                        'Property title is required'
                    );

                    isValid = false;
                }

                // Description
                if ($('#edit_propertyDescription').val().trim() === '') {

                    showError(
                        '#edit_propertyDescription',
                        'Property description is required'
                    );

                    isValid = false;
                }

                // Price
                if ($('#edit_price').val().trim() === '') {

                    showError(
                        '#edit_price',
                        'Price is required'
                    );

                    isValid = false;
                }

                // Property Type
                if ($('#edit_propertyType').val() === '') {

                    showError(
                        '#edit_propertyType',
                        'Please select property type'
                    );

                    isValid = false;
                }

                // City
                if ($('#edit_city').val().trim() === '') {

                    showError(
                        '#edit_city',
                        'City is required'
                    );

                    isValid = false;
                }

                // Image
                if ($('#edit_images').val() === '') {

                    showError(
                        '#edit_images',
                        'Please upload image'
                    );

                    isValid = false;
                }

                // Prevent submit
                if (!isValid) {
                    e.preventDefault();
                }
                else{
                    $('#global-loader').removeClass('loader-hidden');
                    
                    let formData = new FormData(this);
                    
                    $.ajax({
                        url: "{{ route('properties.update') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'Accept' : 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                             $('#global-loader').addClass('loader-hidden');
                            $('#propertyEditModal').modal('toggle');
                            if(response.success){
                                showToast(response.message, 'success');
                            }
                            else{
                                showToast(response.message, 'success');
                            }
                        },
                        error: function(xhr,status, error){
                            $('#global-loader').addClass('loader-hidden');
                            let message = xhr.responseJSON?.message || error || 'Something went wrong';
                            
                            showToast(message, 'danger');
                        }
                    })
                }

            })

            let deleteId = null;

            $('body').on('click', '.delte_property', function(e){
                deleteId = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $('#deleteModal .modal-body').prepend(`<p>Title: <strong class='text-red-500'> ${name}</strong></p>`);
                $('#deleteModal').modal('show');
                
            });


            $('#confirmDeleteBtn').on('click', function () {
                $.ajax({
                    url: `/properties/${deleteId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        $('#deleteModal').modal('hide');
                        if(response.success){
                            showToast(response.message, 'success');
                        }
                        else{
                            showToast(response.message, 'danger');
                        }
                    },
                    error: function(xhr, status, error){
                        $('#deleteModal').modal('hide');
                        console.error(status, error);
                        let message = xhr.responseJSON?.message || "Something went wrong";
                        showToast(message, 'danger');

                    }
                })
            });


            $('.enquire_btn').on('click', function(e){
                let data = JSON.parse($(this).attr('data-val'));
                
                let info = `<h3 class="text-3xl font-semibold text-indigo-800" id="property_name">${data.title}</h3><p class="text-sm text-gray-400" id="price">₹ ${data.price}</p>`;

                $('#propertyId').val(data.id);
                $('#enquireModalTitle').html(info);
                $('#price').val(data.price);

                $('#enquiryModal').modal('toggle');

                
            });


            $('#enqireForm').on('submit', function (e) {

                e.preventDefault();
                let isValid = true;

                // Remove old errors
                $('.is-invalid').removeClass('is-invalid');
                $('.custom-error').remove();

                // Property name
                if ($('#name').val().trim() === '') {

                    showError(
                        '#name',
                        'Name is required'
                    );

                    isValid = false;
                }

                // email
                if ($('#email').val().trim() === '') {

                    showError(
                        '#email',
                        'Email is required'
                    );

                    isValid = false;
                }

                // phone
                if ($('#phone').val().length != 10) {

                    showError(
                        '#phone',
                        'Invalid Phone Number must be 10 digits'
                    );

                    isValid = false;
                }

                // Prevent submit
                if (!isValid) {
                    e.preventDefault();
                }
                else{
                    let formData = new FormData(this);
                    
                    $.ajax({
                        url: "{{ route('enquiry.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'Accept' : 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#enquiryModal').modal('toggle');
                            if(response.success){
                                showToast(response.message, 'success');
                            }
                            else{
                                showToast(response.message, 'success');
                            }
                        },
                        error: function(xhr,status, error){
                            let message = xhr.responseJSON?.message || "Something went wrong";
                            showToast(message, 'danger');
                        }
                    })
                }

            });


        });

        $('#search_key').on('keyup', function(e){
            let city = $(this).val();

            $.ajax({
                url: "{{ route('properties.search') }}",
                type: 'GET',
                data: {
                    city
                },
                success: function(response) {
                    if(response.success){
                        let html = '<div class="row">';
                        response.properties.forEach(item => {
                            html += `
                            <div class="col-12 col-md-6 mb-4">
                                <div class="card mb-3" style="max-width: 100%;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-center align-items-center overflow-hidden bg-light" style="height:180px;">
                                                <img src="/property-images/${item.image}" class="img-fluid rounded-start" alt="${item.image}">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title text-2xl font-semibold d-flex justify-content-between">
                                                    <span>${item.title}</span>
                                                    <span class="text-gray-400">₹${Math.round(item.price)}</span>
                                                </h5>
                                                <p class="card-text">${item.description.substring(0,100)}...</p>
                                                <p><strong>PROPERTY TYPE: </strong>${item.type.name} | <strong>City:</strong> ${item.city}</p>
                                                <p class="card-text"><small class="text-muted">Updated ${item.updated_at ?? item.created_at}</small></p>
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-outline-info view_property"
                                                        data-id="${item.id}"
                                                        data-title="${item.title}"
                                                        data-price="${item.price}"
                                                        data-city="${item.city}"
                                                        data-propertyType="${item.type.id}"
                                                        data-description="${encodeURIComponent(item.description)}"
                                                        // data-val='${encodeURIComponent(JSON.stringify(item))}'
                                                        data-image='/property-images/${item.image}'
                                                    >
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                    ${window.isAuthenticated ? `
                                                        <button class="btn btn-outline-success view_edit_button"
                                                            data-id="${item.id}"
                                                            data-title="${item.title}"
                                                            data-price="${item.price}"
                                                            data-city="${item.city}"
                                                            data-propertyType="${item.type.id}"
                                                            data-description="${encodeURIComponent(item.description)}"
                                                            // data-val='${encodeURIComponent(JSON.stringify(item))}'
                                                            data-image='/property-images/${item.image}'
                                                        >
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger delete_property" data-id="${item.id}" data-name="${item.title}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    ` : `
                                                        <button class="btn btn-warning enquire_btn" data-val='${JSON.stringify(item)}'>Enquire</button>
                                                    `}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });

                        html += '</div>';

                        $('#properties_container').html(html);
                    }else {

                    }
                },
                catch(xhr, status, error){
                    console.log(error);
                }
            })
        })
        
           
    </script>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">

        <div 
            id="liveToast"
            class="toast align-items-center text-white bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >

            <div class="d-flex">

                <div class="toast-body" id="toastMessage">
                    Success Message
                </div>

                <button 
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                ></button>

            </div>

        </div>

    </div>
    
@endsection
