{{-- =========================================================
     HOME - TRUST / METRICS SECTION (ANIMATED NUMBERS)
========================================================= --}}

<section
    id="home-stats"
    class="relative overflow-hidden border-b border-slate-200 bg-white py-20 lg:py-28 select-none"
    x-data="{
        started: false,
        counters: {
            experience: '0',
            projects: '0',
            satisfaction: '0',
            locations: '0'
        },
        targets: {
            experience: 15,
            projects: 900,
            satisfaction: 4000,
            locations: 19500
        },
        startCounter() {
            if (this.started) return;
            this.started = true;

            const duration = 2000; // Thời gian chạy: 2 giây
            const startTime = performance.now();

            // Hàm làm chậm dần về đích (easeOutExpo)
            const easeOutExpo = (x) => (x === 1 ? 1 : 1 - Math.pow(2, -10 * x));

            const update = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutExpo(progress);

                Object.keys(this.targets).forEach(key => {
                    const currentVal = Math.round(easedProgress * this.targets[key]);
                    // Tự động định dạng dấu phẩy hàng nghìn (19,500 và 4,000)
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
        // Dự phòng nếu trình duyệt chưa cài plugin x-intersect: tự kiểm tra scroll
        window.addEventListener('scroll', () => {
            const rect = $el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                startCounter();
            }
        }, { passive: true });
    "
>

    {{-- Gradient Ambient Glow nền mờ tạo chiều sâu không gian --}}
    <div class="pointer-events-none absolute -left-20 top-0 h-72 w-72 rounded-full bg-red-100/60 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 bottom-0 h-80 w-80 rounded-full bg-blue-50/80 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-14 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">

            <div>

                <div class="mb-5 flex items-center gap-3">

                    <span class="h-px w-10 bg-red-600"></span>

                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-red-600">
                        Những con số
                    </span>

                </div>

                <h2 class="max-w-2xl text-3xl font-semibold tracking-[-0.03em] text-slate-950 sm:text-4xl lg:text-5xl">
                    Kinh nghiệm được xây dựng
                    <span class="text-slate-400">qua từng công trình.</span>
                </h2>

            </div>


            <p class="max-w-md text-sm leading-7 text-slate-500 lg:text-right">
                Mỗi dự án là một cam kết về chất lượng, tiến độ,
                an toàn và giá trị lâu dài cho khách hàng.
            </p>

        </div>


        {{-- Metrics Cards --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- =================================================
                 EXPERIENCE
            ================================================== --}}
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50/60 p-8 shadow-sm backdrop-blur-sm transition-all duration-500 hover:-translate-y-1.5 hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-600/5 lg:p-9">

                <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-0 bg-red-600 transition-transform duration-500 ease-out group-hover:scale-x-100"></div>

                <div class="mb-8 flex items-center justify-between">

                    <span class="font-mono text-xs font-bold tracking-widest text-slate-400 transition-colors duration-300 group-hover:text-red-600">
                        01
                    </span>

                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200/80 bg-white text-slate-500 shadow-sm transition-all duration-300 group-hover:border-red-600 group-hover:bg-red-600 group-hover:text-white group-hover:rotate-90">
                        +
                    </span>

                </div>


                <div class="flex items-baseline gap-1">

                    <span
                        class="font-mono text-5xl font-bold tracking-tight text-slate-950 transition-colors lg:text-6xl"
                        x-text="counters.experience"
                    >
                        0
                    </span>

                    <span class="text-2xl font-bold text-red-600">
                        +
                    </span>

                </div>


                <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-slate-800 transition-colors group-hover:text-red-600">
                    Năm kinh nghiệm
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Đồng hành cùng nhiều công trình
                    từ thiết kế đến hoàn thiện.
                </p>

            </div>


            {{-- =================================================
                 STAFF
            ================================================== --}}
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50/60 p-8 shadow-sm backdrop-blur-sm transition-all duration-500 hover:-translate-y-1.5 hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-600/5 lg:p-9">

                <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-0 bg-red-600 transition-transform duration-500 ease-out group-hover:scale-x-100"></div>

                <div class="mb-8 flex items-center justify-between">

                    <span class="font-mono text-xs font-bold tracking-widest text-slate-400 transition-colors duration-300 group-hover:text-red-600">
                        02
                    </span>

                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200/80 bg-white text-slate-500 shadow-sm transition-all duration-300 group-hover:border-red-600 group-hover:bg-red-600 group-hover:text-white group-hover:scale-110">
                        ◆
                    </span>

                </div>


                <div class="flex items-baseline gap-1">

                    <span
                        class="font-mono text-5xl font-bold tracking-tight text-slate-950 transition-colors lg:text-6xl"
                        x-text="counters.projects"
                    >
                        0
                    </span>

                    <span class="text-2xl font-bold text-red-600">
                        +
                    </span>

                </div>


                <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-slate-800 transition-colors group-hover:text-red-600">
                    Cán bộ nhân viên
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Đội ngũ chuyên môn đa dạng, giàu kinh nghiệm
                    và tận tâm với từng dự án.
                </p>

            </div>


            {{-- =================================================
                 REVENUE 2025
            ================================================== --}}
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50/60 p-8 shadow-sm backdrop-blur-sm transition-all duration-500 hover:-translate-y-1.5 hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-600/5 lg:p-9">

                <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-0 bg-red-600 transition-transform duration-500 ease-out group-hover:scale-x-100"></div>

                <div class="mb-8 flex items-center justify-between">

                    <span class="font-mono text-xs font-bold tracking-widest text-slate-400 transition-colors duration-300 group-hover:text-red-600">
                        03
                    </span>

                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200/80 bg-white text-slate-500 shadow-sm transition-all duration-300 group-hover:border-red-600 group-hover:bg-red-600 group-hover:text-white">
                        ✓
                    </span>

                </div>


                <div class="flex items-baseline gap-1">

                    <span
                        class="font-mono text-5xl font-bold tracking-tight text-slate-950 transition-colors lg:text-6xl"
                        x-text="counters.satisfaction"
                    >
                        0
                    </span>

                    <span class="text-xl font-bold text-red-600 uppercase">
                        tỷ
                    </span>

                </div>


                <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-slate-800 transition-colors group-hover:text-red-600">
                    Doanh thu năm 2025
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Doanh thu năm đạt được từ các dự án thiết kế và thi công xây dựng.
                </p>

            </div>


            {{-- =================================================
                 TARGET 2026
            ================================================== --}}
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50/60 p-8 shadow-sm backdrop-blur-sm transition-all duration-500 hover:-translate-y-1.5 hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-600/5 lg:p-9">

                <div class="absolute inset-x-0 top-0 h-1 origin-center scale-x-0 bg-red-600 transition-transform duration-500 ease-out group-hover:scale-x-100"></div>

                <div class="mb-8 flex items-center justify-between">

                    <span class="font-mono text-xs font-bold tracking-widest text-slate-400 transition-colors duration-300 group-hover:text-red-600">
                        04
                    </span>

                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200/80 bg-white text-slate-500 shadow-sm transition-all duration-300 group-hover:border-red-600 group-hover:bg-red-600 group-hover:text-white group-hover:scale-110">
                        ◎
                    </span>

                </div>


                <div class="flex items-baseline gap-1">

                    <span
                        class="font-mono text-5xl font-bold tracking-tight text-slate-950 transition-colors lg:text-6xl"
                        x-text="counters.locations"
                    >
                        0
                    </span>

                    <span class="text-xl font-bold text-red-600 uppercase">
                        tỷ
                    </span>

                </div>


                <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-slate-800 transition-colors group-hover:text-red-600">
                    Doanh thư dự kiến (năm 2026)
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Dự kiến doanh thu vượt bậc, đánh dấu sự tăng trưởng và uy tín của công ty trong ngành xây dựng.
                </p>

            </div>

        </div>

    </div>

</section>