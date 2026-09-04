@extends('layouts.app')

@section('content')

<div class="page-transition">

    {{-- =====================================================
         ABOUT HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 pt-36 text-white sm:pt-44">

        <div class="container-page relative z-10">

            <div class="grid min-h-[650px] items-end gap-12 pb-20 lg:grid-cols-[1fr_0.65fr] lg:pb-24">

                <div>

                    <p class="eyebrow !text-red-400">
                        Về chúng tôi
                    </p>

                    <h1
                        class="mt-7 max-w-5xl font-display text-6xl font-semibold leading-[0.88] tracking-[-0.07em] text-white sm:text-7xl lg:text-9xl"
                    >
                        CHÜNG TÔI XÂY DỰNG
                        <br>
                        VỚI
                        <br>
                        MỤC ĐÍCH.
                    </h1>

                    <p class="mt-8 max-w-2xl text-base leading-8 text-white/55 sm:text-lg">
                        Chúng tôi kết hợp kiến trúc, kỹ thuậ t và xây dựng
                        để tạo ra những nơi một cách ý nghĩa,
                        chịu đựng và được tạo ra để tồn tại lâu dài.
                    </p>

                </div>


                <div class="lg:pb-2">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Phương pháp tiếp cận của chúng tôi
                        </p>

                        <p class="mt-4 font-display text-2xl font-medium leading-tight tracking-[-0.035em] text-white">
                            Thiết kế với mục đích.
                            Xây dựng với độ chín chỼ.
                            Giao hàng với trách nhiệm.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Architectural grid --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-10"
            aria-hidden="true"
        >

            <div
                class="absolute inset-y-0 left-[18%] w-px bg-white"
            ></div>

            <div
                class="absolute inset-y-0 left-[50%] w-px bg-white"
            ></div>

            <div
                class="absolute inset-y-0 left-[82%] w-px bg-white"
            ></div>

            <div
                class="absolute left-0 right-0 top-[45%] h-px bg-white"
            ></div>

        </div>

    </section>


    {{-- =====================================================
         INTRO / BRAND STORY
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.65fr_1.35fr]">

                <div>

                    <p class="eyebrow">
                        Câu chuyện của chúng tôi
                    </p>

                    <p class="mt-6 max-w-xs text-sm leading-7 text-slate-500">
                        Một đội ngành nhiều mãng nghiề cam kết để tạo ra
                        những nơi tốt hơn thông qua thiết kế lược
                        và xây dựng trách nhiệm.
                    </p>

                </div>


                <div>

                    <h2
                        class="max-w-5xl font-display text-4xl font-semibold leading-[1.02] tracking-[-0.055em] sm:text-5xl lg:text-7xl"
                    >
                        Kiến trúc không chỉ là về
                        cách tòa nhà có hình thóp.
                        Nó là cách nó hoạt động,
                        tuổi và sống.
                    </h2>


                    <div class="mt-10 grid gap-8 md:grid-cols-2">

                        <p class="text-base leading-8 text-slate-500">
                            Mọi dự án bắt đầu với bối cảnh. Chúng tôi định
                            khám phá kổ vệ, hiểu những người sờ dụng
                            nó và xác định các yêu cầu kỹ thuậ t trước
                            khi chuyển sang thiết kế và thực hiện.
                        </p>

                        <p class="text-base leading-8 text-slate-500">
                            Các đội ngành của chúng tôi làm việc trên
                            kiến trúc, kỹ thuậ t, mua sắm và xây dựng
                            để đảm bảo tính liên tục từ bản vẽ đầu tiên
                            đến bàn giao cuối cùng.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         VISION / MISSION
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="grid gap-5 lg:grid-cols-2">

                {{-- Vision --}}
                <div class="relative overflow-hidden bg-slate-950 p-8 text-white sm:p-12 lg:p-16">

                    <span
                        class="font-display text-[11px] font-bold uppercase tracking-[0.15em] text-red-400"
                    >
                        01 / Vision
                    </span>

                    <div class="mt-20">

                        <h2
                            class="max-w-xl font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] text-white sm:text-5xl"
                        >
                            Create enduring
                            spaces for
                            generations.
                        </h2>

                        <p class="mt-7 max-w-xl leading-7 text-white/50">
                            We believe the best buildings balance ambition
                            with responsibility, combining design quality,
                            technical performance and long-term value.
                        </p>

                    </div>

                    <div
                        class="absolute -bottom-20 -right-12 h-56 w-56 rounded-full border border-white/10"
                    ></div>

                    <div
                        class="absolute -bottom-32 -right-24 h-72 w-72 rounded-full border border-white/5"
                    ></div>

                </div>


                {{-- Mission --}}
                <div class="relative overflow-hidden bg-white p-8 ring-1 ring-slate-200 sm:p-12 lg:p-16">

                    <span
                        class="font-display text-[11px] font-bold uppercase tracking-[0.15em] text-blue-700"
                    >
                        02 / Mission
                    </span>

                    <div class="mt-20">

                        <h2
                            class="max-w-xl font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] sm:text-5xl"
                        >
                            Turn complex
                            requirements
                            into clear outcomes.
                        </h2>

                        <p class="mt-7 max-w-xl leading-7 text-slate-500">
                            We simplify complexity through clear
                            coordination, rigorous documentation and
                            accountable project delivery.
                        </p>

                    </div>

                    <div class="absolute right-8 top-8 h-14 w-14 border-r border-t border-slate-200"></div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         METRICS
         ===================================================== --}}
    <section class="section bg-slate-950 text-white">

        <div class="container-page">

            <div class="mb-14 max-w-3xl">

                <p class="eyebrow !text-white/50">
                    By the numbers
                </p>

                <h2
                    class="mt-5 font-display text-4xl font-semibold leading-[1] tracking-[-0.055em] text-white sm:text-6xl"
                >
                    Experience measured
                    in real outcomes.
                </h2>

            </div>


            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">

                <div class="metric">

                    <div class="metric-number">
                        25+
                    </div>

                    <p class="mt-3 max-w-[180px] text-sm leading-6 text-white/45">
                        Years delivering architecture and construction.
                    </p>

                </div>


                <div class="metric">

                    <div class="metric-number">
                        180+
                    </div>

                    <p class="mt-3 max-w-[180px] text-sm leading-6 text-white/45">
                        Projects completed across multiple sectors.
                    </p>

                </div>


                <div class="metric">

                    <div class="metric-number">
                        98%
                    </div>

                    <p class="mt-3 max-w-[180px] text-sm leading-6 text-white/45">
                        Client satisfaction and repeat collaboration.
                    </p>

                </div>


                <div class="metric">

                    <div class="metric-number">
                        100%
                    </div>

                    <p class="mt-3 max-w-[180px] text-sm leading-6 text-white/45">
                        Commitment to construction safety standards.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CAPABILITIES
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-12 lg:grid-cols-[0.65fr_1.35fr]">

                <div>

                    <p class="eyebrow">
                        Engineering capability
                    </p>

                    <h2 class="mt-5 max-w-md font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] sm:text-5xl">
                        Built on technical
                        discipline.
                    </h2>

                </div>


                <div>

                    <p class="max-w-3xl text-lg leading-8 text-slate-500">
                        Our capability extends beyond architectural design.
                        We coordinate technical disciplines and construction
                        operations to ensure that every design decision can
                        be executed with confidence.
                    </p>


                    <div class="mt-12">

                        {{-- Capability 01 --}}
                        <div class="service-item">

                            <span class="service-number">
                                01
                            </span>

                            <div>

                                <h3 class="service-title">
                                    BIM & Digital Coordination
                                </h3>

                                <p class="service-description">
                                    Integrated digital workflows for
                                    coordination, clash detection and
                                    technical documentation.
                                </p>

                            </div>

                            <span class="text-sm font-semibold text-slate-400">
                                BIM
                            </span>

                        </div>


                        {{-- Capability 02 --}}
                        <div class="service-item">

                            <span class="service-number">
                                02
                            </span>

                            <div>

                                <h3 class="service-title">
                                    Structural Engineering
                                </h3>

                                <p class="service-description">
                                    Structural systems engineered for
                                    performance, constructability and
                                    long-term reliability.
                                </p>

                            </div>

                            <span class="text-sm font-semibold text-slate-400">
                                STR
                            </span>

                        </div>


                        {{-- Capability 03 --}}
                        <div class="service-item">

                            <span class="service-number">
                                03
                            </span>

                            <div>

                                <h3 class="service-title">
                                    Quality Control
                                </h3>

                                <p class="service-description">
                                    Inspection, documentation and quality
                                    management throughout construction.
                                </p>

                            </div>

                            <span class="text-sm font-semibold text-slate-400">
                                QC
                            </span>

                        </div>


                        {{-- Capability 04 --}}
                        <div class="service-item">

                            <span class="service-number">
                                04
                            </span>

                            <div>

                                <h3 class="service-title">
                                    Safety Management
                                </h3>

                                <p class="service-description">
                                    Proactive safety planning and site
                                    management with a zero-compromise
                                    approach.
                                </p>

                            </div>

                            <span class="text-sm font-semibold text-slate-400">
                                HSE
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         LEADERSHIP
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="mb-14">

                <p class="eyebrow">
                    Leadership
                </p>

                <h2 class="section-title max-w-4xl">
                    People behind
                    every project.
                </h2>

                <p class="section-description">
                    A multidisciplinary leadership team bringing together
                    architectural vision, engineering expertise and
                    construction experience.
                </p>

            </div>


            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

                {{-- Leader 01 --}}
                <article class="arch-card group">

                    <div class="aspect-[4/5] overflow-hidden bg-slate-200">

                        <div class="flex h-full items-end bg-gradient-to-br from-slate-300 to-slate-500 p-7">

                            <div>

                                <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-white/60">
                                    Executive Leadership
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="p-6">

                        <p class="font-display text-xl font-semibold tracking-[-0.03em]">
                            Managing Director
                        </p>

                        <p class="mt-2 text-sm text-slate-500">
                            Executive Leadership
                        </p>

                    </div>

                </article>


                {{-- Leader 02 --}}
                <article class="arch-card group">

                    <div class="aspect-[4/5] overflow-hidden bg-slate-200">

                        <div class="flex h-full items-end bg-gradient-to-br from-slate-400 to-slate-600 p-7">

                            <div>

                                <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-white/60">
                                    Architecture
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="p-6">

                        <p class="font-display text-xl font-semibold tracking-[-0.03em]">
                            Chief Architect
                        </p>

                        <p class="mt-2 text-sm text-slate-500">
                            Architecture & Design
                        </p>

                    </div>

                </article>


                {{-- Leader 03 --}}
                <article class="arch-card group">

                    <div class="aspect-[4/5] overflow-hidden bg-slate-200">

                        <div class="flex h-full items-end bg-gradient-to-br from-slate-300 to-slate-600 p-7">

                            <div>

                                <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-white/60">
                                    Engineering
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="p-6">

                        <p class="font-display text-xl font-semibold tracking-[-0.03em]">
                            Chief Project Engineer
                        </p>

                        <p class="mt-2 text-sm text-slate-500">
                            Engineering & Construction
                        </p>

                    </div>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CERTIFICATIONS
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-12 lg:grid-cols-[0.65fr_1.35fr]">

                <div>

                    <p class="eyebrow">
                        Standards
                    </p>

                    <h2 class="mt-5 max-w-md font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] sm:text-5xl">
                        Standards
                        matter.
                    </h2>

                </div>


                <div>

                    <p class="max-w-2xl leading-8 text-slate-500">
                        We believe trust is built through measurable
                        standards, documented processes and a culture
                        of continuous improvement.
                    </p>


                    <div class="mt-10 divide-y divide-slate-200 border-y border-slate-200">

                        <div class="flex items-center justify-between gap-6 py-6">

                            <div>

                                <p class="font-display text-lg font-semibold">
                                    ISO Quality Management
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Quality management systems
                                </p>

                            </div>

                            <span class="tag">
                                ISO
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-6 py-6">

                            <div>

                                <p class="font-display text-lg font-semibold">
                                    Occupational Safety
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Health & safety management
                                </p>

                            </div>

                            <span class="tag">
                                HSE
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-6 py-6">

                            <div>

                                <p class="font-display text-lg font-semibold">
                                    Sustainable Construction
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Responsible material and site practices
                                </p>

                            </div>

                            <span class="tag">
                                ESG
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         CTA
         ===================================================== --}}
    <section class="section section-blueprint">

        <div class="container-page relative z-10">

            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">

                <div>

                    <p class="eyebrow !text-white/60">
                        Work with us
                    </p>

                    <h2 class="mt-6 max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl lg:text-8xl">
                        LET'S CREATE
                        SOMETHING
                        THAT LASTS.
                    </h2>

                </div>


                <a
                    href="{{ route('contact.index') }}"
                    class="btn-white group min-w-[210px]"
                >

                    Start a conversation

                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                        →
                    </span>

                </a>

            </div>

        </div>

    </section>

</div>

@endsection