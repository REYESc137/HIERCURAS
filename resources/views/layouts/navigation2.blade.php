<nav x-data="{ open: false }" class="border-b border-gray-100 bg-[#6B8E23] !important">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/Hiercura_logo.png') }}" alt="Logo Herbolario" class="block w-auto h-9">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->routeIs('welcome')" class="text-white !important">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/plantas-medicinales')" class="text-white !important">
                        {{ __('Plantas Medicinales') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/descubridores')" class="text-white !important">
                        {{ __('Descubridores') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/metodos-elaboracion')" class="text-white !important">
                        {{ __('Métodos de Elaboración') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side (Login/Register) -->
            <div class="hidden sm:flex sm:items-center sm:ml-auto">
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="text-white !important">
                    {{ __('Iniciar Sesión') }}
                </x-nav-link>
                <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-white !important">
                    {{ __('Registrarse') }}
                </x-nav-link>
            </div>

            <!-- Hamburger Menu for mobile -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-200 transition duration-150 ease-in-out rounded-md hover:text-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu for mobile -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden bg-[#6B8E23] !important">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->routeIs('welcome')" class="text-white !important">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/plantas-medicinales')" class="text-white !important">
                {{ __('Plantas Medicinales') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/descubridores')" class="text-white !important">
                {{ __('Descubridores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/metodos-elaboracion')" class="text-white !important">
                {{ __('Métodos de Elaboración') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" class="text-white !important">
                {{ __('Iniciar Sesión') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-white !important">
                {{ __('Registrarse') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
