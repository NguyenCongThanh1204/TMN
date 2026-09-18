@extends('layouts.app')

@section('content')

@php
    $slides = [
        [
            'id' => 1,
            'image' => 'https://www.tanminhnhan.com.vn/images/sppagebuilder/van-phong-tan-minh-nhan-2021.jpg',
            'title' => 'Văn phòng Tân Minh Nhân',
        ],
        [
            'id' => 2,
            'image' => 'https://sunparadiseland.com/_next/image?url=https%3A%2F%2Fsun-ecommerce-cdn.azureedge.net%2Fecommerce%2Fservice-sites%2Fasset%2FSunParadiseLandPhuQuoc%2Fgoogle-doc%2Fpost_id_13826%2FAD_4nXfIqa0nuIpmvb94PHoYb7e0CIyPJ4TnFSOjom37ap3-nRmZYfj5hcd4-NvrfDcsZFEdibsRxpsnJGU22RP6hCnB3QqUpqh2U2d0kd-c3irjDOhJpGmTZuXSmeCdrpondtc7SFYoA6z_Khvc4Vj2g_M8VpgVs2ZWlgSxePGUdmu_eGHi.webp&w=1200&q=80',
            'title' => 'Sun Paradise Land Phú Quốc',
        ],
        [
            'id' => 3,
            'image' => 'https://sun-ecommerce-cdn.azureedge.net/ecommerce/service-sites/thumbnail/SunGroup/B%C3%A0i%20vi%E1%BA%BFt%202025/Th%C3%A1ng%2010%20-2025/Thumb/21784/image-thumb__21784__1600/B%E1%BA%A3n%20sao%20c%E1%BB%A7a%20Sun%20World%20Ba%20Na%20Hills%20%284%29.jpg',
            'title' => 'Sun World Ba Na Hills',
        ],
        [
            'id' => 4,
            'image' => 'https://sun-ecommerce-cdn.azureedge.net/ecommerce/service-sites/thumbnail/SunGroup/B%C3%A0i%20vi%E1%BA%BFt%202025/1.%20OLD/D%E1%BB%B1%20%C3%A1n/DNDT/21336/image-thumb__21336__1600/phoi-canh-du-an-da-nang-downtown.jpg',
            'title' => 'Da Nang Downtown',
        ],
        [
            'id' => 5,
            'image' => 'https://sunurbancity.vn/wp-content/uploads/2024/10/BCG_27-Photo-min-scaled.jpg',
            'title' => 'Sun Urban City',
        ],
    ];
@endphp

<div
    class="bg-[#F8FAFC] min-h-screen text-slate-900 select-none"
    x-data="{
        activeTab: 'overview',
        currentIndex: 0,
        totalSlides: {{ count($slides) }},
        timer: null,
        interval: 6000,

        init() {
            this.startTimer();
        },

        startTimer() {
            if (this.timer) clearInterval(this.timer);
            this.timer = setInterval(() => {
                this.next();
            }, this.interval);
        },

        next() {
            this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
        },

        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
        },

        switchTab(tabId) {
            this.activeTab = tabId;
            this.$nextTick(() => {
                const target = this.$refs.tabSection;
                if (target) {
                    const yOffset = -90;
                    const y = target.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            });
        }
    }"
>

    {{-- 1. FULLSCREEN HERO SLIDESHOW --}}
    <section class="relative w-full h-screen overflow-hidden bg-slate-950 group">
        <div class="relative w-full h-full">
            @foreach($slides as $index => $slide)
                <div
                    x-show="currentIndex === {{ $index }}"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full"
                    style="{{ $index === 0 ? '' : 'display: none;' }}"
                >
                    <img
                        src="{{ $slide['image'] }}"
                        alt="{{ $slide['title'] }}"
                        class="w-full h-full object-cover object-center pointer-events-none"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    />
                </div>
            @endforeach
        </div>

        <div class="absolute inset-0 bg-black/20 pointer-events-none"></div>

        <button
            type="button"
            @click="prev(); startTimer();"
            aria-label="Slide trước"
            class="absolute left-4 sm:left-10 top-1/2 -translate-y-1/2 z-20 w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/10 hover:bg-[#EB323A] backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:scale-110 transition-all duration-300 shadow-2xl focus:outline-none"
        >
            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button
            type="button"
            @click="next(); startTimer();"
            aria-label="Slide tiếp theo"
            class="absolute right-4 sm:right-10 top-1/2 -translate-y-1/2 z-20 w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/10 hover:bg-[#EB323A] backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:scale-110 transition-all duration-300 shadow-2xl focus:outline-none"
        >
            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            @foreach($slides as $index => $slide)
                <button
                    type="button"
                    @click="currentIndex = {{ $index }}; startTimer();"
                    class="h-1.5 rounded-full transition-all duration-300"
                    :class="currentIndex === {{ $index }} ? 'w-8 bg-[#EB323A]' : 'w-2 bg-white/50 hover:bg-white'"
                ></button>
            @endforeach
        </div>
    </section>

    {{-- 2. KHU VỰC TAB NAVIGATION & NỘI DUNG (ĐÃ NỚI RỘNG CHUẨN 1440PX) --}}
    <div x-ref="tabSection" class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12 pt-6 pb-24">

        {{-- Thanh Tab Cố Định --}}
        <div class="sticky top-16 sm:top-20 z-30 bg-[#F8FAFC] pt-3 pb-[1px] border-b border-slate-200 shadow-xs">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar" style="scrollbar-width: none;">

                {{-- Tab 1 --}}
                <button
                    type="button"
                    @click="switchTab('overview')"
                    class="relative flex items-center gap-2 px-5 py-3 rounded-t-lg text-xs md:text-sm font-bold uppercase tracking-wider transition-all whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'overview'
                        ? 'bg-white text-[#EB323A] border-t-2 border-x border-[#EB323A] border-x-slate-200 border-b-white -mb-[1px] shadow-sm z-10'
                        : 'bg-slate-100/80 text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 border border-slate-200'"
                >
                    <svg class="w-4 h-4 stroke-current" :class="activeTab === 'overview' ? 'text-[#EB323A]' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    <span>Tổng quan công ty</span>
                </button>

                {{-- Tab 2 --}}
                <button
                    type="button"
                    @click="switchTab('leadership')"
                    class="relative flex items-center gap-2 px-5 py-3 rounded-t-lg text-xs md:text-sm font-bold uppercase tracking-wider transition-all whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'leadership'
                        ? 'bg-white text-[#EB323A] border-t-2 border-x border-[#EB323A] border-x-slate-200 border-b-white -mb-[1px] shadow-sm z-10'
                        : 'bg-slate-100/80 text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 border border-slate-200'"
                >
                    <svg class="w-4 h-4 stroke-current" :class="activeTab === 'leadership' ? 'text-[#EB323A]' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span>Cán bộ chủ chốt</span>
                </button>

                {{-- Tab 3 --}}
                <button
                    type="button"
                    @click="switchTab('policy')"
                    class="relative flex items-center gap-2 px-5 py-3 rounded-t-lg text-xs md:text-sm font-bold uppercase tracking-wider transition-all whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'policy'
                        ? 'bg-white text-[#EB323A] border-t-2 border-x border-[#EB323A] border-x-slate-200 border-b-white -mb-[1px] shadow-sm z-10'
                        : 'bg-slate-100/80 text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 border border-slate-200'"
                >
                    <svg class="w-4 h-4 stroke-current" :class="activeTab === 'policy' ? 'text-[#EB323A]' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span>Chính sách nhân sự</span>
                </button>

            </div>
        </div>

        {{-- Khung trắng bọc nội dung --}}
        <div class="w-full bg-white border-x border-b border-slate-200 rounded-b-2xl shadow-sm">

            <div
                x-show="activeTab === 'overview'"
                class="w-full block"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
            >
                @includeIf('about.components.company-overview')
            </div>

            <div
                x-show="activeTab === 'leadership'"
                class="w-full block"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;"
            >
                @includeIf('about.components.leadership-hierarchy')
            </div>

            <div
                x-show="activeTab === 'policy'"
                class="w-full block"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;"
            >
                @includeIf('about.components.hr-policy')
            </div>

        </div>

    </div>

</div>

@endsection