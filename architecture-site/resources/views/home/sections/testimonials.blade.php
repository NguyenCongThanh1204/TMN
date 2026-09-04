{{-- =========================================================
    HOME - SECTION 8: 3D POP-OUT (CROSS-DISSOLVE & DEPTH MOTION)
    resources/views/home/sections/testimonials.blade.php
========================================================= --}}

@php
    $leadership = [
        [
            'name' => 'Nhan Văn Chiến',
            'role' => 'Chủ tịch HĐQT',
            'role_en' => 'CHAIRMAN',
            'quote' => 'Chữ tín trong kinh doanh và chất lượng con người là nền móng của mọi công trình.',
            'badge' => 'Định hình văn hóa',
            'cutout_image' => asset('images/leadership/chutich.png'),
        ],
        [
            'name' => 'Nguyễn Thị Thu Phượng',
            'role' => 'Phó Chủ tịch HĐQT',
            'role_en' => 'VICE CHAIRWOMAN',
            'quote' => 'Tầm nhìn chiến lược sáng suốt và đặt sự phát triển bền vững lên hàng đầu.',
            'badge' => 'Tầm nhìn chiến lược',
            'cutout_image' => asset('images/leadership/phoChuTich.png'),
        ],
    ];

    $partners = [
        [
            'name' => 'SUN GROUP',
            'logo' => asset('images/doiTac/SUNGROUP.png'),
        ],
        [
            'name' => 'JOTUN',
            'logo' => asset('images/doiTac/JOTUN.png'),
        ],
        [
            'name' => 'DONGTAM',
            'logo' => asset('images/doiTac/DONGTAM.jpg'),
        ],
        [
            'name' => 'VIETCERAMICS',
            'logo' => asset('images/doiTac/VIETCERAMICS.png'),
        ],
        [
            'name' => 'KNAUF',
            'logo' => asset('images/doiTac/KNAUF.png'),
        ],
        [
            'name' => 'DUFAGO',
            'logo' => asset('images/doiTac/DUFAGO.png'),
        ],
    ];
@endphp

<section
    id="leadership-message"
    class="relative overflow-hidden bg-[#f8fafc] py-24 sm:py-32 border-b border-slate-200/80 text-slate-900 select-none"
    x-data="{
        current: 0,
        total: {{ count($leadership) }},
        timer: null,
        interval: 6000,
        progress: 0,
        
        startTimer() {
            this.progress = 0;
            if (this.timer) clearInterval(this.timer);
            
            const step = 40;
            this.timer = setInterval(() => {
                this.progress += (step / this.interval) * 100;
                if (this.progress >= 100) {
                    this.next();
                }
            }, step);
        },
        
        next() {
            this.current = (this.current + 1) % this.total;
            this.progress = 0;
        },

        goTo(index) {
            this.current = index;
            this.startTimer();
        }
    }"
    x-init="startTimer()"
>
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Header & Thanh chỉ báo chạy liên tục --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 border-b border-slate-200/90 pb-8">
            <div>
                <div class="flex items-center gap-2.5 mb-2.5">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                        Hội Đồng Quản Trị
                    </span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-950">
                    Thông điệp <span class="font-light text-slate-400">lãnh đạo.</span>
                </h2>
            </div>

            {{-- Thanh tiến trình tự động --}}
            <!-- <div class="flex items-center gap-4">
                @foreach($leadership as $index => $item)
                    <button
                        type="button"
                        @click="goTo({{ $index }})"
                        class="flex flex-col items-start gap-1 py-1 focus:outline-none"
                    >
                        <div class="h-1.5 w-16 sm:w-20 rounded-full bg-slate-200 overflow-hidden relative">
                            <div
                                class="h-full bg-[#EB323A] transition-all duration-75 ease-linear"
                                :style="current === {{ $index }} ? `width: ${progress}%` : (current > {{ $index }} ? 'width: 100%' : 'width: 0%')"
                            ></div>
                        </div>
                        <span 
                            class="text-[10px] font-mono font-bold tracking-wider transition-colors duration-300"
                            :class="current === {{ $index }} ? 'text-slate-900' : 'text-slate-400'"
                        >
                            0{{ $index + 1 }}
                        </span>
                    </button>
                @endforeach
            </div> -->
        </div>

        {{-- Khung hiển thị: Grid Stack cố định để 2 slide chồng khít lên nhau --}}
        <div class="mt-20 sm:mt-24 grid grid-cols-1 relative">
            @foreach($leadership as $index => $item)
                <div
                    x-show="current === {{ $index }}"
                    x-transition:enter="transition cubic-bezier(0.16, 1, 0.3, 1) duration-700"
                    x-transition:enter-start="opacity-0 scale-[0.99]"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-400"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-[0.99]"
                    class="col-start-1 row-start-1 w-full relative"
                    style="{{ $index === 0 ? '' : 'display:none' }}"
                >
                    {{-- Thẻ Card Nền (Lớp chiều sâu 1) --}}
                    <div class="relative min-h-[460px] sm:min-h-[480px] rounded-2xl bg-gradient-to-br from-white via-slate-50 to-slate-100 border border-slate-200/80 shadow-[0_20px_50px_rgba(15,23,42,0.06)] overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-end">

                        {{-- Chữ nền Watermark --}}
                        <div class="pointer-events-none absolute -top-4 -right-6 select-none font-black text-[90px] sm:text-[140px] lg:text-[190px] leading-none text-slate-900/[0.035] tracking-tight whitespace-nowrap">
                            {{ $item['role_en'] }}
                        </div>

                        {{-- Cột Trái: Trích dẫn thông điệp (7 Cột) --}}
                        <div class="lg:col-span-7 p-8 sm:p-12 lg:p-16 z-20">
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.25em] text-[#EB323A] bg-red-50 border border-red-100 px-3 py-1 rounded-xs">
                                <span>●</span>
                                {{ $item['badge'] }}
                            </span>

                            <blockquote class="mt-6 text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-950 leading-tight">
                                “{{ $item['quote'] }}”
                            </blockquote>

                            {{-- Chức danh & Tên --}}
                            <div class="mt-8 pt-6 border-t border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-950 tracking-tight">
                                        {{ $item['name'] }}
                                    </h3>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-[#EB323A] mt-0.5">
                                        {{ $item['role'] }}
                                    </p>
                                </div>

                                <!-- <div class="font-mono text-xs font-bold uppercase tracking-widest text-slate-400">
                                    TMN / Leadership
                                </div> -->
                            </div>
                        </div>

                        {{-- Cột Phải: Bục ánh sáng nơi nhân vật đứng (5 Cột) --}}
                        <div class="lg:col-span-5 h-full relative min-h-[220px] lg:min-h-[480px]">
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-72 h-72 bg-gradient-to-t from-red-100/50 to-transparent rounded-full blur-2xl pointer-events-none"></div>
                        </div>

                    </div>

                    {{-- ẢNH TÁCH NỀN 3D VƯỢT KHUNG: DEPTH MOTION (TRỒI LÊN VÀ ZOOM NHẸ) --}}
                    <div
                        x-show="current === {{ $index }}"
                        x-transition:enter="transition cubic-bezier(0.16, 1, 0.3, 1) duration-1000 delay-75"
                        x-transition:enter-start="opacity-0 translate-y-6 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-98"
                        class="pointer-events-none absolute right-4 sm:right-12 lg:right-14 bottom-0 z-30 flex items-end justify-center w-full max-w-[340px] sm:max-w-[420px] lg:max-w-[480px]"
                    >
                        <img
                            src="{{ $item['cutout_image'] }}"
                            alt="{{ $item['name'] }}"
                            class="w-full h-auto max-h-[540px] sm:max-h-[580px] object-contain drop-shadow-[-15px_20px_35px_rgba(15,23,42,0.18)]"
                            onerror="this.style.display='none'"
                        />
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Đối tác chiến lược --}}
        <div class="mt-24 border-t border-slate-200/80 pt-16">
            <div class="mb-10 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-slate-400">
                    Đối tác chiến lược
                </p>
                <h3 class="mt-2 text-2xl font-bold text-slate-950">
                    Đồng hành cùng những thương hiệu uy tín
                </h3>
            </div>

            <div class="relative overflow-hidden">
                <div class="flex w-max items-center gap-4 partner-marquee-track">
                    @foreach(array_merge($partners, $partners) as $partner)
                        <div class="partner-card">
                            <img
                                src="{{ $partner['logo'] }}"
                                alt="{{ $partner['name'] }}"
                                class="h-auto max-h-10 sm:max-h-11 w-auto max-w-[125px] object-contain transition-transform duration-300 hover:scale-105"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                            />
                            <span style="display: none;">{{ $partner['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    .partner-marquee-track {
        animation: partner-scroll 30s linear infinite;
    }
    /* Đã bỏ animation-play-state: paused để chuột hover vào dải logo vẫn chạy */
    .partner-card {
        display: flex;
        min-width: 180px;
        height: 72px;
        align-items: center;
        justify-content: center;
        padding: 0 24px;
        border: 1px solid rgb(226 232 240);
        background: rgb(255 255 255);
        border-radius: 6px;
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }
    .partner-card:hover {
        transform: translateY(-2px);
        border-color: rgb(203 213 225);
        box-shadow: 0 6px 16px -4px rgba(15, 23, 42, 0.06);
    }
    /* Đã bỏ filter đổi màu hoặc invert để bảo toàn màu gốc */
    @keyframes partner-scroll {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
</style>