<nav x-data="{ open: false }" class="bg-gradient-to-r from-slate-900 via-blue-900 to-blue-800 border-b border-blue-700 shadow-xl sticky top-0 z-50">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            {{-- === LOGO & BRANDING === --}}
            <div class="flex">
                <div class="shrink-0 flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="bg-white/10 p-2 rounded-full backdrop-blur-sm border border-white/20 shadow-inner hover:bg-white/20 transition">
                        <img src="{{ asset('images/logo-toyota.png') }}" alt="Logo Toyota" class="h-9 w-auto">
                    </a>
                    <div class="hidden md:block">
                        <span class="block text-white font-extrabold text-xl tracking-tight drop-shadow-md">WIRA TOYOTA</span>
                        <span class="block text-blue-300 text-xs font-bold tracking-widest uppercase">BODY & PAINT</span>
                    </div>
                </div>

                {{-- === NAVIGASI DESKTOP === --}}
                <div class="hidden space-x-1 sm:-my-px sm:ms-4 sm:flex items-center">
                    
                    @php
                        $navBase = "inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium transition-all duration-300 ease-out whitespace-nowrap";
                        $active = "bg-white text-blue-900 shadow-[0_0_15px_rgba(255,255,255,0.3)] transform -translate-y-0.5 font-bold";
                        $inactive = "text-blue-100 hover:bg-white/10 hover:text-white hover:shadow-lg";
                    @endphp

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="{{ $navBase }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                        <i class="fa-solid fa-desktop mr-2 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-blue-400' }}"></i> 
                        Dashboard
                    </a>

                    {{-- <div class="h-8 w-px bg-white/10 mx-1"></div> --}}

                    {{-- Data Master Group --}}
                    <a href="{{ route('customers.index') }}" class="{{ $navBase }} {{ request()->routeIs('customers.*') ? $active : $inactive }}">
                        <i class="fa-solid fa-users mr-2"></i> Customer
                    </a>
                    <a href="{{ route('spk.index') }}" class="{{ $navBase }} {{ request()->routeIs('spk.*') ? $active : $inactive }}">
                        <i class="fa-solid fa-file-signature mr-2"></i> SPK
                    </a>
                    <a href="{{ route('sparepart.index') }}" class="{{ $navBase }} {{ request()->routeIs('sparepart.*') ? $active : $inactive }}">
                        <i class="fa-solid fa-gears mr-2"></i> Sparepart
                    </a>
                    <a href="{{ route('mekanik.index') }}" class="{{ $navBase }} {{ request()->routeIs('mekanik.*') ? $active : $inactive }}">
                        <i class="fa-solid fa-user-gear mr-2"></i> Mekanik
                    </a>

                    {{-- <div class="h-8 w-px bg-white/10 mx-1"></div> --}}

                    {{-- Proses Group --}}
                    <a href="{{ route('body.index') }}" class="{{ $navBase }} {{ request()->routeIs('body.*') ? $active : $inactive }}" title="Body Repair">
                        <i class="fa-solid fa-car-burst text-lg mr-1.5"></i> Body
                    </a>
                    <a href="{{ route('preparation.index') }}" class="{{ $navBase }} {{ request()->routeIs('preparation.*') ? $active : $inactive }}" title="Preparation">
                        <i class="fa-solid fa-spray-can-sparkles text-lg mr-1.5"></i> Prep
                    </a>
                    <a href="{{ route('paint.index') }}" class="{{ $navBase }} {{ request()->routeIs('paint.*') ? $active : $inactive }}" title="Paint">
                        <i class="fa-solid fa-paint-roller text-lg mr-1.5"></i> Paint
                    </a>
                    <a href="{{ route('poles.index') }}" class="{{ $navBase }} {{ request()->routeIs('poles.*') ? $active : $inactive }}" title="Poles">
                        <i class="fa-solid fa-broom text-lg mr-1.5"></i> Poles
                    </a>
                </div>
            </div>

            {{-- === USER DROPDOWN (KANAN) === --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2 py-2 border border-white/20 text-sm leading-4 font-medium rounded-full text-white bg-white/5 hover:bg-white/10 focus:outline-none transition ease-in-out duration-150 shadow-md backdrop-blur-md">
                            {{-- Avatar dari Inisial Nama --}}
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="w-6 h-6 rounded-full mr-2 border border-white" alt="Avatar">
                            
                            {{-- 🔥 TEKNIK SINGKAT NAMA: Ambil kata pertama saja --}}
                            {{-- strtok(String, " ") bakal motong string pas ketemu spasi pertama --}}
                            <div>{{ strtok(Auth::user()->name, " ") }}</div>
                            
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <span class="block text-xs text-gray-500">Signed in as</span>
                            {{-- Di dropdown tetap tampilkan nama lengkap biar jelas --}}
                            <span class="block text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-blue-50">
                            <i class="fa-solid fa-user mr-2 text-blue-500"></i> {{ ('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 font-semibold hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> {{ ('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- === HAMBURGER MENU (MOBILE) === --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- === MOBILE MENU CONTENT === --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-white/10 shadow-inner">
        <div class="pt-2 pb-3 space-y-1 px-2">
            
            @php
                $mobBase = "block w-full px-4 py-3 rounded-lg text-base font-medium transition duration-150 ease-in-out flex items-center";
                $mobActive = "bg-blue-600 text-white shadow-lg";
                $mobInactive = "text-blue-100 hover:bg-white/10 hover:text-white";
            @endphp

            <a href="{{ route('dashboard') }}" class="{{ $mobBase }} {{ request()->routeIs('dashboard') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-desktop w-6 text-center mr-3"></i> Dashboard
            </a>
            
            <div class="px-4 pt-4 pb-1 text-xs font-bold text-blue-400 uppercase tracking-widest">Data Master</div>
            
            <a href="{{ route('customers.index') }}" class="{{ $mobBase }} {{ request()->routeIs('customers.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-users w-6 text-center mr-3"></i> Customers
            </a>
            <a href="{{ route('spk.index') }}" class="{{ $mobBase }} {{ request()->routeIs('spk.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-file-signature w-6 text-center mr-3"></i> SPK
            </a>
            <a href="{{ route('sparepart.index') }}" class="{{ $mobBase }} {{ request()->routeIs('sparepart.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-gears w-6 text-center mr-3"></i> Sparepart
            </a>
            <a href="{{ route('mekanik.index') }}" class="{{ $mobBase }} {{ request()->routeIs('mekanik.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-user-gear w-6 text-center mr-3"></i> Mekanik
            </a>

            <div class="px-4 pt-4 pb-1 text-xs font-bold text-blue-400 uppercase tracking-widest">Proses Bengkel</div>

            <a href="{{ route('body.index') }}" class="{{ $mobBase }} {{ request()->routeIs('body.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-car-burst w-6 text-center mr-3"></i> Body Repair
            </a>
            <a href="{{ route('preparation.index') }}" class="{{ $mobBase }} {{ request()->routeIs('preparation.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-spray-can-sparkles w-6 text-center mr-3"></i> Preparation
            </a>
            <a href="{{ route('paint.index') }}" class="{{ $mobBase }} {{ request()->routeIs('paint.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-paint-roller w-6 text-center mr-3"></i> Paint
            </a>
            <a href="{{ route('poles.index') }}" class="{{ $mobBase }} {{ request()->routeIs('poles.*') ? $mobActive : $mobInactive }}">
                <i class="fa-solid fa-broom w-6 text-center mr-3"></i> Poles
            </a>
        </div>
    </div>
</nav>