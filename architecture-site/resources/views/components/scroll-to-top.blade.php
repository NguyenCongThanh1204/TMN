{{-- =========================================================
     MINIMAL CIRCULAR SCROLL TO TOP (CLEAN PROGRESS RING ONLY)
     resources/views/components/scroll-to-top.blade.php
     ========================================================= --}}

<div
    x-data="{
        visible: false,
        progress: 0,
        circumference: 2 * Math.PI * 22, // Bán kính r = 22

        updateScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

            this.visible = scrollTop > 300;

            if (scrollHeight > 0) {
                const percent = Math.min(Math.max(scrollTop / scrollHeight, 0), 1);
                this.progress = this.circumference - (percent * this.circumference);
            }
        },

        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }"
    x-init="
        progress = circumference;
        updateScroll();
    "
    @scroll.window="updateScroll()"
    x-cloak
    class="fixed bottom-7 right-7 z-[999] select-none"
>
    <button
        type="button"
        x-show="visible"
        x-transition:enter="transition duration-300 ease-out transform"
        x-transition:enter-start="opacity-0 translate-y-4 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition duration-200 ease-in transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-90"
        @click="scrollToTop()"
        aria-label="Lên đầu trang"
        class="group relative flex h-12 w-12 items-center justify-center rounded-full bg-slate-950 text-white shadow-xl backdrop-blur-sm transition-transform duration-300 hover:scale-105 active:scale-95"
    >
        {{-- Chỉ duy nhất 1 vòng SVG chạy bo sát mép ngoài của nút --}}
        <svg class="absolute inset-0 h-full w-full -rotate-90 pointer-events-none" viewBox="0 0 48 48">
            {{-- Đường viền mờ làm ray dẫn --}}
            <circle
                cx="24"
                cy="24"
                r="22"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="text-white/15"
            />
            {{-- Vòng tròn đỏ tiến độ ôm sát mép nút --}}
            <circle
                cx="24"
                cy="24"
                r="22"
                fill="none"
                stroke="#dc2626"
                stroke-width="2"
                stroke-linecap="round"
                :stroke-dasharray="circumference"
                :stroke-dashoffset="progress"
                class="transition-[stroke-dashoffset] duration-150 ease-out"
            />
        </svg>

        {{-- Icon mũi tên chuyển động mượt khi hover --}}
        <div class="relative flex h-5 w-5 items-center justify-center overflow-hidden">
            <svg
                class="h-4 w-4 transition-transform duration-300 ease-out group-hover:-translate-y-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>

            <svg
                class="absolute h-4 w-4 translate-y-5 transition-transform duration-300 ease-out group-hover:translate-y-0 text-red-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </div>
    </button>
</div>