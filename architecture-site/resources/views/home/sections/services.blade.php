{{-- =========================================================
     HOME - SERVICES SECTION (FIXED CLEAN LUXURY LAYOUT)
     resources/views/sections/services.blade.php
========================================================= --}}

<section
    id="home-services"
    class="relative bg-slate-50 py-20 sm:py-28 lg:py-32 text-slate-900 border-b border-slate-200"
    x-data="{
        active: 1,
        services: [
            {
                id: 1,
                number: '01',
                title: 'Công trình Dân dụng & Công nghiệp',
                subtitle: 'Thiết kế & Thi công tổng thầu',
                desc: 'Thực thi các dự án cao ốc thương mại, khu phức hợp đô thị, tổ hợp khách sạn và nhà xưởng công nghiệp quy mô lớn với tiêu chuẩn kết cấu vượt trội.',
                image: 'https://images.unsplash.com/photo-1541888946425-d0fbb186156f?auto=format&fit=crop&w=1000&q=80',
                tags: ['Cao ốc văn phòng', 'Nhà xưởng quy mô', 'Khu đô thị']
            },
            {
                id: 2,
                number: '02',
                title: 'Trang trí Nội - Ngoại thất',
                subtitle: 'Thẩm mỹ không gian & Fit-out',
                desc: 'Hiện thực hóa các concept kiến trúc cao cấp, thi công hoàn thiện nội thất tinh xảo cho biệt thự, resort nghỉ dưỡng và sảnh đón biểu tượng.',
                image: 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1000&q=80',
                tags: ['Resort nghỉ dưỡng', 'Fit-out cao cấp', 'Cảnh quan biểu tượng']
            },
            {
                id: 3,
                number: '03',
                title: 'Hạng mục Nhôm kính & Cơ khí',
                subtitle: 'Façade kỹ thuật cao',
                desc: 'Gia công lắp đặt hệ thống mặt dựng Façade kính Unitized/Stick, kết cấu thép canopy khổ lớn và giải pháp kỹ thuật cơ khí chuẩn xác.',
                image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1000&q=80',
                tags: ['Façade tòa nhà', 'Vách kính Spider', 'Cơ khí kiến trúc']
            },
            {
                id: 4,
                number: '04',
                title: 'Vật liệu Nội - Ngoại thất',
                subtitle: 'Chuỗi cung ứng chính hãng',
                desc: 'Phân phối đá tự nhiên nhập khẩu, tấm ốp nhôm alu, vật liệu xanh thân thiện môi trường và gạch kiến trúc đạt chuẩn quốc tế.',
                image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80',
                tags: ['Đá tự nhiên', 'Tấm ốp hợp kim', 'Vật liệu xanh']
            }
        ]
    }"
>
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-slate-200 pb-10">
            <div>
                <div class="inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    Lĩnh Vực Hoạt Động
                </div>
                <!-- <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-950">
                    Giải pháp kỹ thuật <br>
                    <span class="text-slate-400 font-semibold">Kiến tạo chuẩn mực.</span>
                </h2> -->
            </div>
            <!-- <p class="max-w-md text-sm text-slate-600 leading-relaxed">
                Quy trình triển khai khép kín từ bản vẽ thiết kế, kiểm soát chế tạo nhôm kính đến tổ chức thi công hiện trường bài bản và chuẩn xác.
            </p> -->
        </div>

        {{-- Main Content Grid --}}
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            {{-- Cột trái: 4 Hạng mục dịch vụ (Cột 7) --}}
            <div class="lg:col-span-7 space-y-4">
                <template x-for="item in services" :key="item.id">
                    <div
                        @mouseenter="active = item.id"
                        @click="active = item.id"
                        class="cursor-pointer relative rounded-md p-6 transition-all duration-300 border"
                        :class="active === item.id
                            ? 'bg-white border-slate-300 shadow-lg -translate-y-0.5'
                            : 'bg-white/60 hover:bg-white border-slate-200 shadow-none'"
                    >
                        {{-- Thanh vạch đỏ active bên mép trái --}}
                        <div
                            class="absolute left-0 top-0 bottom-0 w-[4px] bg-[#EB323A] rounded-l-md transition-opacity duration-300"
                            :class="active === item.id ? 'opacity-100' : 'opacity-0'"
                        ></div>

                        <div class="flex items-start justify-between gap-4 pl-3">
                            <div class="flex-1">
                                {{-- Số thứ tự & Phụ đề --}}
                                <div class="flex items-center gap-3">
                                    <span
                                        class="font-mono text-xs font-bold tracking-widest"
                                        :class="active === item.id ? 'text-[#EB323A]' : 'text-slate-400'"
                                        x-text="item.number"
                                    ></span>
                                    <span
                                        class="text-[11px] font-bold uppercase tracking-wider text-slate-500"
                                        x-text="item.subtitle"
                                    ></span>
                                </div>

                                {{-- Tiêu đề --}}
                                <h3
                                    class="mt-2 text-lg sm:text-xl font-bold tracking-tight"
                                    :class="active === item.id ? 'text-slate-950' : 'text-slate-700'"
                                    x-text="item.title"
                                ></h3>

                                {{-- Mô tả mở rộng khi active --}}
                                <div
                                    x-show="active === item.id"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-3 pt-3 border-t border-slate-100"
                                >
                                    <p class="text-sm text-slate-600 leading-relaxed font-normal" x-text="item.desc"></p>
                                    
                                    {{-- Tag badges --}}
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <template x-for="tag in item.tags" :key="tag">
                                            <span
                                                class="text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 bg-slate-100 text-slate-700 rounded-sm"
                                                x-text="tag"
                                            ></span>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Nút mũi tên tròn --}}
                            <div
                                class="shrink-0 flex h-8 w-8 items-center justify-center rounded-full border transition-all duration-300"
                                :class="active === item.id
                                    ? 'border-[#EB323A] bg-[#EB323A] text-white rotate-45'
                                    : 'border-slate-200 text-slate-400'"
                            >
                                <span class="text-xs font-bold">↗</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Cột phải: Khung ảnh tương tác (Cột 5) --}}
            <div class="lg:col-span-5">
                <div class="relative aspect-[4/5] w-full overflow-hidden rounded-md bg-slate-900 border border-slate-200 shadow-xl">
                    <template x-for="item in services" :key="item.id">
                        <div
                            x-show="active === item.id"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute inset-0 h-full w-full"
                        >
                            <img
                                :src="item.image"
                                :alt="item.title"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />

                            {{-- Lớp gradient đáy để làm rõ text --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>

                            {{-- Số in chìm góc trên --}}
                            <div
                                class="absolute top-4 right-6 font-mono text-6xl font-black text-white/20 select-none pointer-events-none"
                                x-text="item.number"
                            ></div>

                            {{-- Tiêu đề đè đáy ảnh --}}
                            <div class="absolute bottom-6 left-6 right-6 text-white">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-red-400" x-text="item.subtitle"></span>
                                <p class="mt-1 text-base font-bold leading-snug drop-shadow-sm" x-text="item.title"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</section>