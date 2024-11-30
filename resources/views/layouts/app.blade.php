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
                        {{ __('Bienvenido') }}
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
                                    <input class="px-4 py-3 border-2 form-control border-secondary w-75 rounded-pill" type="text" disabled
                                        placeholder="Busca lo que necesites">
                                    {{-- <button type="submit"
                                        class="px-4 py-3 text-white border-2 btn bg-[#8B4513] border-[#6B8E23] position-absolute rounded-pill h-100"
                                        style="top: 0; right: 25%;"><i
                                        class="text-white fas fa-search"></i></button> --}}
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

                <div class="intro-container text-center py-5">
                    <h1 class="text-primary mb-3">Bienvenido a Hiercura</h1>
                    <p class="text-muted mb-4">
                        Hiercura es una herbopedia digital donde podrás explorar una variedad de plantas medicinales, sus propiedades y recetas naturales para mejorar tu bienestar.
                    </p>

                    
                    <p class="text-muted">
                        Descubre cómo la naturaleza puede ayudarte a vivir de manera más saludable.
                    </p>
                    
                    
                </div>
                
                <style>
                    .intro-container {
                        padding: 50px 20px;
                        max-width: 800px;
                        margin: 0 auto;
                        text-align: center;
                    }
                
                    .intro-container h1 {
                        font-size: 2rem;
                        font-weight: 500;
                        color: #1E2A47; /* Gris oscuro para un toque moderno */
                    }
                
                    .intro-container p {
                        font-size: 1rem;
                        color: #6C757D; /* Gris suave para el texto */
                        line-height: 1.5;
                        margin: 0;
                    }
                </style>
                

                <center><h2 class="mb-4 text-[#6B8E23]">Revisa todas nuestra plantas</h2></center>
                <div class="plantas-carousel-container">
                    
                        
                    <div class="plantas-carousel-wrapper" id="plantasCarouselWrapper">
                        <!-- Aquí se insertarán dinámicamente las tarjetas -->
                    </div>
                    <button class="plantas-carousel-control prev" onclick="prevSlide()">&#10094;</button>
                    <button class="plantas-carousel-control next" onclick="nextSlide()">&#10095;</button>
                </div>
                
                <!-- Estilos exclusivos para el carrusel -->
                <style>
                    .plantas-carousel-container {
                        position: relative;
                        max-width: 1200px;
                        margin: 0 auto;
                        overflow: hidden;
                        background-color: #f8f9fa; /* Fondo claro */
                        padding: 20px 0;
                        border-radius: 15px;
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                    }
                
                    .plantas-carousel-wrapper {
                        display: flex;
                        gap: 20px;
                        transition: transform 0.5s ease-in-out;
                    }
                
                    .plantas-carousel-item {
                        flex: 0 0 auto;
                        width: 250px;
                        text-align: center;
                        background-color: white;
                        border-radius: 15px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        padding: 15px;
                    }
                
                    .plantas-carousel-item img {
                        width: 150px;
                        height: 150px;
                        object-fit: cover;
                        border-radius: 50%;
                        margin-bottom: 10px;
                    }
                
                    .plantas-carousel-item h5 {
                        font-size: 16px;
                        font-weight: bold;
                        color: #6b8e23; /* Verde musgo */
                    }
                
                    .plantas-carousel-item a {
                        display: inline-block;
                        margin-top: 10px;
                        padding: 5px 15px;
                        background-color: #8b4513; /* Marrón */
                        color: white;
                        border-radius: 5px;
                        text-decoration: none;
                        font-size: 14px;
                    }
                
                    .plantas-carousel-control {
                        position: absolute;
                        top: 50%;
                        transform: translateY(-50%);
                        background-color: rgba(0, 0, 0, 0.5);
                        color: white;
                        border: none;
                        border-radius: 50%;
                        padding: 10px;
                        cursor: pointer;
                        z-index: 10;
                        font-size: 20px;
                    }
                
                    .plantas-carousel-control.prev {
                        left: 10px;
                    }
                
                    .plantas-carousel-control.next {
                        right: 10px;
                    }
                
                    .plantas-carousel-control:hover {
                        background-color: rgba(0, 0, 0, 0.8);
                    }
                </style>
                
                <!-- Script para cargar datos dinámicamente y manejar el carrusel -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        fetch('/api/plantas')
                            .then(response => response.json())
                            .then(plantas => {
                                const carouselWrapper = document.getElementById('plantasCarouselWrapper');
                                let slides = '';
                
                                plantas.forEach(planta => {
                                    slides += `
                                        <div class="plantas-carousel-item">
                                            <img 
                                                src="${planta.foto ? '/assets/img/plantas/' + planta.foto : '/assets/img/Hiercura_logo.png'}" 
                                                alt="${planta.nombre_comun}" 
                                                onerror="this.src='/assets/img/Hiercura_logo.png'">
                                            <h5>${planta.nombre_comun}</h5>
                                            <a href="/plantas-medicinales">Ver Más</a>
                                        </div>
                                    `;
                                });
                
                                carouselWrapper.innerHTML = slides;
                            })
                            .catch(error => console.error('Error al cargar las plantas:', error));
                    });
                
                    // Funciones para controlar el carrusel
                    let currentIndex = 0;
                
                    function nextSlide() {
                        const wrapper = document.querySelector('.plantas-carousel-wrapper');
                        const items = document.querySelectorAll('.plantas-carousel-item');
                        const itemWidth = items[0].clientWidth + 20; // Ancho de cada tarjeta + margen
                        currentIndex = (currentIndex + 1) % items.length;
                        wrapper.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                    }
                
                    function prevSlide() {
                        const wrapper = document.querySelector('.plantas-carousel-wrapper');
                        const items = document.querySelectorAll('.plantas-carousel-item');
                        const itemWidth = items[0].clientWidth + 20; // Ancho de cada tarjeta + margen
                        currentIndex = (currentIndex - 1 + items.length) % items.length;
                        wrapper.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                    }
                </script>
                
                <div class="py-5 container-fluid">
                    <div class="container text-center">
                        <h2 class="mb-4 text-[#6B8E23]">Beneficios de la Medicina Herbolaria</h2>
                        <p class="text-secondary">La medicina herbolaria no solo promueve un enfoque natural para cuidar la salud, sino que también fomenta la sostenibilidad al aprovechar los recursos naturales de manera responsable.</p>
                        <div class="row mt-4 g-4">
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded">
                                    <i class="text-[#6B8E23] fas fa-leaf fa-3x mb-3"></i>
                                    <h5>Natural y Efectivo</h5>
                                    <p>Remedios basados en plantas que ayudan a fortalecer el sistema inmunológico.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded">
                                    <i class="text-[#6B8E23] fas fa-heartbeat fa-3x mb-3"></i>
                                    <h5>Salud Preventiva</h5>
                                    <p>Enfocado en evitar enfermedades en lugar de tratarlas después.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded">
                                    <i class="text-[#6B8E23] fas fa-globe fa-3x mb-3"></i>
                                    <h5>Eco-Amigable</h5>
                                    <p>Contribuye a la sostenibilidad y preservación de recursos naturales.</p>
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

                
                

                @yield('footer')
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
