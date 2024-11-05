<section class="space-y-6 p-6 bg-[#F5F5DC] rounded-lg shadow-lg"> <!-- Fondo beige natural -->
    <header class="bg-[#98FB98] p-4 rounded-lg shadow-sm"> <!-- Fondo verde claro -->
        <h2 style="color: #ffffff !important;" class="text-xl font-semibold"> <!-- Verde oscuro para el título -->
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p style="color: #556B2F !important;" class="mt-1 text-sm"> <!-- Verde musgo para el texto -->
            {{ __('Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Contraseña Actual -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" style="color: #6B4226 !important;" /> <!-- Marrón tierra -->
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-[#6B8E23] text-[#2F4F4F] bg-white rounded-md shadow-sm" autocomplete="current-password" style="color: #2F4F4F !important;" /> <!-- Texto verde oscuro y borde verde musgo -->
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" style="color: #B22222 !important;" /> <!-- Error en rojo oscuro natural -->
        </div>

        <!-- Nueva Contraseña -->
        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" style="color: #6B4226 !important;" /> <!-- Marrón tierra -->
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-[#6B8E23] text-[#2F4F4F] bg-white rounded-md shadow-sm" autocomplete="new-password" style="color: #2F4F4F !important;"/> <!-- Texto verde oscuro y borde verde musgo -->
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" style="color: #B22222 !important;" /> <!-- Error en rojo oscuro natural -->
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" style="color: #6B4226 !important;" /> <!-- Marrón tierra -->
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-[#6B8E23] text-[#2F4F4F] bg-white rounded-md shadow-sm" autocomplete="new-password" style="color: #2F4F4F !important;"/> <!-- Texto verde oscuro y borde verde musgo -->
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" style="color: #B22222 !important;" /> <!-- Error en rojo oscuro natural -->
        </div>

        <!-- Botón Guardar -->
        <div class="flex items-center gap-4">
            <x-primary-button style="color: white !important; background-color: #6B8E23 !important;" class="font-bold py-2 px-4 rounded-full shadow-lg"> <!-- Botón verde musgo con texto blanco -->
                {{ __('Guardar') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="color: #556B2F !important;" class="text-sm"> <!-- Verde musgo -->
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>
