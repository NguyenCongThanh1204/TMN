{{-- =========================================================
     ARCHITECTURAL MASTER INTRO (Curtain Split + Counter + Blueprint)
     resources/views/components/splash-screen.blade.php
     ========================================================= --}}

<div
    x-data="{
        showIntro: false,
        isLeaving: false,
        progress: 0,
        init() {
            if (!sessionStorage.getItem('tmn_intro_viewed')) {
                this.showIntro = true;
                document.body.classList.add('overflow-hidden');

                // Chạy counter mượt mà từ 0 -> 100
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                        this.progress += Math.floor(Math.random() * 4) + 2;
                        if (this.progress > 100) this.progress = 100;
                    } else {
                        clearInterval(interval);
                        // Đạt 100% thì tách rèm ra
                        setTimeout(() => {
                            this.isLeaving = true;
                            document.body.classList.remove('overflow-hidden');
                            setTimeout(() => {
                                this.showIntro = false;
                                sessionStorage.setItem('tmn_intro_viewed', 'true');
                            }, 850);
                        }, 400);
                    }
                }, 30);
            }
        },
        skipIntro() {
            this.isLeaving = true;
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => {
                this.showIntro = false;
                sessionStorage.setItem('tmn_intro_viewed', 'true');
            }, 500);
        }
    }"
    x-cloak
    x-show="showIntro"
    class="fixed inset-0 z-[999999] select-none overflow-hidden"
    aria-hidden="true"
>
    {{-- ==================== RÈM TRÊN (TOP CURTAIN) ==================== --}}
    <div
        class="absolute inset-x-0 top-0 h-1/2 bg-[#0B0F17] border-b border-white/10 transition-transform duration-800 ease-[cubic-bezier(0.77,0,0.175,1)]"
        :class="isLeaving ? '-translate-y-full' : 'translate-y-0'"
    ></div>

    {{-- ==================== RÈM DƯỚI (BOTTOM CURTAIN) ==================== --}}
    <div
        class="absolute inset-x-0 bottom-0 h-1/2 bg-[#0B0F17] border-t border-white/10 transition-transform duration-800 ease-[cubic-bezier(0.77,0,0.175,1)]"
        :class="isLeaving ? 'translate-y-full' : 'translate-y-0'"
    ></div>

    {{-- ==================== NỘI DUNG TÂM (FADE OUT KHI RÈM MỞ) ==================== --}}
    <div
        class="relative z-20 w-full h-full flex flex-col items-center justify-between py-12 px-6 transition-opacity duration-400 pointer-events-none"
        :class="isLeaving ? 'opacity-0 scale-95' : 'opacity-100 scale-100'"
    >
        {{-- Header nhỏ: Tọa độ & Tên công ty chuẩn kỹ thuật --}}
        <div class="flex items-center justify-between w-full max-w-5xl text-[10px] sm:text-xs font-mono tracking-widest text-slate-500 uppercase">
            <span>TÂN MINH NHÂN CORP</span>
            <span class="text-[#EB323A] font-bold">EST. 2008 &bull; VIETNAM</span>
        </div>

        {{-- Khối Trung tâm: Logo + Tia sáng quét + Slogan --}}
        <div class="flex flex-col items-center justify-center my-auto text-center w-full max-w-xl">
            
            {{-- Logo kèm hiệu ứng tia sáng quét ngang qua --}}
            <div class="relative overflow-hidden p-2">
                <img
                    src="{{ asset('images/TMN_logo_ngang.png') }}"
                    alt="Tân Minh Nhân Corporation"
                    class="h-16 sm:h-20 md:h-24 w-auto object-contain drop-shadow-[0_10px_35px_rgba(235,50,58,0.25)]"
                    onerror="this.src='https://www.tanminhnhan.com.vn/images/ap-smart-layerslider/homepage/logo.png'"
                />
                {{-- Tia sáng quét (Light Ray) --}}
                <div class="light-ray-sweep absolute inset-0 -skew-x-12 bg-gradient-to-r from-transparent via-white/30 to-transparent pointer-events-none"></div>
            </div>

            {{-- Câu khẩu hiệu kiến trúc --}}
            <div class="mt-6 flex items-center gap-3">
                <span class="h-[1px] w-6 sm:w-10 bg-[#EB323A]"></span>
                <p class="text-xs sm:text-sm uppercase tracking-[0.35em] text-slate-300 font-light">
                    Kiến tạo không gian &bull; Vững bền tương lai
                </p>
                <span class="h-[1px] w-6 sm:w-10 bg-[#EB323A]"></span>
            </div>

            {{-- Bộ đếm phần trăm kỹ thuật số (Architecture Counter) --}}
            <div class="mt-8 flex items-baseline gap-2 font-mono">
                <span class="text-3xl sm:text-4xl font-bold text-white tracking-tighter" x-text="progress"></span>
                <span class="text-xs text-[#EB323A] font-bold">%</span>
            </div>

            {{-- Vạch tiến độ loading cực mảnh --}}
            <div class="mt-3 w-48 sm:w-64 h-[2px] bg-slate-800 rounded-full overflow-hidden">
                <div
                    class="h-full bg-gradient-to-r from-[#EB323A] to-red-400 transition-all duration-100 ease-out"
                    :style="'width: ' + progress + '%'"
                ></div>
            </div>
        </div>

        {{-- Footer của Splash: Nút Bỏ Qua (Cho phép click) --}}
        <div class="pointer-events-auto">
            <button
                type="button"
                @click="skipIntro()"
                class="group flex items-center gap-2 text-[11px] font-mono tracking-widest text-slate-500 hover:text-white uppercase transition-colors py-2 px-4 rounded-full border border-white/10 hover:border-[#EB323A]/50 bg-white/5 cursor-pointer backdrop-blur-xs"
            >
                <span>Bỏ qua phần giới thiệu</span>
                <span class="text-[#EB323A] group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes lightRay {
        0% { transform: translateX(-150%) skewX(-20deg); }
        50%, 100% { transform: translateX(250%) skewX(-20deg); }
    }
    .light-ray-sweep {
        animation: lightRay 2.8s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
</style>