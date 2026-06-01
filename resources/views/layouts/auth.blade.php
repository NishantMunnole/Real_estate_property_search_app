<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', config('app.name')) </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- icons --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <x-loader />

    {{-- Header --}}
    {{-- <header> --}}
        {{-- Navbar --}}
        {{-- <nav class="navbar navbar-light position-fixed top-0 w-100 px-4" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                            <img src={{asset('images/LOGO_brand.png')}} alt="Logo" class="img-fluid" width="50" height="50"/>
                            Real Estate App
                        </a>
                    </div>
                    @if (auth()->check())
                        <div class="dropdown">
                           <button  type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="text-center fw-bold">{{ auth()->user()->name }}</li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ url('/register')}}">Register</a></li>
                                <li><a class="dropdown-item" href="{{ route('//logout') }}" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ url('/login')}}" class="btn btn-outline-success">Login</a>                    
                    @endif
                </div>
            </div>
        </nav> --}}
    {{-- </header> --}}

     @include('layouts.navigation')
    <main class="px-2 pt-[75px] pb-[45px]">
        <div class="container-fluid bg-white min-h-[100vh] shadow-md p-3 bg-body rounded">
            @yield('content')
        </div>
    </main>


    <footer class="position-fixed bottom-0 text-center py-2 text-sm text-secondary w-100" style="background-color: #e3f2fd;">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </footer>

    <script>
        $(window).on('load', function() {
            $('#global-loader').addClass('loader-hidden');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>