<section class="space-y-6 p-6 bg-[#F5F5DC] rounded-lg shadow-lg"> <!-- Fondo beige natural -->
    <header class="bg-[#98FB98] p-4 rounded-lg shadow-sm"> <!-- Fondo verde claro -->
        <h2 style="color: #ffffff !important;" class="text-lg font-semibold"> <!-- Verde oscuro para el título -->
            {{ __('Información de perfil') }}
        </h2>

        <p style="color: #6B4226 !important;" class="mt-1 text-sm"> <!-- Marrón tierra para el texto -->
            {{ __("Actualice la información de su cuenta y la dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" style="color: #6B4226 !important;" /> <!-- Marrón tierra -->
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-[#6B8E23] text-[#2F4F4F] bg-white rounded-md shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" style="color: #2F4F4F !important;"/> <!-- Texto verde oscuro y borde verde musgo -->
            <x-input-error class="mt-2" style="color: #B22222 !important;" :messages="$errors->get('name')" /> <!-- Error en rojo natural -->
        </div>

        <!-- Correo Electrónico -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" style="color: #6B4226 !important;" /> <!-- Marrón tierra -->
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-[#6B8E23] text-[#2F4F4F] bg-white rounded-md shadow-sm" :value="old('email', $user->email)" required autocomplete="username" style="color: #2F4F4F !important;"/> <!-- Texto verde oscuro y borde verde musgo -->
            <x-input-error class="mt-2" style="color: #B22222 !important;" :messages="$errors->get('email')" /> <!-- Error en rojo natural -->

            <!-- Verificación de Correo Electrónico -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p style="color: #6B8E23 !important;" class="text-sm mt-2"> <!-- Verde musgo -->
                        {{ __('Su correo electrónico no ha sido verificado.') }}

                        <button form="send-verification" style="color: #8B4513 !important;" class="underline text-sm hover:text-[#6B8E23] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6B8E23]">
                            {{ __('Haga clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="color: #556B2F !important;" class="mt-2 font-medium text-sm"> <!-- Verde musgo oscuro -->
                            {{ __('Se ha enviado un nuevo enlace de verificación a su correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Botón Guardar -->
        <div class="flex items-center gap-4">
            <x-primary-button style="color: white !important; background-color: #6B8E23 !important;" class="font-bold py-2 px-4 rounded-full shadow-lg"> <!-- Botón verde musgo con texto blanco -->
                {{ __('Guardar') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="color: #6B8E23 !important;" class="text-sm"> <!-- Verde musgo -->
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>
