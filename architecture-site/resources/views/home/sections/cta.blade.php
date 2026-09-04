{{-- =========================================================
    HOME - SECTION 9
    FINAL CTA
    resources/views/home/sections/cta.blade.php
========================================================= --}}

@php
    /*
    |--------------------------------------------------------------------------
    | CTA configuration
    |--------------------------------------------------------------------------
    | Tạm thời sử dụng config().
    | Sau này có thể đưa toàn bộ dữ liệu này vào database / Nova.
    */

    $companyName = config('site.name', 'Architecture & Construction');

    $phone = config('site.phone', '+84 000 000 000');

    $email = config('site.email', 'contact@example.com');

    $address = config(
        'site.address',
        'Việt Nam'
    );

    $ctaServices = [
        [
            'number' => '01',
            'title' => 'Tư vấn dự án',
            'description' => 'Trao đổi nhu cầu, ngân sách và định hướng đầu tư.',
        ],
        [
            'number' => '02',
            'title' => 'Thiết kế kiến trúc',
            'description' => 'Phát triển ý tưởng thành giải pháp kiến trúc hoàn chỉnh.',
        ],
        [
            'number' => '03',
            'title' => 'Thi công xây dựng',
            'description' => 'Triển khai công trình với quy trình kiểm soát chặt chẽ.',
        ],
    ];
@endphp


<section
    id="contact-cta"
    class="relative overflow-hidden bg-slate-950 text-white"
>


    {{-- =========================================================
        BACKGROUND GRID
    ========================================================== --}}

    <div
        class="pointer-events-none absolute inset-0 opacity-[0.07]"
        aria-hidden="true"
    >

        <div
            class="cta-grid absolute inset-0"
        ></div>

    </div>


    {{-- Decorative shapes --}}

    <div
        class="pointer-events-none absolute -left-40 top-1/2
               h-[500px] w-[500px]
               -translate-y-1/2 rounded-full
               border border-white/10"
        aria-hidden="true"
    ></div>


    <div
        class="pointer-events-none absolute -right-32 -top-32
               h-[500px] w-[500px]
               rounded-full border border-red-500/20"
        aria-hidden="true"
    ></div>


    <div
        class="pointer-events-none absolute right-[12%] bottom-0
               h-72 w-72 rounded-full
               bg-red-600/10 blur-3xl"
        aria-hidden="true"
    ></div>



    <div class="container-page relative z-10">


        {{-- =========================================================
            MAIN CTA
        ========================================================== --}}

        <div
            class="grid min-h-[680px]
                   items-center gap-16
                   py-24
                   lg:grid-cols-[1.1fr_.9fr]
                   lg:py-32"
        >


            {{-- =====================================================
                LEFT CONTENT
            ====================================================== --}}

            <div>

                <div
                    class="flex items-center gap-4"
                >

                    <span
                        class="h-px w-12 bg-red-500"
                    ></span>

                    <span
                        class="text-xs font-bold uppercase
                               tracking-[0.3em] text-red-400"
                    >
                        Bắt đầu dự án
                    </span>

                </div>


                <h2
                    class="mt-7 max-w-4xl
                           text-5xl font-bold
                           tracking-[-0.04em]
                           text-white
                           sm:text-6xl
                           lg:text-7xl
                           xl:text-8xl"
                >
                    Hãy biến
                    <span class="text-red-500">
                        ý tưởng
                    </span>
                    thành công trình.
                </h2>


                <p
                    class="mt-8 max-w-2xl
                           text-base leading-8
                           text-white/60
                           sm:text-lg"
                >
                    Bạn đang chuẩn bị một dự án mới?

                    Hãy chia sẻ với chúng tôi những yêu cầu,
                    ý tưởng và định hướng của bạn.

                    Đội ngũ kiến trúc sư và kỹ sư sẽ cùng bạn
                    xây dựng giải pháp phù hợp.
                </p>


                {{-- =================================================
                    CTA BUTTONS
                ================================================== --}}

                <div
                    class="mt-10 flex flex-col gap-4
                           sm:flex-row"
                >

                    <a
                        href="{{ route('contact.index') }}"
                        class="group inline-flex items-center
                               justify-center gap-3
                               bg-red-600 px-7 py-4
                               text-sm font-bold text-white
                               transition-all duration-300
                               hover:bg-red-700
                               hover:shadow-[0_15px_40px_rgba(220,38,38,.25)]"
                    >

                        <span>
                            Yêu cầu báo giá
                        </span>

                        <span
                            class="text-lg transition-transform
                                   duration-300
                                   group-hover:translate-x-1"
                        >
                            →
                        </span>

                    </a>


                    <a
                        href="{{ route('projects.index') }}"
                        class="group inline-flex items-center
                               justify-center gap-3
                               border border-white/20
                               px-7 py-4
                               text-sm font-bold text-white
                               transition-all duration-300
                               hover:border-white
                               hover:bg-white
                               hover:text-slate-950"
                    >

                        <span>
                            Xem công trình
                        </span>

                        <span
                            class="text-lg transition-transform
                                   duration-300
                                   group-hover:translate-x-1"
                        >
                            ↗
                        </span>

                    </a>

                </div>


                {{-- =================================================
                    CONTACT QUICK INFO
                ================================================== --}}

                <div
                    class="mt-12 flex flex-col gap-6
                           border-t border-white/10
                           pt-7
                           sm:flex-row sm:items-center"
                >

                    <a
                        href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                        class="group"
                    >

                        <span
                            class="block text-[10px]
                                   font-bold uppercase
                                   tracking-[0.2em]
                                   text-white/35"
                        >
                            Hotline
                        </span>

                        <span
                            class="mt-1 block text-sm
                                   font-semibold text-white
                                   transition-colors
                                   group-hover:text-red-400"
                        >
                            {{ $phone }}
                        </span>

                    </a>


                    <span
                        class="hidden h-8 w-px bg-white/10 sm:block"
                    ></span>


                    <a
                        href="mailto:{{ $email }}"
                        class="group"
                    >

                        <span
                            class="block text-[10px]
                                   font-bold uppercase
                                   tracking-[0.2em]
                                   text-white/35"
                        >
                            Email
                        </span>

                        <span
                            class="mt-1 block text-sm
                                   font-semibold text-white
                                   transition-colors
                                   group-hover:text-red-400"
                        >
                            {{ $email }}
                        </span>

                    </a>

                </div>

            </div>



            {{-- =====================================================
                RIGHT - SERVICE CARDS
            ====================================================== --}}

            <div
                class="relative"
                x-data="{
                    active: 0,
                    services: {{ count($ctaServices) }}
                }"
            >

                {{-- Vertical line --}}

                <div
                    class="absolute left-6 top-8 bottom-8
                           hidden w-px bg-white/10 sm:block"
                    aria-hidden="true"
                ></div>


                <div class="space-y-4">

                    @foreach($ctaServices as $index => $service)

                        <div
                            class="group relative"
                            @mouseenter="active = {{ $index }}"
                        >

                            <div
                                class="relative overflow-hidden
                                       border border-white/10
                                       bg-white/[0.035]
                                       p-6
                                       transition-all duration-500
                                       hover:border-white/20
                                       hover:bg-white/[0.07]
                                       sm:ml-12 sm:p-7"
                            >

                                {{-- Hover accent --}}

                                <div
                                    class="absolute inset-y-0 left-0
                                           w-1 origin-bottom
                                           scale-y-0 bg-red-600
                                           transition-transform
                                           duration-500
                                           group-hover:scale-y-100"
                                ></div>


                                <div
                                    class="flex gap-5"
                                >

                                    {{-- Number --}}

                                    <div
                                        class="relative z-10
                                               flex h-11 w-11
                                               shrink-0
                                               items-center
                                               justify-center
                                               border border-white/10
                                               text-xs font-bold
                                               text-white/40
                                               transition-all duration-300
                                               group-hover:border-red-500
                                               group-hover:bg-red-600
                                               group-hover:text-white"
                                    >
                                        {{ $service['number'] }}
                                    </div>


                                    {{-- Content --}}

                                    <div>

                                        <h3
                                            class="text-xl font-bold
                                                   text-white"
                                        >
                                            {{ $service['title'] }}
                                        </h3>

                                        <p
                                            class="mt-2 text-sm
                                                   leading-6
                                                   text-white/45
                                                   transition-colors
                                                   duration-300
                                                   group-hover:text-white/65"
                                        >
                                            {{ $service['description'] }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- =================================================
                    ADDRESS
                ================================================== --}}

                <div
                    class="mt-8 border border-white/10
                           bg-white/[0.025] p-6"
                >

                    <div class="flex gap-4">

                        <div
                            class="flex h-10 w-10 shrink-0
                                   items-center justify-center
                                   bg-red-600/10
                                   text-red-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                                />
                            </svg>
                        </div>


                        <div>

                            <p
                                class="text-[10px] font-bold
                                       uppercase tracking-[0.2em]
                                       text-white/30"
                            >
                                Văn phòng
                            </p>

                            <p
                                class="mt-2 text-sm
                                       leading-6 text-white/65"
                            >
                                {{ $address }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            BOTTOM BRAND BAR
        ========================================================== --}}

        <div
            class="border-t border-white/10
                   py-7"
        >

            <div
                class="flex flex-col gap-5
                       sm:flex-row
                       sm:items-center
                       sm:justify-between"
            >

                <div>

                    <p
                        class="text-sm font-bold
                               tracking-tight text-white"
                    >
                        {{ $companyName }}
                    </p>

                    <p
                        class="mt-1 text-xs text-white/35"
                    >
                        Architecture · Engineering · Construction
                    </p>

                </div>


                <div
                    class="flex flex-wrap gap-x-6 gap-y-2
                           text-xs text-white/35"
                >

                    <a
                        href="{{ route('about') }}"
                        class="transition-colors
                               hover:text-white"
                    >
                        Về chúng tôi
                    </a>

                    <a
                        href="{{ route('projects.index') }}"
                        class="transition-colors
                               hover:text-white"
                    >
                        Dự án
                    </a>

                    <a
                        href="{{ route('news.index') }}"
                        class="transition-colors
                               hover:text-white"
                    >
                        Tin tức
                    </a>

                    <a
                        href="{{ route('careers.index') }}"
                        class="transition-colors
                               hover:text-white"
                    >
                        Tuyển dụng
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    CSS
========================================================= --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | Architectural Grid
    |--------------------------------------------------------------------------
    */

    .cta-grid {

        background-image:
            linear-gradient(
                to right,
                rgba(255,255,255,.15) 1px,
                transparent 1px
            ),
            linear-gradient(
                to bottom,
                rgba(255,255,255,.15) 1px,
                transparent 1px
            );

        background-size: 70px 70px;

        mask-image:
            linear-gradient(
                to bottom,
                transparent,
                black 20%,
                black 80%,
                transparent
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Mobile
    |--------------------------------------------------------------------------
    */

    @media (max-width: 640px) {

        .cta-grid {
            background-size: 45px 45px;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Reduced Motion
    |--------------------------------------------------------------------------
    */

    @media (prefers-reduced-motion: reduce) {

        #contact-cta *,
        #contact-cta *::before,
        #contact-cta *::after {

            scroll-behavior: auto !important;
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;

        }

    }

</style>