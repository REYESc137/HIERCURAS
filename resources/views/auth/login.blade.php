<x-guest-layout>
    <style>
        button {
            background-color: #6B8E23; /* Verde musgo para el botón */
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            width: 100%; /* Hace que el botón ocupe todo el ancho */
        }
    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" style="color: #6B8E23;" />
            <x-text-input id="email" class="block w-full mt-1" style="border-color: #6B8E23; padding: 8px; background-color: #FFFFFF; color: #000000;" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" style="color: #6B8E23;" />
            <x-text-input id="password" class="block w-full mt-1" style="border-color: #6B8E23; padding: 8px; background-color: #FFFFFF; color: #000000;" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" style="border-color: #6B8E23; color: #6B8E23;" name="remember">
                <span class="text-sm ms-2" style="color: #6B8E23;">{{ __('Mantener sesión activa') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm underline" href="{{ route('password.request') }}" style="color: #8B4513;">
                    {{ __('¿Olvidó su contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ml-3" style="background-color: #6B8E23; color: white; padding: 8px 16px; border-radius: 4px;">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
        <div class="mt-4">
            <a href="{{ route('google.login') }}">
                <button type="button">Iniciar sesión con Google</button>
            </a>
        </div>
    </form>
</x-guest-layout>