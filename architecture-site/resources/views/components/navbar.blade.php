{{-- =========================================================
     ARCHITECTURE & CONSTRUCTION NAVBAR
     resources/views/components/navbar.blade.php
     ========================================================= --}}

@php
    $isLightPage = request()->routeIs([
        'news.*',
        'projects.show',
        'contact.*',
        'careers.show',
    ]);
@endphp

<div
    x-data="{ 
        open: false, 
        isLightPage: {{ $isLightPage ? 'true' : 'false' }},
        scrolled: false,
        checkScroll() {
            if (this.isLightPage) {
                this.scrolled = true;
                return;
            }
            const y = window.scrollY;
            if (y > 40) {
                this.scrolled = true;
            } else if (y < 10) {
                this.scrolled = false;
            }
        }
    }"
    x-init="
        checkScroll();
        window.addEventListener('scroll', () => checkScroll(), { passive: true });
        $watch('open', value => {
            if (value) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        });
    "
    @keydown.escape.window="open = false"
>
    {{-- =========================================================
         THANH NAVBAR CHÍNH
         ========================================================= --}}
    <nav
        class="fixed inset-x-0 top-0 z-[100] h-20 transition-all duration-300 select-none"
        :class="scrolled 
            ? 'bg-white/95 shadow-[0_4px_25px_rgba(15,23,42,0.08)] backdrop-blur-md border-b border-slate-200/80' 
            : 'bg-gradient-to-b from-black/80 via-black/40 to-transparent'"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex h-full items-center justify-between">

                {{-- LOGO --}}
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="relative h-12 sm:h-14 w-auto flex items-center">
                        <img
                            x-show="!scrolled"
                            src="{{ asset('images/TMN_logo_ngang.webp') }}"
                            alt="Tân Minh Nhân Corporation"
                            class="h-full w-auto max-h-[44px] sm:max-h-[50px] object-contain"
                            onerror="this.src='https://www.tanminhnhan.com.vn/images/ap-smart-layerslider/homepage/logo.png'"
                            loading="eager"
                        />
                        <img
                            x-show="scrolled"
                            x-cloak
                            src="{{ asset('images/TMN_logo_ngang_R.png') }}"
                            alt="Tân Minh Nhân Corporation"
                            class="h-full w-auto max-h-[44px] sm:max-h-[50px] object-contain"
                            onerror="this.src='https://www.tanminhnhan.com.vn/images/ap-smart-layerslider/homepage/logo.png'"
                            loading="eager"
                        />
                    </div>
                </a>

                {{-- DESKTOP MENU --}}
                <div class="hidden items-center lg:flex">
                    <div class="flex items-center gap-7 xl:gap-8 text-xs font-bold uppercase tracking-wider">
                        <a href="{{ route('home') }}" class="relative py-2 transition-colors duration-200 {{ request()->routeIs('home') ? '!text-[#EB323A] after:w-full' : 'hover:!text-[#EB323A] after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-[#EB323A] after:transition-all after:duration-300 hover:after:w-full"
                            :style="!scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }} ? 'color: #ffffff !important;' : (scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }} ? 'color: #264abc !important;' : '')">
                            Trang chủ
                        </a>
                        <a href="{{ route('about') }}" class="relative py-2 transition-colors duration-200 {{ request()->routeIs('about*') ? '!text-[#EB323A] after:w-full' : 'hover:!text-[#EB323A] after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-[#EB323A] after:transition-all after:duration-300 hover:after:w-full"
                            :style="!scrolled && !{{ request()->routeIs('about*') ? 'true' : 'false' }} ? 'color: #ffffff !important;' : (scrolled && !{{ request()->routeIs('about*') ? 'true' : 'false' }} ? 'color: #264abc !important;' : '')">
                            Giới thiệu
                        </a>
                        <a href="{{ route('projects.index') }}" class="relative py-2 transition-colors duration-200 {{ request()->routeIs('projects*') ? '!text-[#EB323A] after:w-full' : 'hover:!text-[#EB323A] after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-[#EB323A] after:transition-all after:duration-300 hover:after:w-full"
                            :style="!scrolled && !{{ request()->routeIs('projects*') ? 'true' : 'false' }} ? 'color: #ffffff !important;' : (scrolled && !{{ request()->routeIs('projects*') ? 'true' : 'false' }} ? 'color: #264abc !important;' : '')">
                            Dự án
                        </a>
                        <a href="{{ route('careers.index') }}" class="relative py-2 transition-colors duration-200 {{ request()->routeIs('careers*') ? '!text-[#EB323A] after:w-full' : 'hover:!text-[#EB323A] after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-[#EB323A] after:transition-all after:duration-300 hover:after:w-full"
                            :style="!scrolled && !{{ request()->routeIs('careers*') ? 'true' : 'false' }} ? 'color: #ffffff !important;' : (scrolled && !{{ request()->routeIs('careers*') ? 'true' : 'false' }} ? 'color: #264abc !important;' : '')">
                            Tuyển dụng
                        </a>
                        <a href="{{ route('news.index') }}" class="relative py-2 transition-colors duration-200 {{ request()->routeIs('news*') ? '!text-[#EB323A] after:w-full' : 'hover:!text-[#EB323A] after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-[#EB323A] after:transition-all after:duration-300 hover:after:w-full"
                            :style="!scrolled && !{{ request()->routeIs('news*') ? 'true' : 'false' }} ? 'color: #ffffff !important;' : (scrolled && !{{ request()->routeIs('news*') ? 'true' : 'false' }} ? 'color: #264abc !important;' : '')">
                            Tin tức
                        </a>
                        <a href="{{ route('contact.index') }}" class="relative py-2 transition-colors duration-200 {{ request()->routeIs('contact*') ? '!text-[#EB323A] after:w-full' : 'hover:!text-[#EB323A] after:w-0' }} after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-[#EB323A] after:transition-all after:duration-300 hover:after:w-full"
                            :style="!scrolled && !{{ request()->routeIs('contact*') ? 'true' : 'false' }} ? 'color: #ffffff !important;' : (scrolled && !{{ request()->routeIs('contact*') ? 'true' : 'false' }} ? 'color: #264abc !important;' : '')">
                            Liên hệ
                        </a>
                    </div>
                </div>

                {{-- NÚT HAMBURGER MOBILE --}}
                <div class="flex items-center lg:hidden">
                    <button
                        type="button"
                        @click="open = true"
                        class="flex h-10 w-10 items-center justify-center focus:outline-none cursor-pointer"
                        aria-label="Mở menu"
                    >
                        <div class="relative h-5 w-6 flex flex-col justify-between">
                            <span class="h-[2.5px] w-6 rounded-full transition-all duration-300" :class="scrolled ? '!bg-[#0F172A]' : '!bg-white'"></span>
                            <span class="h-[2.5px] w-4 rounded-full transition-all duration-300" :class="scrolled ? '!bg-[#0F172A]' : '!bg-white'"></span>
                            <span class="h-[2.5px] w-6 rounded-full transition-all duration-300" :class="scrolled ? '!bg-[#0F172A]' : '!bg-white'"></span>
                        </div>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    {{-- =========================================================
         MOBILE MENU OVERLAY: ĐÈ LÊN MỌI THÀNH PHẦN (Z-[99999])
         ========================================================= --}}
    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[99999] h-screen w-screen bg-[#0F172A] text-white flex flex-col justify-between overflow-hidden select-none"
    >
        {{-- Header của Mobile Menu --}}
        {{-- Header của Mobile Menu --}}
        <div class="flex h-16 sm:h-20 items-center justify-between border-b border-white/10 px-4 sm:px-6 shrink-0 bg-[#0F172A]">
            <a href="{{ route('home') }}" @click="open = false" class="flex items-center py-2">
                <img
                    src="{{ asset('images/TMN_logo_ngang.webp') }}"
                    alt="Tân Minh Nhân Corporation"
                    class="h-8 sm:h-10 w-auto max-w-[200px] sm:max-w-[240px] object-contain object-left block"
                    onerror="this.src='https://www.tanminhnhan.com.vn/images/ap-smart-layerslider/homepage/logo.png'"
                />
            </a>
            
            <button
                type="button"
                @click="open = false"
                class="flex h-9 w-9 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full bg-white/10 text-white hover:bg-[#EB323A] transition-colors focus:outline-none cursor-pointer ml-4"
                aria-label="Đóng menu"
            >
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Danh sách điều hướng Mobile (Ép chữ màu trắng sáng rõ) --}}
        <div class="flex-1 overflow-y-auto px-6 py-8 flex flex-col justify-center space-y-2 bg-[#0F172A]">
            
            {{-- 1. Trang chủ --}}
            <a href="{{ route('home') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('home') ? '!text-[#EB323A]' : '!text-white hover:!text-[#EB323A]' }}">
                <span class="!text-white {{ request()->routeIs('home') ? '!text-[#EB323A]' : '' }}">Trang chủ</span>
                <!-- <span class="text-xs font-mono text-slate-400">01</span> -->
            </a>

            {{-- 2. Giới thiệu --}}
            <a href="{{ route('about') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('about*') ? '!text-[#EB323A]' : '!text-white hover:!text-[#EB323A]' }}">
                <span class="!text-white {{ request()->routeIs('about*') ? '!text-[#EB323A]' : '' }}">Giới thiệu</span>
                <!-- <span class="text-xs font-mono text-slate-400">02</span> -->
            </a>

            {{-- 3. Dự án --}}
            <a href="{{ route('projects.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('projects*') ? '!text-[#EB323A]' : '!text-white hover:!text-[#EB323A]' }}">
                <span class="!text-white {{ request()->routeIs('projects*') ? '!text-[#EB323A]' : '' }}">Dự án</span>
                <!-- <span class="text-xs font-mono text-slate-400">03</span> -->
            </a>

            {{-- 4. Tuyển dụng --}}
            <a href="{{ route('careers.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('careers*') ? '!text-[#EB323A]' : '!text-white hover:!text-[#EB323A]' }}">
                <span class="!text-white {{ request()->routeIs('careers*') ? '!text-[#EB323A]' : '' }}">Tuyển dụng</span>
                <!-- <span class="text-xs font-mono text-slate-400">04</span> -->
            </a>

            {{-- 5. Tin tức --}}
            <a href="{{ route('news.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('news*') ? '!text-[#EB323A]' : '!text-white hover:!text-[#EB323A]' }}">
                <span class="!text-white {{ request()->routeIs('news*') ? '!text-[#EB323A]' : '' }}">Tin tức</span>
                <!-- <span class="text-xs font-mono text-slate-400">05</span> -->
            </a>

            {{-- 6. Liên hệ --}}
            <a href="{{ route('contact.index') }}" @click="open = false" class="flex items-center justify-between border-b border-white/10 py-4 text-lg font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('contact*') ? '!text-[#EB323A]' : '!text-white hover:!text-[#EB323A]' }}">
                <span class="!text-white {{ request()->routeIs('contact*') ? '!text-[#EB323A]' : '' }}">Liên hệ</span>
                <!-- <span class="text-xs font-mono text-slate-400">06</span> -->
            </a>

        </div>

        {{-- Footer Mobile Menu --}}
        <div class="border-t border-white/10 px-6 py-5 bg-[#0B0F17] shrink-0">
            <p class="text-xs font-mono text-slate-400">
                Hotline hỗ trợ: <a href="tel:(0236) 3 958718" class="!text-white font-bold hover:!text-[#EB323A]">(0236) 3 958718</a>
            </p>
        </div>
    </div>
</div>