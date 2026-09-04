{{-- =========================================================
     ARCHITECTURE & CONSTRUCTION NAVBAR (CHỐNG RUNG GIẬT)
     resources/views/components/navbar.blade.php
     ========================================================= --}}

<nav
    x-data="{ 
        open: false, 
        scrolled: false,
        checkScroll() {
            const y = window.scrollY;
            if (y > 50) {
                this.scrolled = true;
            } else if (y < 10) {
                this.scrolled = false;
            }
        }
    }"
    x-init="
        checkScroll();
        window.addEventListener('scroll', () => checkScroll(), { passive: true });
    "
    @keydown.escape.window="open = false"
    class="fixed inset-x-0 top-0 z-[100] h-20 transition-colors duration-300 select-none"
    :class="scrolled 
        ? 'bg-white/95 shadow-[0_10px_35px_rgba(30,43,77,0.08)] backdrop-blur-md border-b border-slate-200/80' 
        : 'bg-gradient-to-b from-black/70 via-black/30 to-transparent'"
>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 h-full">

        {{-- Khóa cố định chiều cao h-full (80px), không thay đổi h- khi cuộn --}}
        <div class="flex h-full items-center justify-between">

            {{-- =================================================
                 LOGO: CỐ ĐỊNH KÍCH THƯỚC KHÔNG ĐỔI
                 ================================================= --}}
            <a href="{{ route('home') }}" class="relative z-[110] flex items-center" @click="open = false">
                <div class="relative h-14 w-auto flex items-center">
                    {{-- Logo đầu trang --}}
                    <img
                        x-show="!scrolled"
                        src="{{ asset('images/TMN_logo_ngang.png') }}"
                        alt="Tân Minh Nhân Corporation"
                        class="h-full w-auto max-h-[52px] object-contain"
                        onerror="this.src='https://www.tanminhnhan.com.vn/images/ap-smart-layerslider/homepage/logo.png'"
                        loading="eager"
                    />

                    {{-- Logo khi cuộn trang --}}
                    <img
                        x-show="scrolled"
                        x-cloak
                        src="{{ asset('images/TMN_logo_ngang_R.png') }}"
                        alt="Tân Minh Nhân Corporation"
                        class="h-full w-auto max-h-[52px] object-contain"
                        onerror="this.src='https://www.tanminhnhan.com.vn/images/ap-smart-layerslider/homepage/logo.png'"
                        loading="eager"
                    />
                </div>
            </a>


            {{-- =================================================
                 DESKTOP NAVIGATION
                 ================================================= --}}
            <div class="hidden items-center lg:flex">

                <div class="flex items-center gap-8 text-xs font-bold uppercase tracking-wider">

                    {{-- 1. Trang chủ --}}
                    <a
                        href="{{ route('home') }}"
                        class="relative py-2 transition-colors duration-200 {{ request()->routeIs('home') ? '!text-red-600 after:w-full' : 'hover:!text-red-500 after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:transition-all after:duration-300 hover:after:w-full"
                        :style="!scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }} ? 'color: #ffffff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : (scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }} ? 'color: #1E2B4D !important;' : '')"
                    >
                        Trang chủ
                    </a>

                    {{-- 2. Về chúng tôi --}}
                    <a
                        href="{{ route('about') }}"
                        class="relative py-2 transition-colors duration-200 {{ request()->routeIs('about*') ? '!text-red-600 after:w-full' : 'hover:!text-red-500 after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:transition-all after:duration-300 hover:after:w-full"
                        :style="!scrolled && !{{ request()->routeIs('about*') ? 'true' : 'false' }} ? 'color: #ffffff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : (scrolled && !{{ request()->routeIs('about*') ? 'true' : 'false' }} ? 'color: #1E2B4D !important;' : '')"
                    >
                        Giới thiệu
                    </a>

                    {{-- 3. Dự án --}}
                    <a
                        href="{{ route('projects.index') }}"
                        class="relative py-2 transition-colors duration-200 {{ request()->routeIs('projects*') ? '!text-red-600 after:w-full' : 'hover:!text-red-500 after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:transition-all after:duration-300 hover:after:w-full"
                        :style="!scrolled && !{{ request()->routeIs('projects*') ? 'true' : 'false' }} ? 'color: #ffffff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : (scrolled && !{{ request()->routeIs('projects*') ? 'true' : 'false' }} ? 'color: #1E2B4D !important;' : '')"
                    >
                        Dự án
                    </a>

                    {{-- 4. Tuyển dụng --}}
                    <a
                        href="{{ route('careers.index') }}"
                        class="relative py-2 transition-colors duration-200 {{ request()->routeIs('careers*') ? '!text-red-600 after:w-full' : 'hover:!text-red-500 after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:transition-all after:duration-300 hover:after:w-full"
                        :style="!scrolled && !{{ request()->routeIs('careers*') ? 'true' : 'false' }} ? 'color: #ffffff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : (scrolled && !{{ request()->routeIs('careers*') ? 'true' : 'false' }} ? 'color: #1E2B4D !important;' : '')"
                    >
                        Tuyển dụng
                    </a>

                    {{-- 5. Tin tức --}}
                    <a
                        href="{{ route('news.index') }}"
                        class="relative py-2 transition-colors duration-200 {{ request()->routeIs('news*') ? '!text-red-600 after:w-full' : 'hover:!text-red-500 after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:transition-all after:duration-300 hover:after:w-full"
                        :style="!scrolled && !{{ request()->routeIs('news*') ? 'true' : 'false' }} ? 'color: #ffffff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : (scrolled && !{{ request()->routeIs('news*') ? 'true' : 'false' }} ? 'color: #1E2B4D !important;' : '')"
                    >
                        Tin tức
                    </a>

                    {{-- 6. Liên hệ --}}
                    <a
                        href="{{ route('contact.index') }}"
                        class="relative py-2 transition-colors duration-200 {{ request()->routeIs('contact*') ? '!text-red-600 after:w-full' : 'hover:!text-red-500 after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:transition-all after:duration-300 hover:after:w-full"
                        :style="!scrolled && !{{ request()->routeIs('contact*') ? 'true' : 'false' }} ? 'color: #ffffff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : (scrolled && !{{ request()->routeIs('contact*') ? 'true' : 'false' }} ? 'color: #1E2B4D !important;' : '')"
                    >
                        Liên hệ
                    </a>

                </div>

            </div>


            {{-- =================================================
                 MOBILE CONTROLS (HAMBURGER)
                 ================================================= --}}
            <div class="flex items-center lg:hidden">
                <button
                    type="button"
                    @click="open = !open"
                    class="relative z-[110] flex h-10 w-10 items-center justify-center focus:outline-none"
                    aria-label="Mở điều hướng"
                >
                    <div class="relative h-5 w-6">
                        <span
                            class="absolute left-0 top-0 h-[2px] w-6 transition-all duration-300"
                            :class="open ? 'translate-y-[9px] rotate-45 bg-white' : (scrolled ? 'bg-[#1E2B4D]' : 'bg-white')"
                        ></span>
                        <span
                            class="absolute left-0 top-[9px] h-[2px] w-4 transition-all duration-300"
                            :class="open ? 'opacity-0' : (scrolled ? 'bg-[#1E2B4D]' : 'bg-white')"
                        ></span>
                        <span
                            class="absolute left-0 top-[18px] h-[2px] w-6 transition-all duration-300"
                            :class="open ? '-translate-y-[9px] -rotate-45 bg-white' : (scrolled ? 'bg-[#1E2B4D]' : 'bg-white')"
                        ></span>
                    </div>
                </button>
            </div>

        </div>

    </div>


    {{-- =========================================================
         MOBILE MENU OVERLAY
         ========================================================= --}}
    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] bg-[#0F172A] lg:hidden flex flex-col"
    >
        <div class="flex h-20 items-center border-b border-white/10 px-6">
            <img
                src="{{ asset('images/TMN_logo_ngang.png') }}"
                alt="Tân Minh Nhân Corporation"
                class="h-12 w-auto max-h-[48px] object-contain"
            />
        </div>

        <div class="flex flex-1 flex-col justify-center px-6 overflow-y-auto space-y-2">
            <a href="{{ route('home') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase transition-colors {{ request()->routeIs('home') ? 'text-red-500' : 'text-white hover:text-red-400' }}">
                <span>Trang chủ</span>
                <span class="text-xs font-mono {{ request()->routeIs('home') ? 'text-red-500' : 'text-white/40' }}">01</span>
            </a>
            <a href="{{ route('about') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase transition-colors {{ request()->routeIs('about*') ? 'text-red-500' : 'text-white hover:text-red-400' }}">
                <span>Về chúng tôi</span>
                <span class="text-xs font-mono {{ request()->routeIs('about*') ? 'text-red-500' : 'text-white/40' }}">02</span>
            </a>
            <a href="{{ route('projects.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase transition-colors {{ request()->routeIs('projects*') ? 'text-red-500' : 'text-white hover:text-red-400' }}">
                <span>Dự án</span>
                <span class="text-xs font-mono {{ request()->routeIs('projects*') ? 'text-red-500' : 'text-white/40' }}">03</span>
            </a>
            <a href="{{ route('careers.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase transition-colors {{ request()->routeIs('careers*') ? 'text-red-500' : 'text-white hover:text-red-400' }}">
                <span>Tuyển dụng</span>
                <span class="text-xs font-mono {{ request()->routeIs('careers*') ? 'text-red-500' : 'text-white/40' }}">04</span>
            </a>
            <a href="{{ route('news.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase transition-colors {{ request()->routeIs('news*') ? 'text-red-500' : 'text-white hover:text-red-400' }}">
                <span>Tin tức</span>
                <span class="text-xs font-mono {{ request()->routeIs('news*') ? 'text-red-500' : 'text-white/40' }}">05</span>
            </a>
            <a href="{{ route('contact.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase transition-colors {{ request()->routeIs('contact*') ? 'text-red-500' : 'text-white hover:text-red-400' }}">
                <span>Liên hệ</span>
                <span class="text-xs font-mono {{ request()->routeIs('contact*') ? 'text-red-500' : 'text-white/40' }}">06</span>
            </a>
        </div>
    </div>

</nav>