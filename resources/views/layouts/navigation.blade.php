<nav x-data="{ open: false }" class="bg-[#6B8E23] border-b border-gray-100 dark:border-gray-700">
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
                    <x-nav-link :href="url('/')" :active="request()->routeIs('welcome')" class="text-white">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/plantas-medicinales')" class="text-white">
                        {{ __('Plantas Medicinales') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/descubridores')" class="text-white">
                        {{ __('Descubridores') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/metodos-elaboracion')" class="text-white">
                        {{ __('Métodos de Elaboración') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[#6B8E23] hover:text-gray-200 transition ease-in-out duration-150">
                            @if(Auth::user()->tipo_user_id == 3)
                            <img src="{{ asset('assets/img/diamante.png')}}" alt="premium">
                            @endif
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Enlace para editar perfil -->
                        <x-dropdown-link :href="route('profile.edit')" style="color: #6B8E23 !important; background-color: transparent; transition: all 0.3s ease;"
                            onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6B8E23';">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Formulario para cerrar sesión -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                                style="color: #6B8E23 !important; background-color: transparent; transition: all 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6B8E23';">
                                {{ __('Finalizar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for mobile -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-white transition duration-150 ease-in-out rounded-md hover:text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden bg-[#6B8E23]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->routeIs('welcome')" style="color: white !important; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/plantas-medicinales')" style="color: white !important; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                {{ __('Plantas Medicinales') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/descubridores')" style="color: white !important; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                {{ __('Descubridores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/metodos-elaboracion')" style="color: white !important; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                {{ __('Métodos de Elaboración') }}
            </x-responsive-nav-link>

            <!-- Responsive Profile -->
            <x-responsive-nav-link :href="route('profile.edit')" style="color: white !important; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                {{ __('Perfil') }}
            </x-responsive-nav-link>

            <!-- Responsive Log Out -->
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                style="color: white !important; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='#6B8E23'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                {{ __('Cerrar Sesión') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</nav>
