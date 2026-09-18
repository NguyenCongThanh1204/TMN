{{-- =========================================================
     HOME — MILESTONES TIMELINE (EXPANDED 1440PX & HOVER-TRIGGERED)
     resources/views/sections/timeline.blade.php
========================================================= --}}

<section
    id="timeline"
    x-data="{
        active: 1,
        total: 5,
        timer: null,
        intervalMs: 4500,

        init() {
            this.startAutoPlay();
        },

        startAutoPlay() {
            this.stopAutoPlay();
            this.timer = setInterval(() => {
                this.active = this.active >= this.total ? 1 : this.active + 1;
            }, this.intervalMs);
        },

        stopAutoPlay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },

        // Chuyển step lập tức khi hover hoặc click
        selectStep(step) {
            if (this.active === step) return;
            this.stopAutoPlay();
            this.active = step;
        },

        steps: {
            1: {
                number: '01',
                title: 'Thành lập & Khởi đầu',
                short: '2011',
                description: 'Chính thức đi vào hoạt động tại Đà Nẵng, đặt nền móng với phương châm sáng tạo và nhiệt huyết của tuổi trẻ.',
                items: [
                    'Chính thức thành lập Tân Minh Nhân',
                    'Thiết lập đội ngũ kỹ sư nòng cốt',
                    'Định hình tiêu chuẩn thi công chuẩn xác',
                    'Triển khai các công trình đầu tiên'
                ]
            },
            2: {
                number: '02',
                title: 'Mở rộng quy mô & Năng lực',
                short: '2015',
                description: 'Mở rộng thị trường thi công tại miền Trung, khẳng định uy tín và năng lực quản lý dự án ngày càng chuyên nghiệp.',
                items: [
                    'Mở rộng thị phần sang nhiều tỉnh thành',
                    'Đầu tư đồng bộ trang thiết bị thi công',
                    'Tiếp nhận các dự án quy mô lớn hơn',
                    'Chuẩn hóa quy trình an toàn lao động'
                ]
            },
            3: {
                number: '03',
                title: 'Đổi mới công nghệ & Quản trị',
                short: '2021',
                description: 'Nâng cấp mô hình quản trị, số hóa quy trình và ứng dụng kỹ thuật thi công hiện đại vào từng công trình.',
                items: [
                    'Tái định vị thương hiệu hiện đại',
                    'Áp dụng quy trình kiểm soát QA/QC nghiêm ngặt',
                    'Đưa công nghệ vào giám sát hiện trường',
                    'Khẳng định vị thế tổng thầu chuyên nghiệp'
                ]
            },
            4: {
                number: '04',
                title: 'Tăng trưởng bứt phá',
                short: '2025',
                description: 'Cán mốc doanh thu 4.000 tỷ VNĐ với đội ngũ hơn 900 nhân sự, hoàn thành xuất sắc các dự án tầm cỡ.',
                items: [
                    'Doanh thu đạt mốc 4.000 tỷ VNĐ',
                    'Quy mô nhân sự vượt 900 cán bộ công nhân viên',
                    'Bàn giao đúng hạn chuỗi công trình trọng điểm',
                    'Mạng lưới đối tác và khách hàng rộng khắp'
                ]
            },
            5: {
                number: '05',
                title: 'Vươn tầm tương lai',
                short: '2026',
                description: 'Đặt mục tiêu doanh thu 19.500 tỷ VNĐ, hướng tới trở thành tập đoàn xây dựng đa năng dẫn đầu ngành.',
                items: [
                    'Mục tiêu doanh thu kỳ vọng 19.500 tỷ VNĐ',
                    'Mở rộng phân khúc hạ tầng & tổ hợp cao cấp',
                    'Phát triển công trình theo xu hướng bền vững',
                    'Đưa thương hiệu vươn tầm quốc tế'
                ]
            }
        }
    }"
    @mouseenter="stopAutoPlay()"
    @mouseleave="startAutoPlay()"
    class="relative overflow-hidden bg-white pt-[36px] pb-[28px] md:pt-[54px] md:pb-[40px] border-b border-slate-200/80 select-none"
>

    {{-- Lớp nền Ambient Glow --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-32 -right-32 w-[520px] h-[520px] bg-blue-100/40 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-32 -left-32 w-[480px] h-[480px] bg-red-100/30 rounded-full blur-[120px]"></div>
    </div>

    {{-- Khung chứa bung rộng chuẩn 1440px --}}
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12 relative z-10">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200 pb-6">
            <div>
                <div class="inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    Hành Trình Phát Triển
                </div>
                <h2 class="mt-2 text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
                    Dấu Ấn <span class="font-light text-slate-400">Thời Gian</span>
                </h2>
            </div>

            <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 hidden md:block">
                2011 — 2026
            </span>
        </div>

        {{-- =========================================================
             1. MOBILE NAVIGATION
             ========================================================= --}}
        <div class="mt-8 lg:hidden">
            <div class="grid grid-cols-5 gap-1.5 p-1 bg-slate-50 rounded-xl border border-slate-200 shadow-sm">
                <template x-for="i in 5" :key="i">
                    <button
                        type="button"
                        @click="selectStep(i)"
                        class="flex flex-col items-center justify-center py-2 px-1 rounded-lg transition-all duration-300 focus:outline-none"
                        :class="active === i
                            ? 'bg-[#EB323A] text-white shadow-md shadow-red-500/30'
                            : 'text-slate-500 hover:text-slate-900'"
                    >
                        <span class="font-mono text-[9px] opacity-75 font-semibold" x-text="'0' + i"></span>
                        <span class="text-[11px] font-extrabold tracking-tight mt-0.5" x-text="steps[i].short"></span>
                    </button>
                </template>
            </div>
        </div>

        {{-- =========================================================
             2. DESKTOP TIMELINE: TỰ NHẢY KHI HOVER CHUỘT
             ========================================================= --}}
        <div class="relative mt-14 hidden lg:block">

            {{-- Line chạy ngang --}}
            <div class="absolute left-0 right-0 top-[35px] h-0.5 bg-slate-200">
                <div
                    class="relative h-full transition-all duration-700 ease-out"
                    style="background: linear-gradient(90deg, #264abc, #EB323A);"
                    :style="'width: ' + ((active - 1) / 4 * 100) + '%'"
                >
                    <span class="absolute -right-1.5 -top-[5px] h-3.5 w-3.5 rounded-full bg-[#EB323A] shadow-[0_0_12px_#EB323A]">
                        <span class="absolute inset-0 animate-ping rounded-full bg-red-400 opacity-75"></span>
                    </span>
                </div>
            </div>

            {{-- 5 Bước trên Desktop: Kích hoạt ngay khi @mouseenter --}}
            <div class="grid grid-cols-5 gap-6">
                <template x-for="i in 5" :key="i">
                    <button
                        type="button"
                        @mouseenter="selectStep(i)"
                        @click="selectStep(i)"
                        class="group relative text-left outline-none cursor-pointer py-1"
                    >
                        <div class="relative z-10">
                            {{-- Khối hộp số lớn hơn (h-18 w-18) --}}
                            <div
                                class="flex h-[72px] w-[72px] items-center justify-center border transition-all duration-500 rounded-sm"
                                :class="active === i
                                    ? 'border-[#264abc] bg-[#264abc] text-white shadow-xl shadow-blue-600/25 scale-105'
                                    : 'border-slate-200 bg-white text-slate-500 group-hover:border-[#264abc] group-hover:text-[#264abc]'"
                            >
                                <span class="font-mono text-base font-bold" x-text="'0' + i"></span>
                            </div>

                            {{-- Năm & Tiêu đề mốc --}}
                            <div class="mt-6">
                                <p
                                    class="text-xs font-bold uppercase tracking-[0.18em] transition-colors duration-300"
                                    :class="active === i ? 'text-[#EB323A]' : 'text-slate-400'"
                                    x-text="steps[i].short"
                                ></p>
                                <h3 
                                    class="mt-1.5 text-sm sm:text-base font-bold truncate transition-colors duration-200"
                                    :class="active === i ? 'text-slate-950' : 'text-slate-600 group-hover:text-slate-900'"
                                    x-text="steps[i].title"
                                ></h3>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        {{-- =========================================================
             3. DETAIL CARD BUNG RỘNG CÙNG KHUNG HÌNH 1440PX
             ========================================================= --}}
        <div class="mt-10 sm:mt-14 overflow-hidden rounded-sm border border-slate-200 bg-white shadow-[0_15px_40px_rgba(20,44,80,0.08)] transition-all duration-300">
            <div class="grid lg:grid-cols-[.34fr_1fr]">

                {{-- Khối Số: Navy #0e2e60 --}}
                <div 
                    class="hidden lg:flex relative overflow-hidden p-10 sm:p-12 lg:p-14 flex-col justify-between"
                    style="background-color: #0e2e60 !important;"
                >
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/10 pointer-events-none"></div>
                    <div class="absolute -bottom-32 -left-20 h-72 w-72 rounded-full border border-white/10 pointer-events-none"></div>

                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/50">
                            Cột mốc thời gian
                        </p>

                        <div
                            :key="'num-' + active"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="mt-6 font-mono text-8xl lg:text-9xl font-black tracking-tight text-white leading-none"
                            x-text="steps[active].number"
                        ></div>

                        <div class="mt-6 h-0.5 w-14 bg-[#EB323A]"></div>

                        <p
                            class="mt-6 font-mono text-2xl font-bold tracking-widest text-[#EB323A]"
                            x-text="steps[active].short"
                        ></p>
                    </div>

                    <div class="relative z-10 font-mono text-xs text-white/40 tracking-widest uppercase">
                        TMN / Milestones
                    </div>
                </div>

                {{-- Khối Nội Dung Chi Tiết --}}
                <div
                    :key="'content-' + active"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="p-7 sm:p-10 lg:p-14 flex flex-col justify-between"
                >
                    <div>
                        {{-- Mobile Badge --}}
                        <div class="flex items-center justify-between lg:hidden border-b border-slate-100 pb-3 mb-4">
                            <span class="inline-flex items-center gap-1.5 font-mono text-xs font-extrabold text-[#EB323A] bg-red-50 px-2.5 py-1 rounded-sm">
                                <span>Giai đoạn</span>
                                <span x-text="steps[active].number"></span>
                                <span class="text-slate-300">/</span>
                                <span class="text-slate-400">05</span>
                            </span>
                            <span class="font-mono text-xs font-extrabold text-white bg-[#264abc] px-3 py-1 rounded-sm" x-text="'Năm ' + steps[active].short"></span>
                        </div>

                        {{-- Tiêu đề & Mô tả --}}
                        <h3
                            class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight"
                            style="color: #264abc !important;"
                            x-text="steps[active].title"
                        ></h3>

                        <p
                            class="mt-4 sm:mt-5 text-sm sm:text-base lg:text-lg leading-relaxed text-slate-600 font-normal"
                            x-text="steps[active].description"
                        ></p>
                    </div>

                    {{-- Checklist 4 ý chính --}}
                    <div class="mt-8 sm:mt-10 grid gap-3 sm:gap-4 sm:grid-cols-2 pt-6 sm:pt-7 border-t border-slate-100">
                        <template x-for="(item, idx) in steps[active].items" :key="idx">
                            <div class="flex items-start gap-3.5 p-3 rounded-sm bg-slate-50/80 border border-slate-100 sm:p-3.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-50 text-[10px] font-bold text-[#EB323A] border border-red-100 mt-0.5">
                                    ✓
                                </span>
                                <span class="text-xs sm:text-sm font-medium text-slate-800 leading-snug" x-text="item"></span>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

    </div>

</section>