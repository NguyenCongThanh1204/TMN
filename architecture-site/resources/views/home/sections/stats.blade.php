{{-- =========================================================
     HOME - TRUST / METRICS (PURE ARCHITECTURAL LEDGER)
========================================================= --}}

<section
    id="home-stats"
    class="relative overflow-hidden bg-white pt-[32px] pb-[16px] md:pt-[50px] md:pb-[20px] select-none border-b border-slate-200"
    x-data="{
        started: false,
        counters: {
            experience: '0',
            staff: '0',
            revenue2025: '0',
            target2026: '0'
        },
        targets: {
            experience: 15,
            staff: 900,
            revenue2025: 4000,
            target2026: 19500
        },
        startCounter() {
            if (this.started) return;
            this.started = true;

            const duration = 2000;
            const startTime = performance.now();
            const easeOutExpo = (x) => (x === 1 ? 1 : 1 - Math.pow(2, -10 * x));

            const update = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutExpo(progress);

                Object.keys(this.targets).forEach(key => {
                    const currentVal = Math.round(easedProgress * this.targets[key]);
                    this.counters[key] = currentVal.toLocaleString('en-US');
                });

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    Object.keys(this.targets).forEach(key => {
                        this.counters[key] = this.targets[key].toLocaleString('en-US');
                    });
                }
            };

            requestAnimationFrame(update);
        }
    }"
    x-intersect.once="startCounter()"
    x-init="
        window.addEventListener('scroll', () => {
            const rect = $el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                startCounter();
            }
        }, { passive: true });
    "
>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header Section: Tinh gọn, tích hợp nút tải Profile --}}
        <div class="mb-14 sm:mb-20 flex flex-col lg:flex-row lg:items-end justify-between gap-6 border-b-2 border-slate-950 pb-8">
            <div>
                <div class="mb-2 flex items-center gap-2 font-mono text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                    <span class="h-2 w-2 bg-[#EB323A]"></span>
                    <span>NĂNG LỰC & CHỈ SỐ QUY MÔ</span>
                </div>

                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-slate-950 leading-tight">
                    Năng Lực Thực Chứng <br>
                    <span class="text-[#EB323A]">Qua Từng Con Số</span>
                </h2>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-5 lg:pb-1">
                <p class="max-w-xs font-mono text-xs text-slate-500 leading-relaxed border-l-2 border-slate-200 pl-4">
                    Minh chứng cho tiềm lực tài chính, kỷ luật thi công và quy mô hoàn thiện công trình trên toàn quốc.
                </p>

                {{-- Nút Tải Hồ Sơ Năng Lực PDF trực tiếp --}}
                <a 
                    href="{{ asset('downloads/Ho-So-Nang-Luc-Tan-Minh-Nhan.pdf') }}" 
                    download="Ho-So-Nang-Luc-Tan-Minh-Nhan.pdf"
                    class="inline-flex items-center gap-2.5 px-5 py-3 rounded-lg bg-slate-950 hover:bg-[#EB323A] text-white text-xs font-mono font-bold uppercase tracking-wider transition-all duration-300 shadow-md shrink-0 cursor-pointer group"
                >
                    <svg class="w-4 h-4 transition-transform group-hover:translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Tải Hồ Sơ Năng Lực (PDF)</span>
                </a>
            </div>
        </div>

        {{-- Lưới 4 Cột Hairline Divider (Phong cách Bản vẽ kiến trúc) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-slate-200 border-b border-slate-200 pb-12 sm:pb-16">

            {{-- 01. NĂM KINH NGHIỆM --}}
            <div class="p-6 sm:p-8 flex flex-col justify-between group hover:bg-slate-50/70 transition-colors">
                <div>
                    <div class="flex items-center justify-between font-mono text-xs text-slate-400 mb-6">
                        <span>[ 01 // HERITAGE ]</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-[#EB323A] transition-colors"></span>
                    </div>

                    <div class="flex items-baseline gap-1">
                        <span 
                            class="font-mono text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 group-hover:text-[#EB323A] transition-colors"
                            x-text="counters.experience"
                        >0</span>
                        <span class="font-mono text-2xl sm:text-3xl font-bold text-[#EB323A]">+</span>
                    </div>

                    <h3 class="mt-4 font-bold text-base sm:text-lg uppercase tracking-tight text-slate-900">
                        Năm Kinh Nghiệm
                    </h3>
                </div>

                <p class="mt-6 pt-4 border-t border-slate-100 font-mono text-xs text-slate-500 leading-relaxed">
                    Hơn một thập kỷ đồng hành cùng các chủ đầu tư kiến tạo công trình biểu tượng.
                </p>
            </div>

            {{-- 02. CÁN BỘ KỸ SƯ --}}
            <div class="p-6 sm:p-8 flex flex-col justify-between group hover:bg-slate-50/70 transition-colors">
                <div>
                    <div class="flex items-center justify-between font-mono text-xs text-slate-400 mb-6">
                        <span>[ 02 // PERSONNEL ]</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-[#EB323A] transition-colors"></span>
                    </div>

                    <div class="flex items-baseline gap-1">
                        <span 
                            class="font-mono text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 group-hover:text-[#EB323A] transition-colors"
                            x-text="counters.staff"
                        >0</span>
                        <span class="font-mono text-2xl sm:text-3xl font-bold text-[#EB323A]">+</span>
                    </div>

                    <h3 class="mt-4 font-bold text-base sm:text-lg uppercase tracking-tight text-slate-900">
                        Cán Bộ Nhân Viên
                    </h3>
                </div>

                <p class="mt-6 pt-4 border-t border-slate-100 font-mono text-xs text-slate-500 leading-relaxed">
                    Đội ngũ chỉ huy trưởng, kỹ sư hiện trường và chuyên viên QA/QC thực chiến.
                </p>
            </div>

            {{-- 03. DOANH THU 2025 --}}
            <div class="p-6 sm:p-8 flex flex-col justify-between group hover:bg-slate-50/70 transition-colors">
                <div>
                    <div class="flex items-center justify-between font-mono text-xs text-slate-400 mb-6">
                        <span>[ 03 // ACTUAL 2025 ]</span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">ĐẠT ĐƯỢC</span>
                    </div>

                    <div class="flex items-baseline gap-1.5">
                        <span 
                            class="font-mono text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 group-hover:text-[#EB323A] transition-colors"
                            x-text="counters.revenue2025"
                        >0</span>
                        <span class="font-mono text-xl sm:text-2xl font-bold text-[#EB323A] uppercase">Tỷ</span>
                    </div>

                    <h3 class="mt-4 font-bold text-base sm:text-lg uppercase tracking-tight text-slate-900">
                        Doanh Thu Năm 2025
                    </h3>
                </div>

                <p class="mt-6 pt-4 border-t border-slate-100 font-mono text-xs text-slate-500 leading-relaxed">
                    Sản lượng thi công thực chứng hoàn thành và quyết toán đúng cam kết.
                </p>
            </div>

            {{-- 04. MỤC TIÊU 2026 --}}
            <div class="p-6 sm:p-8 flex flex-col justify-between group hover:bg-slate-50/70 transition-colors">
                <div>
                    <div class="flex items-center justify-between font-mono text-xs text-slate-400 mb-6">
                        <span class="text-[#EB323A] font-bold">[ 04 // TARGET 2026 ]</span>
                        <span class="text-[10px] font-bold text-white bg-[#EB323A] px-2 py-0.5 rounded">KỲ VỌNG</span>
                    </div>

                    <div class="flex items-baseline gap-1.5">
                        <span 
                            class="font-mono text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 group-hover:text-[#EB323A] transition-colors"
                            x-text="counters.target2026"
                        >0</span>
                        <span class="font-mono text-xl sm:text-2xl font-bold text-[#EB323A] uppercase">Tỷ</span>
                    </div>

                    <h3 class="mt-4 font-bold text-base sm:text-lg uppercase tracking-tight text-slate-900">
                        Mục Tiêu Năm 2026
                    </h3>
                </div>

                <p class="mt-6 pt-4 border-t border-slate-100 font-mono text-xs text-slate-500 leading-relaxed">
                    Bứt phá quy mô, hướng đến trở thành tập đoàn xây dựng đa năng hàng đầu.
                </p>
            </div>

        </div>

        {{-- Thanh thông tin kiểm toán chuẩn bản vẽ phía dưới --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between font-mono text-[11px] text-slate-400 gap-3">
            <div class="flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                <span>DỮ LIỆU TÀI CHÍNH ĐƯỢC CHUẨN HÓA VÀ XÁC THỰC</span>
            </div>
            <div class="flex items-center gap-4">
                <span>TÂN MINH NHÂN // GENERAL CONTRACTOR</span>
            </div>
        </div>

    </div>
</section>