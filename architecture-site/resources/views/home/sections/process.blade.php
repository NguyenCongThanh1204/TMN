{{-- =========================================================
     HOME — MILESTONES TIMELINE (FIX MOBILE OVERFLOW)
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

        selectStep(step) {
            this.active = step;
            this.stopAutoPlay();
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
    @mouseleave="startAutoPlay()"
    class="relative overflow-hidden bg-slate-50 py-16 sm:py-24 lg:py-32 select-none"
>

    {{-- Background Glow --}}
    <div class="pointer-events-none absolute right-0 top-0 h-[450px] w-[450px] rounded-full bg-blue-100/50 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-[400px] w-[400px] rounded-full bg-red-100/40 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <span class="h-0.5 w-8 bg-red-600"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-red-600">
                        Hành trình phát triển
                    </p>
                </div>
                <h2 class="mt-3 text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-950">
                    Dấu ấn <span class="text-slate-400 font-light">thời gian.</span>
                </h2>
            </div>
        </div>

        {{-- =========================================================
             1. MOBILE NAVIGATION: VỪA VẶN 100% KHÔNG BỊ TRÀN HAY MẤT 2026
             ========================================================= --}}
        <div class="mt-8 lg:hidden">
            <div class="grid grid-cols-5 gap-1.5 p-1 bg-white rounded-xl border border-slate-200/90 shadow-sm">
                <template x-for="i in 5" :key="i">
                    <button
                        type="button"
                        @click="selectStep(i)"
                        class="flex flex-col items-center justify-center py-2 px-1 rounded-lg transition-all duration-300 focus:outline-none"
                        :class="active === i
                            ? 'bg-red-600 text-white shadow-md shadow-red-600/30'
                            : 'text-slate-500 hover:text-slate-900'"
                    >
                        <span class="font-mono text-[9px] opacity-75 font-semibold" x-text="'0' + i"></span>
                        <span class="text-[11px] font-extrabold tracking-tight mt-0.5" x-text="steps[i].short"></span>
                    </button>
                </template>
            </div>
        </div>


        {{-- =========================================================
             2. DESKTOP TIMELINE: GIỮ NGUYÊN BỐ CỤC 5 BƯỚC
             ========================================================= --}}
        <div class="relative mt-16 hidden lg:block">

            {{-- Line chạy ngang --}}
            <div class="absolute left-0 right-0 top-[31px] h-0.5 bg-slate-200">
                <div
                    class="relative h-full bg-gradient-to-r from-red-500 to-red-600 transition-all duration-700 ease-out"
                    :style="'width: ' + ((active - 1) / 4 * 100) + '%'"
                >
                    <span class="absolute -right-1.5 -top-[5px] h-3 w-3 rounded-full bg-red-600 shadow-[0_0_12px_#dc2626]">
                        <span class="absolute inset-0 animate-ping rounded-full bg-red-400 opacity-75"></span>
                    </span>
                </div>
            </div>

            {{-- 5 Bước trên Desktop --}}
            <div class="grid grid-cols-5 gap-5">
                <template x-for="i in 5" :key="i">
                    <button
                        type="button"
                        @mouseenter="selectStep(i)"
                        @click="selectStep(i)"
                        class="group relative text-left outline-none"
                    >
                        <div class="relative z-10">
                            <div
                                class="flex h-16 w-16 items-center justify-center border transition-all duration-500 rounded-sm"
                                :class="active === i
                                    ? 'border-red-600 bg-red-600 text-white shadow-xl shadow-red-600/30 scale-105'
                                    : 'border-slate-300 bg-white text-slate-500 group-hover:border-slate-900 group-hover:text-slate-900'"
                            >
                                <span class="font-mono text-sm font-bold" x-text="'0' + i"></span>
                            </div>
                            <div class="mt-6">
                                <p
                                    class="text-xs font-bold uppercase tracking-[0.18em] transition-colors duration-300"
                                    :class="active === i ? 'text-red-600' : 'text-slate-400'"
                                    x-text="steps[i].short"
                                ></p>
                                <h3 class="mt-1.5 text-base font-bold text-slate-950 truncate" x-text="steps[i].title"></h3>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>


        {{-- =========================================================
             3. DETAIL CARD
             ========================================================= --}}
        <div
            @mouseenter="stopAutoPlay()"
            class="mt-6 sm:mt-12 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm transition-all duration-300"
        >
            <div class="grid lg:grid-cols-[.32fr_1fr]">

                {{-- Khối Số: Ẩn trên mobile để tiết kiệm chiều dọc --}}
                <div class="hidden lg:flex relative overflow-hidden bg-slate-950 p-12 flex-col justify-between">
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/10 pointer-events-none"></div>
                    <div class="absolute -bottom-32 -left-20 h-72 w-72 rounded-full border border-white/10 pointer-events-none"></div>

                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/40">
                            Cột mốc thời gian
                        </p>

                        <div
                            :key="'num-' + active"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="mt-6 font-mono text-8xl font-black tracking-tight text-white"
                            x-text="steps[active].number"
                        ></div>

                        <div class="mt-6 h-0.5 w-12 bg-red-600"></div>

                        <p
                            class="mt-6 font-mono text-xl font-bold tracking-widest text-red-500"
                            x-text="steps[active].short"
                        ></p>
                    </div>

                    <div class="relative z-10 font-mono text-xs text-white/30 tracking-widest uppercase">
                        TMN / History
                    </div>
                </div>

                {{-- Khối Nội Dung Chi Tiết --}}
                <div
                    :key="'content-' + active"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="p-6 sm:p-10 lg:p-12 flex flex-col justify-between"
                >
                    <div>
                        {{-- Badge chỉ hiển thị trên Mobile --}}
                        <div class="flex items-center justify-between lg:hidden border-b border-slate-100 pb-3 mb-4">
                            <span class="inline-flex items-center gap-1.5 font-mono text-xs font-extrabold text-red-600 bg-red-50 px-2.5 py-1 rounded-md">
                                <span>Giai đoạn</span>
                                <span x-text="steps[active].number"></span>
                                <span class="text-slate-300">/</span>
                                <span class="text-slate-400">05</span>
                            </span>
                            <span class="font-mono text-xs font-extrabold text-slate-900 bg-slate-100 px-3 py-1 rounded-md" x-text="'Năm ' + steps[active].short"></span>
                        </div>

                        {{-- Tiêu đề & Mô tả --}}
                        <h3
                            class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-950"
                            x-text="steps[active].title"
                        ></h3>

                        <p
                            class="mt-3 sm:mt-4 text-xs sm:text-base leading-relaxed sm:leading-7 text-slate-600 font-normal"
                            x-text="steps[active].description"
                        ></p>
                    </div>

                    {{-- Checklist 4 ý chính --}}
                    <div class="mt-6 sm:mt-8 grid gap-2 sm:gap-3 sm:grid-cols-2 pt-5 sm:pt-6 border-t border-slate-100">
                        <template x-for="(item, idx) in steps[active].items" :key="idx">
                            <div class="flex items-start gap-2.5 p-2 rounded-lg bg-slate-50/70 sm:bg-transparent sm:p-0">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-100 text-[10px] font-bold text-red-600 mt-0.5">
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