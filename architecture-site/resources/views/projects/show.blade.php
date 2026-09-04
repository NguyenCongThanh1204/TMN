@extends('layouts.app')

@section('content')

<div class="page-transition">

    {{-- =====================================================
         PROJECT HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 text-white">

        <div class="container-page">

            <div class="grid min-h-[720px] items-end gap-12 pb-16 pt-36 lg:grid-cols-[1fr_.42fr] lg:pb-20">

                <div>

                    <div class="flex flex-wrap items-center gap-3">

                        <span class="tag border-white/20 bg-white/5 text-white/70">
                            {{ $project->category->name ?? 'Architecture' }}
                        </span>

                        @if($project->year)
                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-white/40">
                                {{ $project->year }}
                            </span>
                        @endif

                    </div>


                    <h1 class="mt-7 max-w-6xl font-display text-6xl font-semibold leading-[0.88] tracking-[-0.07em] text-white sm:text-7xl lg:text-[8rem]">
                        {{ $project->title }}
                    </h1>


                    @if($project->location)
                        <div class="mt-8 flex items-center gap-3 text-sm text-white/50">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                            {{ $project->location }}
                        </div>
                    @endif

                </div>


                {{-- Project summary --}}
                <div class="lg:pb-2">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Project overview
                        </p>

                        <p class="mt-4 text-base leading-7 text-white/55">
                            A project delivered through coordinated
                            architectural design, engineering and
                            construction execution.
                        </p>


                        <div class="mt-8 flex items-center gap-3">

                            <span class="h-px w-10 bg-red-500"></span>

                            <a
                                href="#project-information"
                                class="font-display text-[10px] font-bold uppercase tracking-[0.12em] text-white/70 hover:text-white"
                            >
                                Explore project
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Architectural grid --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.08]">

            <div class="absolute inset-y-0 left-[20%] w-px bg-white"></div>
            <div class="absolute inset-y-0 left-[50%] w-px bg-white"></div>
            <div class="absolute inset-y-0 left-[80%] w-px bg-white"></div>

            <div class="absolute left-0 right-0 top-[55%] h-px bg-white"></div>

        </div>

    </section>


    {{-- =====================================================
         PROJECT INFORMATION
         ===================================================== --}}
    <section id="project-information" class="border-b border-slate-200 bg-white">

        <div class="container-page">

            <div class="grid divide-y divide-slate-200 md:grid-cols-2 md:divide-x md:divide-y-0 lg:grid-cols-5">

                {{-- Client --}}
                <div class="py-8 md:px-6 md:first:pl-0">

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Client
                    </p>

                    <p class="mt-3 font-display text-sm font-semibold">
                        {{ $project->client_name ?: 'Private Client' }}
                    </p>

                </div>


                {{-- Location --}}
                <div class="py-8 md:px-6">

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Location
                    </p>

                    <p class="mt-3 font-display text-sm font-semibold">
                        {{ $project->location ?: '—' }}
                    </p>

                </div>


                {{-- Area --}}
                <div class="py-8 md:px-6">

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Gross floor area
                    </p>

                    <p class="mt-3 font-display text-sm font-semibold">
                        @if($project->area_sqm)
                            {{ number_format($project->area_sqm) }} m²
                        @else
                            —
                        @endif
                    </p>

                </div>


                {{-- Year --}}
                <div class="py-8 md:px-6">

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Completion
                    </p>

                    <p class="mt-3 font-display text-sm font-semibold">
                        {{ $project->year ?: '—' }}
                    </p>

                </div>


                {{-- Structure --}}
                <div class="py-8 md:px-6 md:last:pr-0">

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Structure
                    </p>

                    <p class="mt-3 font-display text-sm font-semibold">
                        {{ $project->structural_type ?: 'General Construction' }}
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         COVER IMAGE
         ===================================================== --}}
    @if($project->cover_image)

        <section class="bg-white py-6 sm:py-8 lg:py-10">

            <div class="container-page">

                <figure class="group relative overflow-hidden bg-slate-200">

                    <div class="aspect-[16/9] sm:aspect-[2/1]">

                        <img
                            src="{{ asset('storage/' . $project->cover_image) }}"
                            alt="{{ $project->title }}"
                            class="h-full w-full object-cover transition-transform duration-[1200ms] ease-out group-hover:scale-[1.025]"
                        >

                    </div>


                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/30 to-transparent"></div>

                </figure>

            </div>

        </section>

    @endif


    {{-- =====================================================
         ARCHITECTURAL STORY
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.55fr_1.45fr]">

                <div>

                    <p class="eyebrow">
                        Project story
                    </p>

                    <p class="mt-6 max-w-xs text-sm leading-7 text-slate-500">
                        Architecture, technical discipline and execution
                        brought together around the specific needs of
                        the project.
                    </p>

                </div>


                <article class="prose prose-slate max-w-none">

                    @if($project->body_content)

                        {!! $project->body_content !!}

                    @else

                        <h2>
                            Designed around purpose.
                        </h2>

                        <p>
                            This project was developed with a focus on
                            functionality, material expression and
                            long-term performance. Architectural intent
                            was coordinated closely with engineering
                            requirements and construction realities.
                        </p>

                        <p>
                            From the earliest planning stages through
                            execution, the project team maintained a
                            clear focus on quality, buildability and
                            responsible delivery.
                        </p>

                    @endif

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         PROJECT STATS / TIMELINE
         ===================================================== --}}
    <section class="bg-slate-50 py-16 sm:py-20">

        <div class="container-page">

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                <div class="process-step">

                    <span class="process-step-number">
                        AREA
                    </span>

                    <h3 class="mt-8 font-display text-3xl font-semibold tracking-[-0.04em]">

                        @if($project->area_sqm)
                            {{ number_format($project->area_sqm) }}
                            <span class="text-lg text-slate-400">m²</span>
                        @else
                            —
                        @endif

                    </h3>

                    <p class="process-step-description">
                        Gross floor area
                    </p>

                </div>


                <div class="process-step">

                    <span class="process-step-number">
                        YEAR
                    </span>

                    <h3 class="mt-8 font-display text-3xl font-semibold tracking-[-0.04em]">
                        {{ $project->year ?: '—' }}
                    </h3>

                    <p class="process-step-description">
                        Completion year
                    </p>

                </div>


                <div class="process-step">

                    <span class="process-step-number">
                        TYPE
                    </span>

                    <h3 class="mt-8 font-display text-3xl font-semibold tracking-[-0.04em]">
                        {{ $project->category->name ?? 'Architecture' }}
                    </h3>

                    <p class="process-step-description">
                        Project category
                    </p>

                </div>


                <div class="process-step">

                    <span class="process-step-number">
                        STRUCTURE
                    </span>

                    <h3 class="mt-8 font-display text-2xl font-semibold tracking-[-0.04em]">
                        {{ $project->structural_type ?: 'General Construction' }}
                    </h3>

                    <p class="process-step-description">
                        Structural approach
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         GALLERY
         ===================================================== --}}
    @if(isset($project->gallery) && is_array($project->gallery) && count($project->gallery))

        <section
            class="section bg-white"
            x-data="{
                open: false,
                active: 0,
                images: @js(
                    collect($project->gallery)->map(function ($image) {
                        return asset('storage/' . $image);
                    })->values()
                )
            }"
            @keydown.escape.window="open = false"
            @keydown.arrow-right.window="if(open) active = (active + 1) % images.length"
            @keydown.arrow-left.window="if(open) active = (active - 1 + images.length) % images.length"
        >

            <div class="container-page">

                <div class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">

                    <div>

                        <p class="eyebrow">
                            Project gallery
                        </p>

                        <h2 class="section-title">
                            Built in detail.
                        </h2>

                    </div>

                    <p class="max-w-md text-sm leading-7 text-slate-500">
                        Explore selected views and visual details from
                        the project.
                    </p>

                </div>


                <div class="grid gap-5 md:grid-cols-2">

                    @foreach($project->gallery as $index => $image)

                        <button
                            type="button"
                            @click="active = {{ $index }}; open = true"
                            class="group relative overflow-hidden bg-slate-100 text-left focus:outline-none"
                        >

                            <div class="aspect-[4/3] overflow-hidden">

                                <img
                                    src="{{ asset('storage/' . $image) }}"
                                    alt="{{ $project->title }} — image {{ $index + 1 }}"
                                    class="h-full w-full object-cover transition-transform duration-[900ms] ease-out group-hover:scale-105"
                                    loading="lazy"
                                >

                            </div>


                            <div class="absolute inset-0 bg-slate-950/0 transition-colors duration-300 group-hover:bg-slate-950/20"></div>


                            <span
                                class="absolute bottom-5 right-5 flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-950 opacity-0 shadow-lg transition-all duration-300 group-hover:opacity-100"
                            >
                                +
                            </span>

                        </button>

                    @endforeach

                </div>

            </div>


            {{-- =================================================
                 LIGHTBOX
                 ================================================= --}}
            <div
                x-cloak
                x-show="open"
                x-transition.opacity
                class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-950/95 p-4 sm:p-8"
            >

                <button
                    type="button"
                    @click="open = false"
                    class="absolute right-5 top-5 z-10 flex h-12 w-12 items-center justify-center rounded-full border border-white/20 text-xl text-white transition-colors hover:bg-white hover:text-slate-950"
                    aria-label="Close gallery"
                >
                    ×
                </button>


                <button
                    type="button"
                    @click="active = (active - 1 + images.length) % images.length"
                    class="absolute left-4 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 text-xl text-white transition-colors hover:bg-white hover:text-slate-950 sm:left-8"
                    aria-label="Previous image"
                >
                    ←
                </button>


                <div class="flex h-full w-full items-center justify-center">

                    <img
                        :src="images[active]"
                        alt="{{ $project->title }}"
                        class="max-h-[90vh] max-w-[90vw] object-contain"
                    >

                </div>


                <button
                    type="button"
                    @click="active = (active + 1) % images.length"
                    class="absolute right-4 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 text-xl text-white transition-colors hover:bg-white hover:text-slate-950 sm:right-8"
                    aria-label="Next image"
                >
                    →
                </button>


                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 font-display text-xs uppercase tracking-[0.15em] text-white/50">
                    <span x-text="String(active + 1).padStart(2, '0')"></span>
                    /
                    <span x-text="String(images.length).padStart(2, '0')"></span>
                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
         MEDIA FALLBACK
         ===================================================== --}}
    @if(!isset($project->gallery) || !is_array($project->gallery) || !count($project->gallery))

        <section class="section bg-slate-50">

            <div class="container-page">

                <div class="border border-dashed border-slate-300 bg-white p-10 text-center sm:p-16">

                    <p class="eyebrow">
                        Project gallery
                    </p>

                    <h2 class="mt-5 font-display text-3xl font-semibold tracking-[-0.04em]">
                        Project media will appear here.
                    </h2>

                    <p class="mx-auto mt-4 max-w-lg text-sm leading-7 text-slate-500">
                        Add gallery images through the project management
                        interface to showcase this project's construction
                        and architectural details.
                    </p>

                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
         PROJECT DELIVERY
         ===================================================== --}}
    <section class="section bg-slate-950 text-white">

        <div class="container-page">

            <div class="grid gap-12 lg:grid-cols-[0.6fr_1.4fr]">

                <div>

                    <p class="eyebrow !text-white/50">
                        Delivery
                    </p>

                    <p class="mt-6 max-w-xs text-sm leading-7 text-white/40">
                        The same disciplined approach is applied from
                        concept development through construction and
                        final handover.
                    </p>

                </div>


                <div>

                    <h2 class="max-w-5xl font-display text-4xl font-semibold leading-[1] tracking-[-0.055em] text-white sm:text-6xl">
                        Clear coordination.
                        Measurable quality.
                        Responsible execution.
                    </h2>


                    <div class="mt-10 grid gap-4 md:grid-cols-3">

                        <div class="border border-white/10 p-6">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-red-400">
                                01
                            </span>

                            <p class="mt-10 font-display text-lg font-semibold text-white">
                                Design
                            </p>

                            <p class="mt-2 text-sm leading-6 text-white/40">
                                Context, concept and technical definition.
                            </p>

                        </div>


                        <div class="border border-white/10 p-6">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-red-400">
                                02
                            </span>

                            <p class="mt-10 font-display text-lg font-semibold text-white">
                                Engineering
                            </p>

                            <p class="mt-2 text-sm leading-6 text-white/40">
                                Coordination, documentation and compliance.
                            </p>

                        </div>


                        <div class="border border-white/10 p-6">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-red-400">
                                03
                            </span>

                            <p class="mt-10 font-display text-lg font-semibold text-white">
                                Construction
                            </p>

                            <p class="mt-2 text-sm leading-6 text-white/40">
                                Quality, safety and controlled execution.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         RELATED PROJECTS
         ===================================================== --}}
    @if(isset($relatedProjects) && $relatedProjects->count())

        <section class="section bg-white">

            <div class="container-page">

                <div class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">

                    <div>

                        <p class="eyebrow">
                            Continue exploring
                        </p>

                        <h2 class="section-title">
                            Related projects.
                        </h2>

                    </div>


                    <a
                        href="{{ route('projects.index') }}"
                        class="group inline-flex items-center gap-3 font-display text-xs font-bold uppercase tracking-[0.1em]"
                    >

                        All projects

                        <span class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 transition-all duration-300 group-hover:translate-x-1 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white">
                            →
                        </span>

                    </a>

                </div>


                <div class="grid gap-5 md:grid-cols-3">

                    @foreach($relatedProjects as $related)

                        <a
                            href="{{ route('projects.show', $related->slug) }}"
                            class="project-card group"
                        >

                            <div class="aspect-[4/3] overflow-hidden">

                                @if($related->cover_image)

                                    <img
                                        src="{{ asset('storage/' . $related->cover_image) }}"
                                        alt="{{ $related->title }}"
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="lazy"
                                    >

                                @else

                                    <div class="flex h-full items-center justify-center bg-slate-200">
                                        <span class="font-display text-xs uppercase tracking-[0.12em] text-slate-400">
                                            Project
                                        </span>
                                    </div>

                                @endif

                            </div>


                            <div class="image-overlay"></div>


                            <div class="project-card-content">

                                <div class="project-meta">

                                    <span>
                                        {{ $related->category->name ?? 'Architecture' }}
                                    </span>

                                    @if($related->year)
                                        <span>
                                            {{ $related->year }}
                                        </span>
                                    @endif

                                </div>


                                <h3 class="mt-3 font-display text-2xl font-semibold tracking-[-0.035em] text-white">
                                    {{ $related->title }}
                                </h3>


                                <div class="mt-4 flex items-center justify-between gap-4">

                                    <span class="text-xs text-white/50">
                                        {{ $related->location ?? '—' }}
                                    </span>

                                    <span class="text-lg">
                                        →
                                    </span>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
         FINAL CTA
         ===================================================== --}}
    <section class="section section-blueprint">

        <div class="container-page relative z-10">

            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">

                <div>

                    <p class="eyebrow !text-white/60">
                        Start your project
                    </p>

                    <h2 class="mt-6 max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl lg:text-8xl">
                        HAVE A SIMILAR
                        <br>
                        PROJECT?
                    </h2>

                    <p class="mt-7 max-w-xl text-sm leading-7 text-white/55">
                        Tell us about your site, requirements and timeline.
                        Our team will help define the right path forward.
                    </p>

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


{{-- =========================================================
     PROJECT JSON-LD
     ========================================================= --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Project',
    'name' => $project->title,
    'url' => url()->current(),
    'description' => strip_tags($project->body_content ?? ''),
    'locationCreated' => $project->location,
    'image' => $project->cover_image
        ? asset('storage/' . $project->cover_image)
        : null,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@endsection