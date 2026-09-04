@extends('layouts.app')

@section('content')

<div class="page-transition">

    {{-- =====================================================
         CAREERS HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 pt-36 text-white sm:pt-44">

        <div class="container-page relative z-10">

            <div class="grid min-h-[650px] items-end gap-12 pb-20 lg:grid-cols-[1fr_.55fr] lg:pb-24">

                <div>

                    <p class="eyebrow !text-red-400">
                        Tuyển dụng
                    </p>

                    <h1
                        class="mt-7 max-w-6xl font-display text-6xl font-semibold leading-[0.88] tracking-[-0.07em] text-white sm:text-7xl lg:text-[8rem]"
                    >
                        XÂY DỰNG
                        <br>
                        TƯƠNG LAI
                        <br>
                        CỦA BẠN.
                    </h1>

                    <p class="mt-8 max-w-2xl text-base leading-8 text-white/55 sm:text-lg">
                        Tham gia một đội ngành nhiều mãng nghiề đang
                        hình thành kiến trúc, kỹ thuậ t và dự án
                        xây dựng vỚer tậm vóc, độ chín chỼ và trách nhiệm.
                    </p>

                </div>


                <div class="lg:pb-3">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Làm việc với chúng tôi
                        </p>

                        <p class="mt-4 font-display text-2xl font-medium leading-tight tracking-[-0.035em] text-white">
                            Các tòa nhà tuyệt vời
                            được tạo bởi
                            những đội ngành tuyệt vời.
                        </p>

                        <a
                            href="#open-positions"
                            class="mt-7 inline-flex items-center gap-3 font-display text-xs font-bold uppercase tracking-[0.1em] text-white transition-colors hover:text-red-400"
                        >
                            Khám phá cơ hội

                            <span>
                                ↓
                            </span>
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Architectural grid --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.08]"
            aria-hidden="true"
        >

            <div class="absolute inset-y-0 left-[20%] w-px bg-white"></div>
            <div class="absolute inset-y-0 left-[50%] w-px bg-white"></div>
            <div class="absolute inset-y-0 left-[80%] w-px bg-white"></div>

            <div class="absolute left-0 right-0 top-[48%] h-px bg-white"></div>

        </div>

    </section>


    {{-- =====================================================
         INTRODUCTION
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.55fr_1.45fr]">

                <div>

                    <p class="eyebrow">
                        Văn hóa của chúng tôi
                    </p>

                    <p class="mt-6 max-w-sm text-sm leading-7 text-slate-500">
                        Chúng tôi tin rằng các dự án tuyệt vời có nguồn
                        gốc từ những người chú ĩ chi tiết,
                        giao tiếp rõ ràng và chịu trách nhiệm
                        với công việc họ thực hiện.
                    </p>

                </div>


                <div>

                    <h2 class="max-w-5xl font-display text-4xl font-semibold leading-[1] tracking-[-0.055em] sm:text-5xl lg:text-7xl">

                        Làm việc trên các dự án có nghĩa.
                        Học hỏi từ các đội ngành đã có kinh nghiệm.
                        Phát triển vỚer trách nhiệm.

                    </h2>

                    <div class="mt-10 grid gap-8 md:grid-cols-2">

                        <p class="leading-8 text-slate-500">
                            Các đội ngành của chúng tôi làm việc trên
                            kiến trúc, kỹ thuậ t, mua sắm và xây dựng.
                            Mọi vai trò đều cóng hiến cho hiệu suất
                            tổng thể của dự án.
                        </p>

                        <p class="leading-8 text-slate-500">
                            Chúng tôi quý trọi những người đặt câu hỏi,
                            giải quyết vấn đề và liên tục cải tiến
                            cách thực làm việc — trên màn hình, trong văn
                            phòng và tại nơi thi công.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         WHY JOIN US
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="mb-14">

                <p class="eyebrow">
                    Why join us
                </p>

                <h2 class="section-title max-w-4xl">
                    A place to build
                    more than buildings.
                </h2>

            </div>


            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">

                {{-- 01 --}}
                <article class="process-step">

                    <span class="process-step-number">
                        01
                    </span>

                    <h3 class="process-step-title">
                        Real projects
                    </h3>

                    <p class="process-step-description">
                        Work directly on architecture and construction
                        projects with real technical and operational
                        challenges.
                    </p>

                </article>


                {{-- 02 --}}
                <article class="process-step">

                    <span class="process-step-number">
                        02
                    </span>

                    <h3 class="process-step-title">
                        Learn from experts
                    </h3>

                    <p class="process-step-description">
                        Collaborate with experienced architects,
                        engineers, supervisors and project leaders.
                    </p>

                </article>


                {{-- 03 --}}
                <article class="process-step">

                    <span class="process-step-number">
                        03
                    </span>

                    <h3 class="process-step-title">
                        Responsibility
                    </h3>

                    <p class="process-step-description">
                        Take ownership of tasks and see how your decisions
                        affect the finished project.
                    </p>

                </article>


                {{-- 04 --}}
                <article class="process-step">

                    <span class="process-step-number">
                        04
                    </span>

                    <h3 class="process-step-title">
                        Long-term growth
                    </h3>

                    <p class="process-step-description">
                        Build a career through continuous learning,
                        mentorship and increasing responsibility.
                    </p>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         SAFETY / PROFESSIONAL STANDARDS
         ===================================================== --}}
    <section class="section bg-slate-950 text-white">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.55fr_1.45fr]">

                <div>

                    <p class="eyebrow !text-white/50">
                        How we work
                    </p>

                    <p class="mt-6 max-w-sm text-sm leading-7 text-white/40">
                        Professional discipline is part of our culture —
                        from technical documentation to site safety.
                    </p>

                </div>


                <div>

                    <h2 class="max-w-5xl font-display text-4xl font-semibold leading-[1] tracking-[-0.055em] text-white sm:text-6xl">

                        Precision in the office.
                        Discipline on site.
                        Respect everywhere.

                    </h2>


                    <div class="mt-12 divide-y divide-white/10 border-y border-white/10">

                        <div class="grid gap-5 py-7 md:grid-cols-[100px_1fr]">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-400">
                                01
                            </span>

                            <div>

                                <h3 class="font-display text-xl font-semibold text-white">
                                    Safety first
                                </h3>

                                <p class="mt-2 max-w-2xl text-sm leading-7 text-white/40">
                                    We expect every team member to contribute
                                    to a safe, professional and controlled
                                    working environment.
                                </p>

                            </div>

                        </div>


                        <div class="grid gap-5 py-7 md:grid-cols-[100px_1fr]">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-400">
                                02
                            </span>

                            <div>

                                <h3 class="font-display text-xl font-semibold text-white">
                                    Technical excellence
                                </h3>

                                <p class="mt-2 max-w-2xl text-sm leading-7 text-white/40">
                                    We value accurate drawings, clear
                                    documentation, strong coordination
                                    and attention to detail.
                                </p>

                            </div>

                        </div>


                        <div class="grid gap-5 py-7 md:grid-cols-[100px_1fr]">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-400">
                                03
                            </span>

                            <div>

                                <h3 class="font-display text-xl font-semibold text-white">
                                    Team accountability
                                </h3>

                                <p class="mt-2 max-w-2xl text-sm leading-7 text-white/40">
                                    Good projects depend on communication,
                                    respect and a shared commitment to
                                    solving problems.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         OPEN POSITIONS
         ===================================================== --}}
    <section
        id="open-positions"
        class="section bg-white"
    >

        <div class="container-page">

            <div class="mb-14 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                <div>

                    <p class="eyebrow">
                        Opportunities
                    </p>

                    <h2 class="section-title">
                        Open positions.
                    </h2>

                </div>

                <p class="max-w-lg text-sm leading-7 text-slate-500">
                    Explore current opportunities across architecture,
                    engineering, quantity surveying, BIM and project
                    execution.
                </p>

            </div>


            @if(isset($careers) && $careers->count())

                <div class="border-y border-slate-200">

                    @foreach($careers as $career)

                        <article
                            x-data="{ open: false }"
                            class="border-b border-slate-200 last:border-b-0"
                        >

                            {{-- Job row --}}
                            <button
                                type="button"
                                @click="open = !open"
                                class="group flex w-full items-center justify-between gap-6 py-7 text-left"
                            >

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-3">

                                        @if($career->department)

                                            <span class="tag-red tag">
                                                {{ $career->department }}
                                            </span>

                                        @endif


                                        @if($career->location)

                                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                                {{ $career->location }}
                                            </span>

                                        @endif

                                    </div>


                                    <h3 class="mt-4 font-display text-2xl font-semibold tracking-[-0.035em] sm:text-3xl">
                                        {{ $career->job_title }}
                                    </h3>

                                </div>


                                <span
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-slate-300 text-xl transition-all duration-300 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white"
                                >

                                    <span
                                        x-text="open ? '−' : '+'"
                                    ></span>

                                </span>

                            </button>


                            {{-- Job detail --}}
                            <div
                                x-cloak
                                x-show="open"
                                x-collapse
                                class="pb-8"
                            >

                                <div class="grid gap-8 lg:grid-cols-[1fr_auto]">

                                    <div>

                                        @if($career->description)

                                            <div class="prose prose-slate max-w-3xl">
                                                {!! nl2br(e($career->description)) !!}
                                            </div>

                                        @else

                                            <p class="text-sm leading-7 text-slate-500">
                                                Detailed job description
                                                will be provided by the
                                                recruitment team.
                                            </p>

                                        @endif

                                    </div>


                                    <div class="min-w-[220px]">

                                        <dl class="space-y-5">

                                            @if($career->salary_range)

                                                <div>

                                                    <dt class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                                        Salary
                                                    </dt>

                                                    <dd class="mt-1 font-display text-sm font-semibold">
                                                        {{ $career->salary_range }}
                                                    </dd>

                                                </div>

                                            @endif


                                            @if($career->deadline)

                                                <div>

                                                    <dt class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                                        Application deadline
                                                    </dt>

                                                    <dd class="mt-1 font-display text-sm font-semibold">
                                                        {{ \Illuminate\Support\Carbon::parse($career->deadline)->format('d M Y') }}
                                                    </dd>

                                                </div>

                                            @endif

                                        </dl>


                                        <button
                                            type="button"
                                            @click="window.dispatchEvent(new CustomEvent('open-career-form', { detail: { job: @js($career->job_title) } }))"
                                            class="btn-primary mt-7 w-full"
                                        >
                                            Apply for this role →
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                {{-- Empty positions --}}
                <div class="border border-dashed border-slate-300 bg-slate-50 px-8 py-20 text-center">

                    <p class="eyebrow justify-center">
                        Recruitment
                    </p>

                    <h3 class="mt-5 font-display text-3xl font-semibold tracking-[-0.04em]">
                        No open positions right now.
                    </h3>

                    <p class="mx-auto mt-4 max-w-lg text-sm leading-7 text-slate-500">
                        You can still send us your CV. We keep strong
                        candidates in mind for future opportunities.
                    </p>

                    <button
                        type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-career-form'))"
                        class="btn-dark mt-7"
                    >
                        Send your CV
                    </button>

                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         BENEFITS
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.55fr_1.45fr]">

                <div>

                    <p class="eyebrow">
                        Employee benefits
                    </p>

                    <h2 class="mt-5 max-w-md font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] sm:text-5xl">
                        Support that
                        moves with you.
                    </h2>

                    <p class="mt-6 max-w-sm text-sm leading-7 text-slate-500">
                        We aim to create an environment where people can
                        focus on doing meaningful work while having the
                        practical support they need.
                    </p>

                </div>


                <div class="divide-y divide-slate-200 border-y border-slate-200">

                    {{-- Benefit --}}
                    <div class="grid gap-5 py-7 sm:grid-cols-[55px_1fr]">

                        <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-600">
                            01
                        </span>

                        <div>

                            <h3 class="font-display text-xl font-semibold tracking-[-0.025em]">
                                Competitive compensation
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                Salary based on role, experience and
                                professional capability.
                            </p>

                        </div>

                    </div>


                    <div class="grid gap-5 py-7 sm:grid-cols-[55px_1fr]">

                        <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-600">
                            02
                        </span>

                        <div>

                            <h3 class="font-display text-xl font-semibold tracking-[-0.025em]">
                                Bonuses & recognition
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                Performance and project contribution are
                                recognized through company policies.
                            </p>

                        </div>

                    </div>


                    <div class="grid gap-5 py-7 sm:grid-cols-[55px_1fr]">

                        <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-600">
                            03
                        </span>

                        <div>

                            <h3 class="font-display text-xl font-semibold tracking-[-0.025em]">
                                Insurance & benefits
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                Social insurance and applicable employee
                                benefits according to company policy.
                            </p>

                        </div>

                    </div>


                    <div class="grid gap-5 py-7 sm:grid-cols-[55px_1fr]">

                        <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-600">
                            04
                        </span>

                        <div>

                            <h3 class="font-display text-xl font-semibold tracking-[-0.025em]">
                                Project travel support
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                Travel, accommodation and daily allowances
                                may apply for project assignments.
                            </p>

                        </div>

                    </div>


                    <div class="grid gap-5 py-7 sm:grid-cols-[55px_1fr]">

                        <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-600">
                            05
                        </span>

                        <div>

                            <h3 class="font-display text-xl font-semibold tracking-[-0.025em]">
                                Career development
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                Exposure to real projects, technical
                                learning and opportunities to grow.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         APPLICATION FORM MODAL
         ===================================================== --}}
    <div
        x-data="{
            open: false,
            job: ''
        }"
        @open-career-form.window="
            open = true;
            job = $event.detail?.job ?? '';
            document.body.classList.add('overflow-hidden');
        "
        @keydown.escape.window="
            open = false;
            document.body.classList.remove('overflow-hidden');
        "
    >

        {{-- Overlay --}}
        <div
            x-cloak
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 z-[300] bg-slate-950/80 backdrop-blur-sm"
        ></div>


        {{-- Modal --}}
        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-8 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-8 opacity-0"
            class="fixed inset-0 z-[310] flex items-end justify-center overflow-y-auto p-0 sm:items-center sm:p-6"
        >

            <div
                @click.outside="
                    open = false;
                    document.body.classList.remove('overflow-hidden');
                "
                class="relative max-h-[95vh] w-full overflow-y-auto bg-white shadow-2xl sm:max-w-3xl"
            >

                {{-- Header --}}
                <div class="sticky top-0 z-10 flex items-start justify-between border-b border-slate-200 bg-white px-6 py-6 sm:px-8">

                    <div>

                        <p class="eyebrow">
                            Join our team
                        </p>

                        <h2 class="mt-3 font-display text-3xl font-semibold tracking-[-0.045em]">
                            Apply now.
                        </h2>

                        <p
                            x-show="job"
                            class="mt-2 text-sm text-slate-500"
                        >
                            Applying for:
                            <strong
                                class="text-slate-900"
                                x-text="job"
                            ></strong>
                        </p>

                    </div>


                    <button
                        type="button"
                        @click="
                            open = false;
                            document.body.classList.remove('overflow-hidden');
                        "
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 text-xl text-slate-600 transition-colors hover:bg-slate-950 hover:text-white"
                        aria-label="Close application form"
                    >
                        ×
                    </button>

                </div>


                {{-- Form --}}
                <form
                    action="{{ route('careers.apply') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-6 sm:p-8"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="job_title"
                        :value="job"
                    >


                    {{-- Form errors --}}
                    @if($errors->any())

                        <div class="mb-7 bg-red-50 p-4 text-sm text-red-700">

                            <p class="font-semibold">
                                Please check the following:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- Fields --}}
                    <div class="grid gap-5 sm:grid-cols-2">

                        <div class="sm:col-span-2">

                            <label
                                for="career-full-name"
                                class="form-label"
                            >
                                Full name
                            </label>

                            <input
                                id="career-full-name"
                                type="text"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                required
                                class="form-input"
                                placeholder="Your full name"
                            >

                        </div>


                        <div>

                            <label
                                for="career-email"
                                class="form-label"
                            >
                                Email
                            </label>

                            <input
                                id="career-email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="form-input"
                                placeholder="you@example.com"
                            >

                        </div>


                        <div>

                            <label
                                for="career-phone"
                                class="form-label"
                            >
                                Phone
                            </label>

                            <input
                                id="career-phone"
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                required
                                class="form-input"
                                placeholder="+84..."
                            >

                        </div>


                        <div class="sm:col-span-2">

                            <label
                                for="career-position"
                                class="form-label"
                            >
                                Position
                            </label>

                            <input
                                id="career-position"
                                type="text"
                                name="job_title"
                                :value="job"
                                required
                                class="form-input"
                                placeholder="Position applied for"
                            >

                        </div>


                        <div class="sm:col-span-2">

                            <label
                                for="career-portfolio"
                                class="form-label"
                            >
                                Portfolio / LinkedIn
                            </label>

                            <input
                                id="career-portfolio"
                                type="url"
                                name="portfolio_url"
                                value="{{ old('portfolio_url') }}"
                                class="form-input"
                                placeholder="https://..."
                            >

                        </div>


                        <div class="sm:col-span-2">

                            <label
                                for="career-cv"
                                class="form-label"
                            >
                                Resume / CV
                            </label>

                            <input
                                id="career-cv"
                                type="file"
                                name="cv"
                                accept=".pdf,.doc,.docx"
                                required
                                class="form-input"
                            >

                            <p class="mt-2 text-xs text-slate-400">
                                PDF, DOC or DOCX. Please upload your latest CV.
                            </p>

                        </div>


                        <div class="sm:col-span-2">

                            <label
                                for="career-message"
                                class="form-label"
                            >
                                Message
                            </label>

                            <textarea
                                id="career-message"
                                name="message"
                                rows="6"
                                class="form-input form-textarea"
                                placeholder="Tell us about yourself, your experience and what you would like to contribute..."
                            >{{ old('message') }}</textarea>

                        </div>


                        <div class="sm:col-span-2">

                            <label class="flex items-start gap-3 text-sm leading-6 text-slate-500">

                                <input
                                    type="checkbox"
                                    name="privacy"
                                    value="1"
                                    required
                                    class="mt-1"
                                >

                                <span>
                                    I agree that the information provided
                                    may be used for recruitment purposes.
                                </span>

                            </label>

                        </div>


                        <div class="sm:col-span-2">

                            <button
                                type="submit"
                                class="btn-primary w-full"
                            >
                                Submit application →
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FINAL CTA
         ===================================================== --}}
    <section class="section section-blueprint">

        <div class="container-page relative z-10">

            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">

                <div>

                    <p class="eyebrow !text-white/60">
                        Your next chapter
                    </p>

                    <h2 class="mt-6 max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl lg:text-8xl">

                        READY TO
                        <br>
                        BUILD?

                    </h2>

                    <p class="mt-7 max-w-xl text-sm leading-7 text-white/55">
                        We are always interested in meeting talented people
                        who care about design, engineering and construction.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-career-form'))"
                    class="btn-white group min-w-[220px]"
                >

                    Send your CV

                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                        →
                    </span>

                </button>

            </div>

        </div>

    </section>

</div>

@endsection