{{-- =========================================================
    HOME - SECTION 8: 3D POP-OUT (STATIC CARD & DEPTH MOTION)
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
    ];

    // Lấy danh sách đối tác từ CSDL
    $partners = \App\Models\Partner::whereNotNull('logo')->latest()->get();
@endphp

<section
    id="leadership-message"
    class="relative overflow-hidden bg-[#f8fafc] pt-[32px] pb-[16px] md:pt-[50px] md:pb-[20px] border-b border-slate-200/80 text-slate-900 select-none"
>
    <div class="relative mx-auto max-w-[1440px] px-6 md:px-12">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 pb-2">
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
        </div>

        {{-- Khung hiển thị: 1 Card tĩnh duy nhất --}}
        <div class="mt-5 relative">
            @foreach($leadership as $item)
                <div class="w-full relative">
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
                            </div>
                        </div>

                        {{-- Cột Phải: Bục ánh sáng nơi nhân vật đứng (5 Cột) --}}
                        <div class="lg:col-span-5 h-full relative min-h-[220px] lg:min-h-[480px]">
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-72 h-72 bg-gradient-to-t from-red-100/50 to-transparent rounded-full blur-2xl pointer-events-none"></div>
                        </div>

                    </div>

                    {{-- ẢNH TÁCH NỀN 3D VƯỢT KHUNG --}}
                    <div class="pointer-events-none absolute right-4 sm:right-12 lg:right-14 bottom-0 z-30 flex items-end justify-center w-full max-w-[340px] sm:max-w-[420px] lg:max-w-[480px]">
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
        <div class="mt-12 pt-4">
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
                    @foreach($partners->concat($partners) as $partner)
                        <div class="partner-card">
                            <img
                                src="{{ $partner->logo_url }}"
                                alt="{{ $partner->name }}"
                                class="partner-logo transition-transform duration-300 hover:scale-105"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                            />
                            <span class="text-xs font-semibold text-slate-600 text-center line-clamp-2" style="display: none;">{{ $partner->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    /* CSS riêng cho logo đối tác tránh bị ảnh hưởng bởi thuộc tính cover chung */
    .partner-logo {
        width: auto !important;
        height: auto !important;
        max-height: 38px !important;
        max-width: 120px !important;
        object-fit: contain !important;
        display: block;
    }

    .partner-marquee-track {
        animation: partner-scroll 30s linear infinite;
    }
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
    @keyframes partner-scroll {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
</style>