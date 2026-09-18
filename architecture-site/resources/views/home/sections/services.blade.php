{{-- =========================================================
     HOME - SERVICES SECTION (EXPANDED 1440PX & ENLARGED TYPOGRAPHY)
     resources/views/sections/services.blade.php
========================================================= --}}

<section
    id="home-services"
    class="relative bg-white pt-[36px] pb-[24px] md:pt-[54px] md:pb-[36px] text-slate-900 border-b border-slate-200/80 overflow-hidden"
    x-data="{
        active: 1,
        services: [
            {
                id: 1,
                number: '01',
                title: 'Công trình Dân dụng & Công nghiệp',
                <!-- subtitle: 'Thiết kế & Thi công tổng thầu', -->
                desc: 'Thực thi các dự án cao ốc thương mại, khu phức hợp đô thị, tổ hợp khách sạn và nhà xưởng công nghiệp quy mô lớn với tiêu chuẩn kết cấu vượt trội.',
                image: 'https://nld.mediacdn.vn/291774122806476800/2026/4/29/phoi-canh-trung-tam-hanh-chinh-17774357655462112221957.jpg',
            },
            {
                id: 2,
                number: '02',
                title: 'Trang trí Nội - Ngoại thất',
                <!-- subtitle: 'Thẩm mỹ không gian & Fit-out', -->
                desc: 'Hiện thực hóa các concept kiến trúc cao cấp, thi công hoàn thiện nội thất tinh xảo cho biệt thự, resort nghỉ dưỡng và sảnh đón biểu tượng.',
                image: '/images/noi_that.webp',
            },
            {
                id: 3,
                number: '03',
                title: 'Hạng mục Nhôm kính & Cơ khí',
                <!-- subtitle: 'Façade kỹ thuật cao', -->
                desc: 'Gia công lắp đặt hệ thống mặt dựng Façade kính Unitized/Stick, kết cấu thép canopy khổ lớn và giải pháp kỹ thuật cơ khí chuẩn xác.',
                image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=80',
            },
            {
                id: 4,
                number: '04',
                title: 'Vật liệu Nội - Ngoại thất',
                <!-- subtitle: 'Chuỗi cung ứng chính hãng', -->
                desc: 'Phân phối đá tự nhiên nhập khẩu, tấm ốp nhôm alu, vật liệu xanh thân thiện môi trường và gạch kiến trúc đạt chuẩn quốc tế.',
                image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTR2Uf4Wtr2N01EDXJwmDcpnncKGkYcG4P2a_wvgLpR_A&s=10',
            }
        ],
        get activeService() {
            return this.services.find(s => s.id === this.active) || this.services[0];
        }
    }"
>
    {{-- Đồng bộ chuẩn 1440px --}}
    <div class="relative mx-auto max-w-[1440px] px-6 sm:px-10 lg:px-12 z-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6  pb-6">
            <div>
                <div class="inline-flex items-center gap-2.5 text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#264abc]">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    Lĩnh Vực Hoạt Động
                </div>
                <h2 class="mt-2 text-2xl sm:text-4xl lg:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
                    Giải Pháp Kỹ Thuật & <span class="font-light text-slate-400">Trang Trí Nội Thất</span>
                </h2>
            </div>
            
            <span class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-slate-400 hidden md:block">
                Tân Minh Nhân Corporation
            </span>
        </div>

        {{-- Main Content Grid: Cân bằng 6 - 6 --}}
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
            
            {{-- Cột trái: 4 Hạng mục dịch vụ (Chữ to rõ, thoáng mắt) --}}
            <div class="lg:col-span-6 space-y-4 flex flex-col justify-between">
                <template x-for="item in services" :key="item.id">
                    <div
                        @mouseenter="active = item.id"
                        @click="active = item.id"
                        class="cursor-pointer relative rounded-sm p-6 sm:p-7 transition-all duration-300 border select-none"
                        :class="active === item.id
                            ? 'bg-white border-blue-200 shadow-[0_12px_32px_rgba(38,74,188,0.08)] -translate-y-0.5 ring-1 ring-blue-100'
                            : 'bg-slate-50/70 hover:bg-white border-slate-200/80 shadow-none hover:border-slate-300'"
                    >
                        {{-- Vệt chỉ đỏ active --}}
                        <div
                            class="absolute left-0 top-0 bottom-0 w-[4px] bg-[#EB323A] rounded-l-sm transition-opacity duration-300"
                            :class="active === item.id ? 'opacity-100' : 'opacity-0'"
                        ></div>

                        <div class="flex items-start justify-between gap-4 pl-2">
                            <div class="flex-1">
                                {{-- Số & Subtitle --}}
                                <!-- <div class="flex items-center gap-3">
                                    <span
                                        class="font-mono text-xs sm:text-sm font-extrabold tracking-widest transition-colors"
                                        :class="active === item.id ? 'text-[#EB323A]' : 'text-slate-400'"
                                        x-text="item.number"
                                    ></span>
                                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                    <span
                                        class="text-xs sm:text-sm font-bold uppercase tracking-wider transition-colors"
                                        :class="active === item.id ? 'text-[#264abc]' : 'text-slate-500'"
                                        x-text="item.subtitle"
                                    ></span>
                                </div> -->

                                {{-- Tiêu đề lớn (Nâng lên text-xl sm:text-2xl) --}}
                                <h3
                                    class="mt-2.5 text-xl sm:text-2xl font-extrabold tracking-tight transition-colors duration-200"
                                    :style="active === item.id ? 'color: #264abc !important;' : ''"
                                    :class="active === item.id ? '' : 'text-slate-900'"
                                    x-text="item.title"
                                ></h3>

                                {{-- Nội dung mở rộng khi active (Nâng lên text-base sm:text-lg) --}}
                                <div
                                    x-show="active === item.id"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-4 pt-4 border-t border-slate-100"
                                >
                                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal" x-text="item.desc"></p>
                                    
                                    {{-- Tags (Nâng lên text-xs sm:text-sm) --}}
                                    <!-- <div class="mt-4 flex flex-wrap gap-2.5">
                                        <template x-for="tag in item.tags" :key="tag">
                                            <span
                                                class="text-xs sm:text-sm font-bold uppercase tracking-wider px-3 py-1 bg-blue-50/80 text-[#264abc] border border-blue-100 rounded-xs"
                                                x-text="tag"
                                            ></span>
                                        </template>
                                    </div> -->
                                </div>
                            </div>

                            <div
                                class="shrink-0 flex h-9 w-9 items-center justify-center rounded-full border transition-all duration-300 shadow-sm mt-0.5"
                                :class="active === item.id
                                    ? 'border-[#264abc] bg-[#264abc] text-white rotate-45 shadow-md shadow-blue-500/20'
                                    : 'border-slate-200 bg-white text-slate-400 hover:text-slate-600'"
                            >
                                <span class="text-sm font-bold leading-none">↗</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Cột phải: KHUNG ẢNH LỚN BÙ VÀO LAYOUT 1440PX --}}
            <div class="lg:col-span-6 relative min-h-[480px] lg:min-h-[560px] flex">
                <div class="relative w-full h-full overflow-hidden rounded-sm border border-slate-200 shadow-2xl flex flex-col bg-slate-900">
                    
                    <img
                        :src="activeService.image"
                        :alt="activeService.title"
                        class="absolute inset-0 w-full h-full object-cover object-center transition-all duration-700 ease-out"
                        style="min-height: 100%; min-width: 100%;"
                    />

                    {{-- Gradient đáy --}}
                    <div class="absolute inset-x-0 bottom-0 h-[45%] bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>

                    {{-- Watermark số lớn --}}
                    <div
                        class="absolute top-5 right-7 font-mono text-8xl font-black text-white/35 select-none pointer-events-none drop-shadow-md"
                        x-text="activeService.number"
                    ></div>

                    {{-- Thông tin đè đáy ảnh: Chữ to rõ ràng --}}
                    <div class="relative mt-auto p-7 sm:p-10 text-white z-10 pointer-events-none">
                        <!-- <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white/20 backdrop-blur-md rounded-xs border border-white/30 mb-3.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#EB323A]"></span>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-white" x-text="activeService.subtitle"></span>
                        </div> -->
                        <p class="text-2xl sm:text-3xl font-bold leading-snug drop-shadow-md text-white" x-text="activeService.title"></p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>