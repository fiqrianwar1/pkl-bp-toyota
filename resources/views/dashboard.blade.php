<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 flex items-center gap-3">
            {{-- GANTI fa-gauge JADI fa-border-all --}}
            <i class="fa-solid fa-desktop text-blue-600 animate-pulse"></i>
            {{ ('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Container Utama --}}
    <div class="py-10 bg-[#f3f4f6] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12 animate-fadeIn">

            {{-- ================================================= --}}
            {{-- 🔥 BAGIAN 1: SLIDER CINEMATIC (8 SLIDE) 🔥 --}}
            {{-- ================================================= --}}
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden relative group border border-white/50" x-data="{ activeSlide: 1, slides: [1, 2, 3, 4, 5, 6, 7, 8] }">
                
                {{-- Slide Container --}}
                <div class="relative h-80 md:h-[500px] w-full bg-gray-900">
                    
                    {{-- Slide 1 --}}
                    <div x-show="activeSlide === 1" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out">
                        <img src="{{ asset('images/slide1.jpg') }}" class="w-full h-full object-cover opacity-90" alt="Slide 1">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Bengkel Body & Paint</h3>
                            <p class="text-gray-300 mt-2 text-lg">Wira Toyota Banjarmasin.</p>
                        </div>
                    </div>

                    {{-- Slide 2 --}}
                    <div x-show="activeSlide === 2" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <img src="{{ asset('images/slide2.jpg') }}" class="w-full h-full object-cover" alt="Slide 2">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Ruang Oven</h3>
                            <p class="text-gray-300 mt-2 text-lg">Teknologi Pengecatan Modern.</p>
                        </div>
                    </div>

                    {{-- Slide 3 --}}
                    <div x-show="activeSlide === 3" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <img src="{{ asset('images/slide3.jpg') }}" class="w-full h-full object-cover" alt="Slide 3">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Preparation Area</h3>
                            <p class="text-gray-300 mt-2 text-lg">Proses Awal yang Presisi.</p>
                        </div>
                    </div>
                    
                    {{-- Slide 4 --}}
                    <div x-show="activeSlide === 4" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <img src="{{ asset('images/slide4.jpg') }}" class="w-full h-full object-cover" alt="Slide 4">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Epoxy & Surfacer</h3>
                            <p class="text-gray-300 mt-2 text-lg">Dasar Pengecatan Sempurna.</p>
                        </div>
                    </div>

                    {{-- Slide 5 --}}
                    <div x-show="activeSlide === 5" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <img src="{{ asset('images/slide5.jpg') }}" class="w-full h-full object-cover" alt="Slide 5">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Body Repair</h3>
                            <p class="text-gray-300 mt-2 text-lg">Perbaikan Struktur Kendaraan.</p>
                        </div>
                    </div>

                    {{-- 🔥 SLIDE 6: VIDEO 🔥 --}}
                    <div x-show="activeSlide === 6" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <video class="w-full h-full object-cover" autoplay loop muted playsinline>
                            <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">
                            Browser Anda tidak mendukung video tag.
                        </video>
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Dokumentasi Video</h3>
                            <p class="text-gray-300 mt-2 text-lg">Suasana Pengerjaan di Bengkel.</p>
                        </div>
                    </div>

                    {{-- Slide 7 --}}
                    <div x-show="activeSlide === 7" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <img src="{{ asset('images/slide7.jpg') }}" class="w-full h-full object-cover" alt="Slide 7">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Polishing</h3>
                            <p class="text-gray-300 mt-2 text-lg">Sentuhan Akhir Mengkilap.</p>
                        </div>
                    </div>

                    {{-- Slide 8 --}}
                    <div x-show="activeSlide === 8" class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" style="display: none;">
                        <img src="{{ asset('images/slide8.jpg') }}" class="w-full h-full object-cover" alt="Slide 8">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/60 to-transparent p-10">
                            <h3 class="text-white text-3xl font-extrabold tracking-tight">Gudang Sparepart</h3>
                            <p class="text-gray-300 mt-2 text-lg">Ketersediaan Suku Cadang Asli.</p>
                        </div>
                    </div>

                </div>

                {{-- Navigasi Slider --}}
                <div class="absolute inset-0 flex justify-between items-center px-4 pointer-events-none">
                    <button @click="activeSlide = activeSlide === 1 ? slides.length : activeSlide - 1" 
                            class="pointer-events-auto bg-white/10 backdrop-blur-md text-white p-4 rounded-full hover:bg-white/30 transition shadow-lg border border-white/20">
                        <i class="fa-solid fa-chevron-left text-xl"></i>
                    </button>
                    <button @click="activeSlide = activeSlide === slides.length ? 1 : activeSlide + 1" 
                            class="pointer-events-auto bg-white/10 backdrop-blur-md text-white p-4 rounded-full hover:bg-white/30 transition shadow-lg border border-white/20">
                        <i class="fa-solid fa-chevron-right text-xl"></i>
                    </button>
                </div>
            </div>


            {{-- ================================================= --}}
            {{-- 🔥 BAGIAN 2: DATA MASTER (ANALYTICS STYLE) 🔥 --}}
            {{-- ================================================= --}}
            <div class="flex items-center gap-4 mb-4 mt-8">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600"><i class="fa-solid fa-database"></i></div>
                <h3 class="text-xl font-bold text-gray-800">Overview Data Master</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                {{-- 1. Customer Card --}}
                <div class="relative bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group overflow-hidden border border-gray-100">
                    {{-- Decorative Chart Line (SVG) --}}
                    <svg class="absolute bottom-0 left-0 w-full h-16 text-blue-50 opacity-50" viewBox="0 0 100 40" preserveAspectRatio="none">
                        <path d="M0 40 L0 20 L20 25 L40 10 L60 30 L80 15 L100 35 L100 40 Z" fill="currentColor"/>
                    </svg>

                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest">Customers</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform duration-300">{{ $totalCustomers ?? 0 }}</h4>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-tr from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-8 relative z-10">
                        <a href="{{ route('customers.index') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600 flex items-center gap-2 transition-colors">
                            Lihat Database <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- 2. SPK Card --}}
                <div class="relative bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group overflow-hidden border border-gray-100">
                    <svg class="absolute bottom-0 left-0 w-full h-16 text-indigo-50 opacity-50" viewBox="0 0 100 40" preserveAspectRatio="none">
                        <path d="M0 40 L0 30 L20 15 L40 25 L60 10 L80 20 L100 5 L100 40 Z" fill="currentColor"/>
                    </svg>
                    
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Total SPK</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform duration-300">{{ $totalSpk ?? 0 }}</h4>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-tr from-indigo-500 to-purple-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fa-solid fa-file-signature text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-8 relative z-10">
                        <a href="{{ route('spk.index') }}" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 flex items-center gap-2 transition-colors">
                            Lihat Data <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- 3. Sparepart Card --}}
                <div class="relative bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group overflow-hidden border border-gray-100">
                    <svg class="absolute bottom-0 left-0 w-full h-16 text-emerald-50 opacity-50" viewBox="0 0 100 40" preserveAspectRatio="none">
                        <path d="M0 40 L0 25 L30 35 L50 15 L70 25 L100 10 L100 40 Z" fill="currentColor"/>
                    </svg>

                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Spareparts</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform duration-300">{{ $totalSparepart ?? 0 }}</h4>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fa-solid fa-gears text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-8 relative z-10">
                        <a href="{{ route('sparepart.index') }}" class="text-sm font-semibold text-gray-500 hover:text-emerald-600 flex items-center gap-2 transition-colors">
                            Cek Stok <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- 4. Mekanik Card --}}
                <div class="relative bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group overflow-hidden border border-gray-100">
                    <svg class="absolute bottom-0 left-0 w-full h-16 text-orange-50 opacity-50" viewBox="0 0 100 40" preserveAspectRatio="none">
                        <path d="M0 40 L0 20 L25 30 L50 10 L75 25 L100 15 L100 40 Z" fill="currentColor"/>
                    </svg>

                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold text-orange-400 uppercase tracking-widest">Tim Mekanik</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform duration-300">{{ $totalMekanik ?? 0 }}</h4>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-tr from-orange-500 to-amber-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-200 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fa-solid fa-user-gear text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-8 relative z-10">
                        <a href="{{ route('mekanik.index') }}" class="text-sm font-semibold text-gray-500 hover:text-orange-600 flex items-center gap-2 transition-colors">
                            Lihat Personil <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>


            {{-- ================================================= --}}
            {{-- 🔥 BAGIAN 3: PROSES PENGERJAAN (VIVID GRADIENT) 🔥 --}}
            {{-- ================================================= --}}
            <div class="flex items-center gap-4 mb-4 mt-8">
                <div class="p-2 bg-red-100 rounded-lg text-red-600"><i class="fa-solid fa-list-check"></i></div>
                <h3 class="text-xl font-bold text-gray-800">Workflow Bengkel</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                {{-- 1. Body Repair (Vivid Red) --}}
                <a href="{{ route('body.index') }}" class="group relative rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-48">
                    {{-- Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-red-600 to-rose-800 opacity-90 group-hover:opacity-100 transition-opacity"></div>
                    {{-- Decorative Icon --}}
                    <i class="fa-solid fa-car-burst absolute -bottom-4 -right-4 text-9xl text-white opacity-10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
                    
                    {{-- Content --}}
                    <div class="relative z-10 p-6 flex flex-col h-full justify-between">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-2xl border border-white/30 shadow-inner">
                            <i class="fa-solid fa-car-burst"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-white tracking-wide">Body Repair</h4>
                            <p class="text-red-100 text-sm mt-1 flex items-center gap-2">
                                Masuk Proses <i class="fa-solid fa-arrow-right text-xs"></i>
                            </p>
                        </div>
                    </div>
                </a>

                {{-- 2. Preparation (Vivid Yellow/Orange) --}}
                <a href="{{ route('preparation.index') }}" class="group relative rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-48">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-600 opacity-90 group-hover:opacity-100 transition-opacity"></div>
                    <i class="fa-solid fa-spray-can-sparkles absolute -bottom-4 -right-4 text-9xl text-white opacity-10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
                    
                    <div class="relative z-10 p-6 flex flex-col h-full justify-between">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-2xl border border-white/30 shadow-inner">
                            <i class="fa-solid fa-spray-can-sparkles"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-white tracking-wide">Preparation</h4>
                            <p class="text-orange-50 text-sm mt-1 flex items-center gap-2">
                                Masuk Proses <i class="fa-solid fa-arrow-right text-xs"></i>
                            </p>
                        </div>
                    </div>
                </a>

                {{-- 3. Paint (Vivid Blue) --}}
                <a href="{{ route('paint.index') }}" class="group relative rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-48">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700 opacity-90 group-hover:opacity-100 transition-opacity"></div>
                    <i class="fa-solid fa-paint-roller absolute -bottom-4 -right-4 text-9xl text-white opacity-10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
                    
                    <div class="relative z-10 p-6 flex flex-col h-full justify-between">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-2xl border border-white/30 shadow-inner">
                            <i class="fa-solid fa-paint-roller"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-white tracking-wide">Paint</h4>
                            <p class="text-blue-100 text-sm mt-1 flex items-center gap-2">
                                Masuk Proses <i class="fa-solid fa-arrow-right text-xs"></i>
                            </p>
                        </div>
                    </div>
                </a>

                {{-- 4. Poles (Vivid Purple) --}}
                <a href="{{ route('poles.index') }}" class="group relative rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-48">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-fuchsia-700 opacity-90 group-hover:opacity-100 transition-opacity"></div>
                    <i class="fa-solid fa-broom absolute -bottom-4 -right-4 text-9xl text-white opacity-10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
                    
                    <div class="relative z-10 p-6 flex flex-col h-full justify-between">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-2xl border border-white/30 shadow-inner">
                            <i class="fa-solid fa-broom"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-white tracking-wide">Poles</h4>
                            <p class="text-purple-100 text-sm mt-1 flex items-center gap-2">
                                Masuk Proses <i class="fa-solid fa-arrow-right text-xs"></i>
                            </p>
                        </div>
                    </div>
                </a>
            </div>


            {{-- ================================================= --}}
            {{-- 🔥 BAGIAN STRUKTUR ORGANISASI (MODERN LIGHT) 🔥 --}}
            {{-- ================================================= --}}
            <div class="bg-white rounded-3xl shadow-xl p-10 mt-12 border border-gray-100 relative overflow-hidden">
                
                {{-- Dekorasi Background --}}
                <div class="absolute top-0 right-0 p-10 opacity-5">
                    <i class="fa-solid fa-sitemap text-9xl text-blue-900"></i>
                </div>

                {{-- Judul Section --}}
                <div class="text-center mb-16 relative z-10">
                    <h2 class="text-3xl font-extrabold uppercase tracking-widest text-gray-800">Struktur Organisasi</h2>
                    <div class="h-1.5 w-24 bg-blue-600 mx-auto mt-4 rounded-full"></div>
                    <p class="text-gray-500 mt-3 text-sm font-medium tracking-wide">BENGKEL BODY & PAINT WIRA TOYOTA</p>
                </div>

                <div class="flex flex-col items-center w-full relative z-10">
                    
                    {{-- LEVEL 1: KEPALA BENGKEL --}}
                    <div class="relative z-10 group">
                        <div class="bg-gradient-to-r from-blue-700 to-blue-600 text-white w-72 py-4 rounded-2xl shadow-lg shadow-blue-200 text-center transform group-hover:-translate-y-1 transition duration-300 border-b-4 border-blue-900">
                            <div class="text-[10px] font-bold text-blue-100 uppercase tracking-widest mb-1">Kepala Bengkel</div>
                            <div class="text-xl font-bold">{{ $kepala->nama ?? 'M SUGIANNOR' }}</div>
                        </div>
                        {{-- Garis ke Bawah --}}
                        <div class="absolute left-1/2 -bottom-10 w-0.5 h-10 bg-gray-300 transform -translate-x-1/2"></div>
                    </div>

                    {{-- Spacer --}}
                    <div class="h-10 w-full"></div>

                    {{-- LEVEL 2: SA & CONTROLLER --}}
                    <div class="relative w-full max-w-3xl">
                        {{-- Garis Horizontal Penghubung --}}
                        <div class="absolute top-0 left-[20%] right-[20%] h-0.5 bg-gray-300"></div>
                        {{-- Garis Vertikal Kecil --}}
                        <div class="absolute top-0 left-[20%] h-8 w-0.5 bg-gray-300"></div>
                        <div class="absolute top-0 right-[20%] h-8 w-0.5 bg-gray-300"></div>

                        <div class="flex justify-around mt-8">
                            {{-- Node SA --}}
                            <div class="bg-white border-l-4 border-cyan-500 w-60 py-3 px-5 shadow-md rounded-r-xl hover:shadow-xl transition duration-300 group">
                                <div class="flex items-center gap-3">
                                    <div class="bg-cyan-100 text-cyan-600 p-2 rounded-lg group-hover:bg-cyan-600 group-hover:text-white transition">
                                        <i class="fa-solid fa-headset"></i>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Service Advisor</div>
                                        <div class="text-gray-800 font-bold text-sm">{{ $advisor->nama ?? 'IMAM KHUDORI' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Node Controller --}}
                            <div class="bg-white border-l-4 border-indigo-500 w-60 py-3 px-5 shadow-md rounded-r-xl hover:shadow-xl transition duration-300 group">
                                <div class="flex items-center gap-3">
                                    <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Controller</div>
                                        <div class="text-gray-800 font-bold text-sm">{{ $controller->nama ?? 'FADHILLAH' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Garis Tengah Lanjut ke Bawah (Level 3) --}}
                        <div class="absolute top-0 left-1/2 h-full w-0.5 bg-gray-300 transform -translate-x-1/2 -z-10"></div>
                    </div>

                    {{-- Spacer --}}
                    <div class="h-10 w-full"></div>

                    {{-- LEVEL 3: FOREMAN --}}
                    <div class="relative z-10">
                        <div class="bg-gray-800 text-white w-64 py-3 rounded-xl shadow-lg text-center border-b-4 border-black">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Foreman / Leader</div>
                            <div class="text-lg font-bold">{{ $foreman->nama ?? 'EKO PURWANDI' }}</div>
                        </div>
                        {{-- Garis ke Bawah --}}
                        <div class="absolute left-1/2 -bottom-10 w-0.5 h-10 bg-gray-300 transform -translate-x-1/2"></div>
                    </div>

                    {{-- Spacer --}}
                    <div class="h-10 w-full"></div>

                    {{-- LEVEL 4: TEKNISI --}}
                    <div class="relative w-full max-w-5xl px-4">
                        {{-- Garis Horizontal Panjang --}}
                        <div class="border-t-2 border-gray-300 w-[80%] mx-auto mb-8"></div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            {{-- Tech 1 --}}
                            <div class="flex flex-col items-center relative group">
                                <div class="absolute -top-8 left-1/2 h-8 w-0.5 bg-gray-300"></div>
                                <div class="bg-white border border-gray-100 p-4 rounded-xl w-full text-center hover:bg-red-50 hover:border-red-200 transition duration-300 shadow-sm hover:shadow-md">
                                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3 text-lg group-hover:scale-110 transition">
                                        <i class="fa-solid fa-car-burst"></i>
                                    </div>
                                    <div class="font-bold text-gray-700 text-xs tracking-wider uppercase">Teknisi Body</div>
                                </div>
                            </div>

                            {{-- Tech 2 --}}
                            <div class="flex flex-col items-center relative group">
                                <div class="absolute -top-8 left-1/2 h-8 w-0.5 bg-gray-300"></div>
                                <div class="bg-white border border-gray-100 p-4 rounded-xl w-full text-center hover:bg-yellow-50 hover:border-yellow-200 transition duration-300 shadow-sm hover:shadow-md">
                                    <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-3 text-lg group-hover:scale-110 transition">
                                        <i class="fa-solid fa-spray-can"></i>
                                    </div>
                                    <div class="font-bold text-gray-700 text-xs tracking-wider uppercase">Teknisi Prep</div>
                                </div>
                            </div>

                            {{-- Tech 3 --}}
                            <div class="flex flex-col items-center relative group">
                                <div class="absolute -top-8 left-1/2 h-8 w-0.5 bg-gray-300"></div>
                                <div class="bg-white border border-gray-100 p-4 rounded-xl w-full text-center hover:bg-blue-50 hover:border-blue-200 transition duration-300 shadow-sm hover:shadow-md">
                                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 text-lg group-hover:scale-110 transition">
                                        <i class="fa-solid fa-paint-roller"></i>
                                    </div>
                                    <div class="font-bold text-gray-700 text-xs tracking-wider uppercase">Teknisi Paint</div>
                                </div>
                            </div>

                            {{-- Tech 4 --}}
                            <div class="flex flex-col items-center relative group">
                                <div class="absolute -top-8 left-1/2 h-8 w-0.5 bg-gray-300"></div>
                                <div class="bg-white border border-gray-100 p-4 rounded-xl w-full text-center hover:bg-purple-50 hover:border-purple-200 transition duration-300 shadow-sm hover:shadow-md">
                                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-3 text-lg group-hover:scale-110 transition">
                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                    </div>
                                    <div class="font-bold text-gray-700 text-xs tracking-wider uppercase">Teknisi Poles</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Script Auto Slide --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('carousel', () => ({
                activeSlide: 1,
                slides: [1, 2, 3, 4, 5, 6, 7, 8],
                init() {
                    setInterval(() => {
                        this.activeSlide = this.activeSlide === this.slides.length ? 1 : this.activeSlide + 1;
                    }, 5000);
                }
            }))
        })
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
</x-app-layout>