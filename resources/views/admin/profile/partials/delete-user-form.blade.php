<section class="space-y-6">
    <header class="bg-green-100 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-900" style="color: white !important;">
            {{ __('Borrar cuenta') }}
        </h2>

        <p class="mt-2 text-sm text-gray-700">
            {{ __('Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán de forma permanente. Antes de borrar su cuenta, por favor descargue cualquier dato o información que desee conservar.') }}
        </p>
    </header>

    <x-danger-button
        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Borrar cuenta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white rounded-lg shadow-lg">
            @csrf
            @method('delete')

            <h2 style="color: #2F4F4F !important;" class="text-lg font-semibold"> <!-- Verde oscuro -->
                {{ __('¿Está seguro de que quiere eliminar su cuenta?') }}
            </h2>

            <p style="color: #6B4226 !important;" class="mt-2 text-sm"> <!-- Marrón tierra -->
                {{ __('Una vez eliminada, todos los recursos y datos se perderán permanentemente. Ingrese su contraseña para confirmar.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="{{ __('Contraseña') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md" x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md ml-3">
                    {{ __('Eliminar cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
