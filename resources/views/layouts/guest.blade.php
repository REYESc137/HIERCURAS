<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hiercura') }}</title>

        <link rel="icon" href="{{ asset('assets/img/Hiercura_logo.png') }}" type="image/png"> <!-- Cambia la ruta a la de tu imagen -->


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Styles for Background -->
        <style>
            body {
                background-image: url('{{ asset('assets/img/Fondo.webp') }}'); /* Ruta de la imagen de fondo */
                background-size: cover; /* Cubrir todo el fondo */
                background-position: center; /* Centrar la imagen */
                background-repeat: no-repeat; /* No repetir la imagen */
                height: 100vh; /* Asegurarse que la imagen de fondo cubra toda la altura */
                display: flex;
                justify-content: center;
                align-items: center; /* Centramos todo el contenido vertical y horizontalmente */
                margin: 0;
                padding: 0;
            }

            .min-h-screen {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh; /* La altura mínima será la pantalla completa */
            }

            .form-container {
                width: 100%;
                max-width: 400px;
                padding: 20px;
                background-color: #FAF0E6;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            /* Media Queries para pantallas pequeñas */
            @media (max-width: 640px) {
                .form-container {
                    padding: 15px;
                    max-width: 90%; /* Aumentar el ancho en dispositivos móviles */
                }

                .w-20 {
                    width: 60px; /* Reducir el tamaño del logo */
                    height: 60px;
                }

                .form-container input {
                    padding: 10px; /* Ajustar el padding de los inputs */
                }

                .form-container button {
                    padding: 10px 15px; /* Ajustar padding del botón */
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen">
            <!-- Logo Hiercura -->
            <div>
                <a href="/">
                    <img src="{{ asset('assets/img/Hiercura_logo.png') }}" alt="Hiercura Logo" class="w-20 h-20">
                </a>
            </div>

            <div class="mt-6 form-container">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
