<link rel="stylesheet" href="{{ asset('css/nav.css') }}">
<nav x-data="{ open: false }" class="navbar from-blue-500 via-blue-600 to-blue-700 text-black shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-black" />
                    </a>
                </div>
                <div>                          
                    @if (strtolower(Auth::user()->role->nombre) === 'secretaria')
                        <span class="text-green-600">Bienvenida Secretaria</span>
                    @endif
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-black ">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="text-black">
                        {{ __('Doctores') }}
                    </x-nav-link>
                    <x-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="text-black">
                        {{ __('Secretarias') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="text-black">
                        {{ __('Pacientes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="text-black">
                        {{ __('Servicios') }}
                    </x-nav-link>
                    <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="text-black">
                        {{ __('Citas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')" class="text-black">
                        {{ __('Ventas') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blackfocus:outline-none transition ease-in-out duration-150" style="background-color: #83c5be !important; coloblack!important;" onmouseout="this.style.backgroundColor='#83c5be'">
                            <div>
                                {{ Auth::user()->name }}
                                
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-black hover:bg-gray-100">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-black hover:bg-gray-100" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-black  focus:outline-none focus:bg-blue-700 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-black">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="text-black">
                {{ __('Doctores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="text-black">
                {{ __('Secretarias') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="text-black">
                {{ __('Pacientes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="text-black">
                {{ __('Servicios') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-black-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-black-200">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-black">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-black" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

