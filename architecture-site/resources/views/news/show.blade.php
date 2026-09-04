@extends('layouts.app')

@section('content')

<div
    class="page-transition"
    x-data="{
        progress: 0,

        updateProgress() {
            const article = document.getElementById('article-content');

            if (!article) {
                this.progress = 0;
                return;
            }

            const rect = article.getBoundingClientRect();

            const articleTop = window.scrollY + rect.top;
            const articleHeight = article.offsetHeight;

            const viewportHeight = window.innerHeight;

            const current =
                window.scrollY - articleTop + viewportHeight * 0.25;

            const total =
                articleHeight - viewportHeight * 0.25;

            this.progress = Math.min(
                100,
                Math.max(
                    0,
                    (current / total) * 100
                )
            );
        }
    }"
    x-init="
        updateProgress();

        window.addEventListener('scroll', () => {
            updateProgress();
        }, { passive: true });

        window.addEventListener('resize', () => {
            updateProgress();
        });
    "
>

    {{-- =====================================================
         READING PROGRESS
         ===================================================== --}}
    <div
        class="fixed left-0 top-0 z-[9999] h-[3px] bg-red-600 transition-[width] duration-100"
        :style="'width:' + progress + '%'"
        aria-hidden="true"
    ></div>


    {{-- =====================================================
         ARTICLE HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 pt-36 text-white sm:pt-44">

        <div class="container-page">

            <div class="grid min-h-[620px] items-end gap-12 pb-16 lg:grid-cols-[1fr_.42fr] lg:pb-20">

                <div>

                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center gap-4">

                        <span class="tag border-white/20 bg-white/5 text-white/75">
                            {{ $post->category->name ?? 'Insights' }}
                        </span>

                        @if($post->published_at)

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-white/35">
                                {{ $post->published_at->format('d M Y') }}
                            </span>

                        @endif

                    </div>


                    {{-- Title --}}
                    <h1 class="mt-7 max-w-6xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.065em] text-white sm:text-6xl lg:text-8xl">

                        {{ $post->title }}

                    </h1>


                    {{-- Excerpt --}}
                    @if($post->excerpt)

                        <p class="mt-8 max-w-3xl text-base leading-8 text-white/55 sm:text-lg">

                            {{ $post->excerpt }}

                        </p>

                    @endif

                </div>


                {{-- Author summary --}}
                <div class="lg:pb-2">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Written by
                        </p>


                        <p class="mt-4 font-display text-xl font-semibold text-white">

                            {{ $post->author_name ?: 'Editorial Team' }}

                        </p>


                        @if($post->author_role)

                            <p class="mt-1 text-sm text-white/40">

                                {{ $post->author_role }}

                            </p>

                        @endif


                        <div class="mt-7 flex items-center gap-3">

                            <span class="h-px w-10 bg-red-500"></span>

                            <a
                                href="#article-content"
                                class="font-display text-[10px] font-bold uppercase tracking-[0.12em] text-white/60 transition-colors hover:text-white"
                            >
                                Read article ↓
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Blueprint grid --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.08]"
            aria-hidden="true"
        >

            <div class="absolute inset-y-0 left-[20%] w-px bg-white"></div>

            <div class="absolute inset-y-0 left-[50%] w-px bg-white"></div>

            <div class="absolute inset-y-0 left-[80%] w-px bg-white"></div>

            <div class="absolute left-0 right-0 top-[50%] h-px bg-white"></div>

        </div>

    </section>


    {{-- =====================================================
         HERO IMAGE
         ===================================================== --}}
    @if($post->thumbnail)

        <section class="bg-white py-6 sm:py-8 lg:py-10">

            <div class="container-page">

                <figure class="overflow-hidden bg-slate-100">

                    <div class="aspect-[16/9] sm:aspect-[2/1]">

                        <img
                            src="{{ asset('storage/' . $post->thumbnail) }}"
                            alt="{{ $post->title }}"
                            class="h-full w-full object-cover"
                        >

                    </div>

                </figure>

            </div>

        </section>

    @endif


    {{-- =====================================================
         ARTICLE AREA
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-12 lg:grid-cols-[250px_1fr] lg:gap-16">


                {{-- =================================================
                     SIDEBAR
                     ================================================= --}}
                <aside class="lg:sticky lg:top-28 lg:h-fit">

                    <div class="hidden lg:block">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                            On this page
                        </p>


                        <nav class="mt-6 border-l border-slate-200">

                            <a
                                href="#article-start"
                                class="block border-l-2 border-transparent px-4 py-2 text-sm text-slate-500 transition-colors hover:border-red-600 hover:text-slate-950"
                            >
                                Introduction
                            </a>


                            @if($post->content)

                                <a
                                    href="#article-content"
                                    class="block border-l-2 border-transparent px-4 py-2 text-sm text-slate-500 transition-colors hover:border-red-600 hover:text-slate-950"
                                >
                                    Article
                                </a>

                            @endif


                            <a
                                href="#author"
                                class="block border-l-2 border-transparent px-4 py-2 text-sm text-slate-500 transition-colors hover:border-red-600 hover:text-slate-950"
                            >
                                Author
                            </a>


                            @if(isset($relatedPosts) && $relatedPosts->count())

                                <a
                                    href="#related"
                                    class="block border-l-2 border-transparent px-4 py-2 text-sm text-slate-500 transition-colors hover:border-red-600 hover:text-slate-950"
                                >
                                    Related
                                </a>

                            @endif

                        </nav>


                        {{-- Share --}}
                        <div class="mt-12 border-t border-slate-200 pt-8">

                            <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                Share
                            </p>

                            <div class="mt-4 flex gap-2">

                                <button
                                    type="button"
                                    onclick="navigator.clipboard.writeText(window.location.href)"
                                    class="flex h-10 w-10 items-center justify-center border border-slate-200 font-display text-[10px] font-bold text-slate-600 transition-colors hover:border-slate-950 hover:bg-slate-950 hover:text-white"
                                    aria-label="Copy article link"
                                >
                                    CP
                                </button>


                                <a
                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex h-10 w-10 items-center justify-center border border-slate-200 font-display text-[10px] font-bold text-slate-600 transition-colors hover:border-slate-950 hover:bg-slate-950 hover:text-white"
                                    aria-label="Share on LinkedIn"
                                >
                                    IN
                                </a>


                                <a
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex h-10 w-10 items-center justify-center border border-slate-200 font-display text-[10px] font-bold text-slate-600 transition-colors hover:border-slate-950 hover:bg-slate-950 hover:text-white"
                                    aria-label="Share on Facebook"
                                >
                                    FB
                                </a>

                            </div>

                        </div>

                    </div>

                </aside>


                {{-- =================================================
                     ARTICLE CONTENT
                     ================================================= --}}
                <article id="article-content" class="min-w-0">

                    {{-- Intro --}}
                    @if($post->excerpt)

                        <div
                            id="article-start"
                            class="mb-12 border-l-4 border-red-600 pl-6"
                        >

                            <p class="font-display text-xl font-medium leading-8 tracking-[-0.02em] text-slate-800 sm:text-2xl">

                                {{ $post->excerpt }}

                            </p>

                        </div>

                    @endif


                    {{-- Content --}}
                    @if($post->content)

                        <div class="prose prose-slate max-w-none prose-headings:font-display prose-headings:tracking-[-0.04em] prose-a:text-blue-700 prose-a:no-underline hover:prose-a:underline prose-img:w-full">

                            {!! $post->content !!}

                        </div>

                    @else

                        <div class="border border-dashed border-slate-300 bg-slate-50 p-10">

                            <p class="font-display text-lg font-semibold">
                                Article content is not available yet.
                            </p>

                            <p class="mt-3 text-sm leading-7 text-slate-500">
                                The editorial team is preparing this article.
                            </p>

                        </div>

                    @endif


                    {{-- Article footer --}}
                    <div class="mt-14 border-t border-slate-200 pt-8">

                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <p class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                    Published
                                </p>

                                <p class="mt-1 text-sm text-slate-600">

                                    @if($post->published_at)

                                        {{ $post->published_at->format('d F Y') }}

                                    @else

                                        Recently

                                    @endif

                                </p>

                            </div>


                            <a
                                href="{{ route('news.index') }}"
                                class="group inline-flex items-center gap-3 font-display text-xs font-bold uppercase tracking-[0.1em]"
                            >

                                Back to News

                                <span class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 transition-all duration-300 group-hover:translate-x-1 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white">
                                    ←
                                </span>

                            </a>

                        </div>

                    </div>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         AUTHOR
         ===================================================== --}}
    <section id="author" class="section bg-slate-50">

        <div class="container-page">

            <div class="grid gap-10 lg:grid-cols-[250px_1fr]">

                <div>

                    <p class="eyebrow">
                        Author
                    </p>

                </div>


                <div class="flex flex-col gap-7 border-t border-slate-200 pt-8 sm:flex-row sm:items-start">

                    <div class="flex h-20 w-20 shrink-0 items-center justify-center bg-slate-950 font-display text-2xl font-semibold text-white">

                        {{ strtoupper(substr($post->author_name ?: 'E', 0, 1)) }}

                    </div>


                    <div>

                        <h2 class="font-display text-2xl font-semibold tracking-[-0.035em]">

                            {{ $post->author_name ?: 'Editorial Team' }}

                        </h2>


                        @if($post->author_role)

                            <p class="mt-1 text-sm text-red-600">
                                {{ $post->author_role }}
                            </p>

                        @endif


                        <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-500">
                            Contributor to our editorial platform,
                            sharing perspectives on architecture,
                            engineering, construction and the built
                            environment.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         RELATED ARTICLES
         ===================================================== --}}
    @if(isset($relatedPosts) && $relatedPosts->count())

        <section id="related" class="section bg-white">

            <div class="container-page">

                <div class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">

                    <div>

                        <p class="eyebrow">
                            Continue reading
                        </p>

                        <h2 class="section-title">
                            Related stories.
                        </h2>

                    </div>


                    <a
                        href="{{ route('news.index') }}"
                        class="group inline-flex items-center gap-3 font-display text-xs font-bold uppercase tracking-[0.1em]"
                    >

                        View all stories

                        <span class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 transition-all duration-300 group-hover:translate-x-1 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white">
                            →
                        </span>

                    </a>

                </div>


                <div class="grid gap-6 md:grid-cols-3">

                    @foreach($relatedPosts as $related)

                        <article class="group">

                            <a
                                href="{{ route('news.show', $related->slug) }}"
                                class="block"
                            >

                                <div class="news-card-image overflow-hidden bg-slate-100">

                                    @if($related->thumbnail)

                                        <img
                                            src="{{ asset('storage/' . $related->thumbnail) }}"
                                            alt="{{ $related->title }}"
                                            class="h-full w-full object-cover transition-transform duration-[800ms] ease-out group-hover:scale-105"
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center">

                                            <span class="font-display text-xs uppercase tracking-[0.12em] text-slate-400">
                                                Editorial
                                            </span>

                                        </div>

                                    @endif

                                </div>


                                <div class="pt-5">

                                    <div class="flex flex-wrap items-center gap-3">

                                        <span class="news-card-category">
                                            {{ $related->category->name ?? 'Insights' }}
                                        </span>

                                        @if($related->published_at)

                                            <span class="text-xs text-slate-400">
                                                {{ $related->published_at->format('d M Y') }}
                                            </span>

                                        @endif

                                    </div>


                                    <h3 class="mt-3 font-display text-2xl font-semibold leading-[1.05] tracking-[-0.035em] transition-colors duration-300 group-hover:text-red-600">
                                        {{ $related->title }}
                                    </h3>


                                    @if($related->excerpt)

                                        <p class="mt-3 text-sm leading-7 text-slate-500">
                                            {{ $related->excerpt }}
                                        </p>

                                    @endif

                                    <div class="mt-5 flex items-center gap-2 font-display text-[10px] font-bold uppercase tracking-[0.1em]">

                                        Read article

                                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                                            →
                                        </span>

                                    </div>

                                </div>

                            </a>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- =====================================================
         CTA
         ===================================================== --}}
    <section class="section section-blueprint">

        <div class="container-page relative z-10">

            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">

                <div>

                    <p class="eyebrow !text-white/60">
                        Architecture & Construction
                    </p>

                    <h2 class="mt-6 max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl lg:text-8xl">

                        HAVE A PROJECT
                        <br>
                        TO DISCUSS?

                    </h2>

                    <p class="mt-7 max-w-xl text-sm leading-7 text-white/55">
                        Let's turn your next idea into a clear,
                        buildable and enduring project.
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
     ARTICLE JSON-LD
     ========================================================= --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->title,
    'description' => $post->excerpt,
    'image' => $post->thumbnail
        ? [asset('storage/' . $post->thumbnail)]
        : [],
    'datePublished' => optional($post->published_at)->toIso8601String(),
    'author' => [
        '@type' => 'Person',
        'name' => $post->author_name ?: 'Editorial Team',
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => url()->current(),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@endsection