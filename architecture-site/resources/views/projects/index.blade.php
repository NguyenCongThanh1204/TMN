@extends('layouts.app')

@section('content')

<div class="page-transition">

    {{-- =====================================================
         PROJECTS HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 pt-36 text-white sm:pt-44">

        <div class="container-page relative z-10">

            <div class="grid min-h-[560px] items-end gap-12 pb-20 lg:grid-cols-[1fr_.5fr] lg:pb-24">

                <div>

                    <p class="eyebrow !text-red-400">
                        Dữf án
                    </p>

                    <h1
                        class="mt-7 max-w-6xl font-display text-6xl font-semibold leading-[0.88] tracking-[-0.07em] text-white sm:text-7xl lg:text-[8rem]"
                    >
                        DỰ ÁN
                        <br>
                        CÓ GIÁ TRỊ.
                    </h1>

                </div>


                <div class="lg:pb-2">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Danh mục lựa chọn
                        </p>

                        <p class="mt-4 max-w-sm text-base leading-7 text-white/55">
                            Một sự lựa chọn các dự án kiến trúc, kỹ thuậ t và
                            xây dựng được thực hiện trên những lĩnh vực
                            dân cư, thương mại, công nghiệp và đểu hành.
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

            <div class="absolute inset-y-0 left-[20%] w-px bg-white"></div>

            <div class="absolute inset-y-0 left-[50%] w-px bg-white"></div>

            <div class="absolute inset-y-0 left-[80%] w-px bg-white"></div>

            <div class="absolute left-0 right-0 top-[48%] h-px bg-white"></div>

        </div>

    </section>


    {{-- =====================================================
         FILTER SECTION
         ===================================================== --}}
    <section class="border-b border-slate-200 bg-white">

        <div class="container-page">

            <div
                x-data="{ active: '{{ request('category') ?? 'all' }}' }"
                class="flex flex-col gap-6 py-7 lg:flex-row lg:items-center lg:justify-between"
            >

                <div>

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                        Khám phá danh mục
                    </p>

                </div>


                <div class="flex gap-2 overflow-x-auto pb-1">

                    {{-- All --}}
                    <a
                        href="{{ route('projects.index') }}"
                        @click="active = 'all'"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200"
                        :class="
                            active === 'all'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                        "
                    >
                        All Projects
                    </a>


                    {{-- Residential --}}
                    <a
                        href="{{ route('projects.index', ['category' => 'Residential']) }}"
                        @click="active = 'Residential'"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200"
                        :class="
                            active === 'Residential'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                        "
                    >
                        Residential
                    </a>


                    {{-- Commercial --}}
                    <a
                        href="{{ route('projects.index', ['category' => 'Commercial']) }}"
                        @click="active = 'Commercial'"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200"
                        :class="
                            active === 'Commercial'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                        "
                    >
                        Commercial
                    </a>


                    {{-- Industrial --}}
                    <a
                        href="{{ route('projects.index', ['category' => 'Industrial']) }}"
                        @click="active = 'Industrial'"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200"
                        :class="
                            active === 'Industrial'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                        "
                    >
                        Industrial
                    </a>


                    {{-- Hospitality --}}
                    <a
                        href="{{ route('projects.index', ['category' => 'Hospitality']) }}"
                        @click="active = 'Hospitality'"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200"
                        :class="
                            active === 'Hospitality'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                        "
                    >
                        Hospitality
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         PROJECT GRID
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            @if(isset($projects) && $projects->count())

                <div class="mb-10 flex items-center justify-between">

                    <div>

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                            Portfolio
                        </p>

                        <p class="mt-2 font-display text-2xl font-semibold tracking-[-0.035em]">
                            {{ $projects->total() }} projects
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     MASONRY-STYLE GRID
                     ================================================= --}}
                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-12">

                    @foreach($projects as $index => $project)

                        @php
                            $featured = $index % 5 === 0;
                        @endphp


                        <a
                            href="{{ route('projects.show', $project->slug) }}"
                            class="
                                group
                                project-card
                                {{ $featured
                                    ? 'lg:col-span-7'
                                    : 'lg:col-span-5'
                                }}
                            "
                        >

                            <div
                                class="
                                    overflow-hidden
                                    {{ $featured
                                        ? 'aspect-[16/11]'
                                        : 'aspect-[16/10]'
                                    }}
                                "
                            >

                                @if($project->cover_image)

                                    <img
                                        src="{{ asset('storage/' . $project->cover_image) }}"
                                        alt="{{ $project->title }}"
                                        class="h-full w-full object-cover transition-transform duration-[900ms] ease-out group-hover:scale-105"
                                        loading="{{ $index < 2 ? 'eager' : 'lazy' }}"
                                    >

                                @else

                                    <div class="flex h-full items-center justify-center bg-slate-200">

                                        <div class="text-center">

                                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                                Project
                                            </span>

                                            <p class="mt-2 text-sm text-slate-400">
                                                No image available
                                            </p>

                                        </div>

                                    </div>

                                @endif

                            </div>


                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/15 to-transparent opacity-90"></div>


                            {{-- Content --}}
                            <div class="project-card-content">

                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">

                                    <span class="tag border-white/20 bg-white/5 text-white/75">
                                        {{ $project->category->name ?? 'Architecture' }}
                                    </span>

                                    @if($project->year)

                                        <span class="font-display text-[10px] font-bold uppercase tracking-[0.12em] text-white/45">
                                            {{ $project->year }}
                                        </span>

                                    @endif

                                </div>


                                <div class="mt-5 flex items-end justify-between gap-6">

                                    <div>

                                        <h2 class="font-display text-2xl font-semibold leading-tight tracking-[-0.035em] text-white sm:text-3xl">
                                            {{ $project->title }}
                                        </h2>

                                        <p class="mt-2 text-sm text-white/55">
                                            {{ $project->location ?? 'Location available on request' }}
                                        </p>

                                    </div>


                                    <span
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/5 text-lg text-white backdrop-blur-sm transition-all duration-300 group-hover:bg-white group-hover:text-slate-950"
                                    >
                                        →
                                    </span>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- =================================================
                     PAGINATION
                     ================================================= --}}
                @if(method_exists($projects, 'links'))

                    <div class="mt-14 border-t border-slate-200 pt-8">

                        {{ $projects->withQueryString()->links() }}

                    </div>

                @endif

            @else

                {{-- Empty state --}}
                <div class="border border-dashed border-slate-300 bg-slate-50 px-8 py-24 text-center">

                    <p class="eyebrow">
                        Portfolio
                    </p>

                    <h2 class="mt-5 font-display text-3xl font-semibold tracking-[-0.04em]">
                        No projects found.
                    </h2>

                    <p class="mx-auto mt-4 max-w-lg text-sm leading-7 text-slate-500">
                        There are currently no projects matching the
                        selected criteria.
                    </p>

                    <a
                        href="{{ route('projects.index') }}"
                        class="btn-dark mt-7"
                    >
                        View all projects
                    </a>

                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         PROJECT STATEMENT
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="grid gap-10 lg:grid-cols-[0.4fr_1.6fr]">

                <div>

                    <p class="eyebrow">
                        Our standard
                    </p>

                </div>


                <div>

                    <h2 class="max-w-5xl font-display text-4xl font-semibold leading-[1] tracking-[-0.055em] sm:text-6xl">

                        Every project is an opportunity
                        to solve something better.

                    </h2>

                    <div class="mt-10 grid gap-8 md:grid-cols-2">

                        <p class="leading-8 text-slate-500">
                            We believe successful construction begins with
                            clear thinking. Every decision is tested against
                            functionality, buildability, quality and
                            long-term value.
                        </p>

                        <p class="leading-8 text-slate-500">
                            From residential spaces to complex commercial
                            developments, our teams bring a consistent
                            standard of technical discipline to every site.
                        </p>

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
                        Start your project
                    </p>

                    <h2
                        class="mt-6 max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl lg:text-8xl"
                    >
                        HAVE AN IDEA?
                        <br>
                        LET'S BUILD IT.
                    </h2>

                </div>


                <a
                    href="{{ route('contact.index') }}"
                    class="btn-white group min-w-[220px]"
                >

                    Request a Quote

                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                        →
                    </span>

                </a>

            </div>

        </div>

    </section>

</div>

@endsection