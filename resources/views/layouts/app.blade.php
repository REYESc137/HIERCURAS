<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hiercura') }}</title>
        <link rel="icon" href="{{ asset('assets/img/Hiercura_logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen bg-gray-100">
            <!-- Aquí va la navegación -->
            @if (Auth::check())
                @include('layouts.navigation') <!-- Menú para usuarios autenticados -->
            @else
                @include('layouts.navigation2') <!-- Menú para usuarios no autenticados -->
            @endif

            <!-- Page Heading (se puede usar en ambas vistas) -->
            @isset($header)
                <header class="bg-[#6B8E23]"> <!-- Verde musgo -->
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            @if (Auth::check())
                 <!-- Menú para usuarios autenticados -->
            @else
                <!-- Barra del Dashboard -->
            <header class="bg-[#6B8E23]"> <!-- Verde musgo -->
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white dark:text-gray-200">
                        {{ __('Panel') }}
                    </h1>
                </div>
            </header> <!-- Menú para usuarios no autenticados -->
            @endif
            <!-- Page Content -->
            <main>
                <!-- Page Content -->
            <main class="pt-0 mt-0">
                <!-- Hero Section (ya existente en tu diseño) -->
                <div class="pt-0 mt-0 container-fluid hero-header" style="margin-top: -20px; background-color: #A9DFBF;">
                    <div class="container py-5">
                        <div class="row g-5 align-items-center">
                            <div class="col-md-12 col-lg-7">
                                <h4 class="mb-3 text-secondary">Herbolaria Medicinal</h4>
                                <h1 class="mb-5 text-[#6B8E23] display-3">Cuidando tu salud, <br> a lo natural.</h1>
                                <div class="mx-auto position-relative">
                                    <input class="px-4 py-3 border-2 form-control border-secondary w-75 rounded-pill" type="text"
                                        placeholder="Buscar">
                                    <button type="submit"
                                        class="px-4 py-3 text-white border-2 btn bg-[#8B4513] border-[#6B8E23] position-absolute rounded-pill h-100"
                                        style="top: 0; right: 25%;"><i
                                        class="text-white fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-5">
                                <div id="carouselExample" class="carousel slide position-relative" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="rounded carousel-item active">
                                            <img src="{{ asset('assets/img/hierba1.jpg') }}" class="rounded img-fluid w-100 h-100 bg-secondary"
                                                alt="First slide">
                                            <a href="#" class="px-4 py-2 text-white bg-[#8B4513] rounded btn">Medicinal</a>
                                        </div>
                                        <div class="rounded carousel-item">
                                            <img src="{{ asset('assets/img/hierba2.jpg') }}" class="rounded img-fluid w-100 h-100" alt="Second slide">
                                            <a href="#" class="px-4 py-2 text-white bg-[#8B4513] rounded btn">100% Natural</a>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Section (colores naturales) -->
                <div class="py-5 container-fluid featurs bg-[#FAF0E6]"> <!-- Fondo blanco roto -->
                    <div class="container py-5">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="p-4 text-center bg-white rounded featurs-item">
                                    <div class="mx-auto mb-5 featurs-icon btn-square rounded-circle bg-[#6B8E23]"> <!-- Fondo verde musgo -->
                                        <i class="text-white bi bi-file-earmark-richtext fa-3x"></i>
                                    </div>
                                    <div class="text-center featurs-content">
                                        <h5>Información Completa</h5>
                                        <p class="mb-0">Variedad de plantas medicinales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="p-4 text-center bg-white rounded featurs-item">
                                    <div class="mx-auto mb-5 featurs-icon btn-square rounded-circle bg-[#6B8E23]">
                                        <i class="text-white fas fa-user-shield fa-3x"></i>
                                    </div>
                                    <div class="text-center featurs-content">
                                        <h5>Pago Seguro</h5>
                                        <p class="mb-0">Pago 100% seguro</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="p-4 text-center bg-white rounded featurs-item">
                                    <div class="mx-auto mb-5 featurs-icon btn-square rounded-circle bg-[#6B8E23]">
                                        <i class="text-white fas fa-exchange-alt fa-3x"></i>
                                    </div>
                                    <div class="text-center featurs-content">
                                        <h5>Recetas Tradicionales</h5>
                                        <p class="mb-0">Todo a base de hierbas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="p-4 text-center bg-white rounded featurs-item">
                                    <div class="mx-auto mb-5 featurs-icon btn-square rounded-circle bg-[#6B8E23]">
                                        <i class="text-white fa fa-phone-alt fa-3x"></i>
                                    </div>
                                    <div class="text-center featurs-content">
                                        <h5>Información detallada</h5>
                                        <p class="mb-0">Para explorar más</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Section (tonos más suaves) -->
                <div class="pt-5 mt-5 container-fluid bg-[#8B4513] text-white-50 footer"> <!-- Marrón tierra para el footer -->
                    <div class="container py-5">
                        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                            <div class="row g-4">
                                <div class="col-lg-3">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/Hiercura_logo.png') }}" alt="Hiercura" width="70" height="70">
                                        <h1 class="mb-0 text-white">Hiercura</h1>
                                        <p class="mb-0 text-white-50">Cuidando tu salud, a lo natural</p>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    @if (Auth::check() && Auth::user()->tipo_user_id != 3)
                                    <form action="{{ route('payment')}}" method="post">
                                        @csrf
                                    <div class="mx-auto position-relative">
                                        <input class="px-4 py-3 border-0 form-control w-100 rounded-pill" type="text" disabled
                                            placeholder="Suscribete por $20 MXN al mes">
                                            <input type="hidden" name="amount" value=20>
                                        <button type="submit"
                                            class="px-4 py-3 text-white border-0 btn btn-primary bg-[#6B8E23] position-absolute rounded-pill"
                                            style="top: 0; right: 0;">Suscribirse</button>
                                    </div>
                                    </form>
                                    @else
                                    @if( !Auth::check() || Auth::user()->tipo_user_id != 3)
                                    <div class="mx-auto position-relative">
                                        <input class="px-4 py-3 border-0 form-control w-100 rounded-pill" type="text" disabled placeholder="Suscribete">
                                        <a href="{{ route('login')}}" type="submit"
                                            class="px-4 py-3 text-white border-0 btn btn-primary bg-[#6B8E23] position-absolute rounded-pill"
                                            style="top: 0; right: 0;">Inicia  Sesión</a>
                                    @endif
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            </main>
        </div>

        <!-- Scripts para Bootstrap y otros plugins -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>
