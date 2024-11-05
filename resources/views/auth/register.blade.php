<x-guest-layout>
    <style>
        body {
            background-image: url('{{ asset('assets/img/Fondo.webp') }}'); /* Imagen de fondo */
            background-size: cover; /* Cubrir toda la pantalla */
            background-position: center; /* Centrar la imagen */
            background-repeat: no-repeat; /* No repetir la imagen */
            height: 100vh; /* Altura de toda la pantalla */
            display: flex;
            justify-content: center;
            align-items: center; /* Centrar vertical y horizontalmente */
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #FAF0E6; /* Fondo beige claro */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
            border-radius: 10px;
        }
        /* Estilos de input y texto */
        input {
            border-color: #6B8E23; /* Verde musgo */
            padding: 8px;
            background-color: #FFFFFF !important; /* Fondo blanco para los inputs */
            color: #000000 !important; /* Texto negro */
        }
        /* Eliminar el sombreado oscuro de autocompletar en Chrome */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #FFFFFF inset !important;
            -webkit-text-fill-color: #000000 !important;
        }
        .input-label {
            color: #6B8E23; /* Verde musgo para las etiquetas */
        }
        a {
            color: #8B4513; /* Marrón para enlaces */
        }
        a:hover {
            color: #6B8E23; /* Verde musgo para hover */
        }
        button {
            background-color: #6B8E23; /* Verde musgo para el botón */
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            width: 100%; /* Hace que el botón ocupe todo el ancho */
        }
-
    </style>

    <div class="form-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" class="input-label" />
                <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Correo electrónico')" class="input-label" />
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" class="input-label" />

                <x-text-input id="password" class="block w-full mt-1"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="input-label" />

                <x-text-input id="password_confirmation" class="block w-full mt-1"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm underline" href="{{ route('login') }}" style="color: #8B4513;">
                    {{ __('¿Ya se registró?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
        <div class="mt-4">
    <a href="{{ route('google.login') }}">
        <button>Iniciar sesión con Google</button>
    </a>
</div>
    </div>
</x-guest-layout>