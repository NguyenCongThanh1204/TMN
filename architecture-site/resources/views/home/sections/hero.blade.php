{{-- =========================================================
     HOME — HERO SLIDESHOW FULLSCREEN (BLADE + ALPINE.JS)
========================================================= --}}

<section
    id="hero"
    x-data="{
        current: 0,
        duration: 7000,
        progress: 0,
        timer: null,
        animFrame: null,
        startTime: null,

        slides: [
            {
                id: 1,
                desktop: '/images/ANH-WEB.webp',
                mobile: '/images/ANH-WEB.webp',
                alt: 'Tân Minh Nhân Dự án 01'
            },
            {
                id: 2,
                desktop: '/images/van-phong-tan-minh-nhan-phoi-canh-tren-cao.jpg',
                mobile: '/images/van-phong-tan-minh-nhan-phoi-canh-tren-cao.jpg',
                alt: 'Tân Minh Nhân Dự án 02'
            }
        ],

        init() {
            this.startSlideShow();
        },

        startSlideShow() {
            this.resetProgress();
            this.startTime = performance.now();

            const updateProgress = (now) => {
                const elapsed = now - this.startTime;
                this.progress = Math.min((elapsed / this.duration) * 100, 100);

                if (elapsed >= this.duration) {
                    this.next();
                } else {
                    this.animFrame = requestAnimationFrame(updateProgress);
                }
            };

            this.animFrame = requestAnimationFrame(updateProgress);
        },

        resetProgress() {
            if (this.animFrame) cancelAnimationFrame(this.animFrame);
            this.progress = 0;
        },

        next() {
            this.resetProgress();
            this.current = (this.current + 1) % this.slides.length;
            this.startSlideShow();
        },

        prev() {
            this.resetProgress();
            this.current = (this.current - 1 + this.slides.length) % this.slides.length;
            this.startSlideShow();
        }
    }"
    class="relative h-screen min-h-[100dvh] w-full overflow-hidden bg-black select-none"
>

    {{-- =====================================================
         BACKGROUND SLIDESHOW (FULLSCREEN CO GIÃN NÉT CĂNG)
    ====================================================== --}}
    <template x-for="(slide, index) in slides" :key="slide.id">
        <div
            x-show="current === index"
            x-transition:enter="transition-opacity duration-1000 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-1000 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 h-full w-full pointer-events-none overflow-hidden"
        >
            {{-- Wrapper hiệu ứng Ken Burns zoom nhẹ mượt mà --}}
            <div
                class="absolute inset-0 h-full w-full transform duration-[7000ms] ease-out will-change-transform"
                :class="current === index ? 'scale-100' : 'scale-105'"
            >
                <picture class="block h-full w-full">
                    {{-- Desktop: Màn hình >= 768px tải ảnh ngang --}}
                    <source media="(min-width: 768px)" :srcset="slide.desktop">

                    {{-- Mobile: Tự động đổi sang ảnh dọc, ép 100% diện tích không méo hình --}}
                    <img
                        :src="slide.mobile"
                        :alt="slide.alt"
                        style="width: 100% !important; height: 100% !important; max-width: none !important; object-fit: cover !important; object-position: center !important;"
                        class="block"
                        :loading="index === 0 ? 'eager' : 'lazy'"
                        :fetchpriority="index === 0 ? 'high' : 'low'"
                        decoding="async"
                    />
                </picture>
            </div>

            {{-- Gradient overlay phủ đáy bảo đảm rõ các nút điều khiển --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20"></div>
        </div>
    </template>

    {{-- =====================================================
         CONTROLS & PROGRESS BAR
    ====================================================== --}}
    <div class="absolute inset-x-6 bottom-10 z-20 mx-auto max-w-7xl md:inset-x-12 flex items-end justify-between">

        {{-- Số slide & thanh tiến trình màu đỏ --}}
        <div class="flex items-center gap-4">
            <span
                class="font-mono text-2xl md:text-3xl font-bold text-red-600 tracking-tight"
                x-text="'0' + (current + 1)"
            ></span>

            <div class="relative h-[2px] w-20 md:w-28 overflow-hidden rounded-full bg-white/20">
                <div
                    class="absolute inset-y-0 left-0 bg-red-600 transition-[width] ease-linear"
                    :style="'width: ' + progress + '%'"
                ></div>
            </div>

            <span
                class="font-mono text-lg md:text-xl font-light text-white/50"
                x-text="'0' + slides.length"
            ></span>
        </div>

        {{-- Nút điều hướng Prev / Next --}}
        <div class="flex items-center gap-3">
            <button
                type="button"
                @click="prev()"
                aria-label="Previous Slide"
                class="flex h-11 w-11 md:h-12 md:w-12 items-center justify-center rounded-full border border-white/20 text-white backdrop-blur-sm transition-all duration-300 hover:border-red-600 hover:bg-red-600 active:scale-95"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button
                type="button"
                @click="next()"
                aria-label="Next Slide"
                class="flex h-11 w-11 md:h-12 md:w-12 items-center justify-center rounded-full border border-white/20 text-white backdrop-blur-sm transition-all duration-300 hover:border-red-600 hover:bg-red-600 active:scale-95"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

    </div>

</section>