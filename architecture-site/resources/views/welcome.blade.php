@extends('layouts.app')

@section('content')

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden bg-slate-950 pt-36 pb-24 text-white">

    <div class="absolute inset-0">
        <div class="absolute -right-40 -top-40 h-[500px] w-[500px]
                    rounded-full bg-red-600/20 blur-3xl"></div>

        <div class="absolute -bottom-40 -left-40 h-[500px] w-[500px]
                    rounded-full bg-blue-600/20 blur-3xl"></div>
    </div>

    <div class="container-page relative">

        <p class="eyebrow !text-red-400">
            Portfolio
        </p>

        <h1 class="mt-5 max-w-4xl text-5xl font-semibold
                   tracking-tight sm:text-7xl">
            Những công trình
            <span class="text-red-500">
                tạo nên dấu ấn.
            </span>
        </h1>

        <p class="mt-7 max-w-2xl text-lg leading-8 text-white/60">
            Khám phá những dự án kiến trúc và xây dựng được
            đội ngũ của chúng tôi triển khai từ ý tưởng đến
            hoàn thiện.
        </p>

    </div>
</section>


{{-- =========================================================
     FILTER
========================================================= --}}
<section class="border-b border-slate-200 bg-white sticky top-0 z-30">

    <div class="container-page">

        <form
            action="{{ route('projects.index') }}"
            method="GET"
            class="flex flex-col gap-4 py-5 lg:flex-row lg:items-center lg:justify-between"
        >

            {{-- Category --}}
            <div class="flex gap-2 overflow-x-auto pb-1">

                <a
                    href="{{ route('projects.index') }}"
                    class="whitespace-nowrap rounded-full px-5 py-2.5 text-sm font-medium
                    {{ !request('category')
                        ? 'bg-slate-950 text-white'
                        : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Tất cả
                </a>

                @foreach($categories as $category)

                    <a
                        href="{{ route('projects.index', [
                            'category' => $category->id
                        ]) }}"
                        class="whitespace-nowrap rounded-full px-5 py-2.5 text-sm font-medium
                        {{ request('category') == $category->id
                            ? 'bg-red-600 text-white'
                            : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        {{ $category->name }}
                    </a>

                @endforeach

            </div>


            {{-- Search + Year --}}
            <div class="flex gap-3">

                <select
                    name="year"
                    onchange="this.form.submit()"
                    class="rounded-lg border-slate-300
                           px-4 py-2.5 text-sm"
                >

                    <option value="">
                        Tất cả năm
                    </option>

                    @foreach($years as $year)

                        <option
                            value="{{ $year }}"
                            @selected(request('year') == $year)
                        >
                            {{ $year }}
                        </option>

                    @endforeach

                </select>

            </div>

        </form>

    </div>

</section>


{{-- =========================================================
     PROJECT GRID
========================================================= --}}
<section class="bg-slate-50 py-20">

    <div class="container-page">

        @if($projects->count())

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @foreach($projects as $project)

                    <article
                        class="group overflow-hidden bg-white
                               shadow-sm ring-1 ring-slate-200
                               transition duration-500
                               hover:-translate-y-2
                               hover:shadow-2xl"
                    >

                        {{-- Image --}}
                        <a
                            href="{{ route('projects.show', $project) }}"
                            class="relative block aspect-[16/10] overflow-hidden bg-slate-200"
                        >

                            @if($project->cover_image)

                                <img
                                    src="{{ asset('storage/' . $project->cover_image) }}"
                                    alt="{{ $project->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover
                                           transition duration-700
                                           group-hover:scale-110"
                                >

                            @else

                                <div class="flex h-full items-center justify-center
                                            bg-slate-200 text-slate-400">
                                    Chưa có hình ảnh
                                </div>

                            @endif


                            {{-- Overlay --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                       from-slate-950/80 via-transparent
                                       to-transparent opacity-0
                                       transition duration-500
                                       group-hover:opacity-100"
                            ></div>


                            {{-- Category --}}
                            @if($project->category)

                                <div class="absolute left-5 top-5">

                                    <span
                                        class="rounded-full bg-white/90 px-3 py-1.5
                                               text-xs font-semibold text-slate-900
                                               backdrop-blur"
                                    >
                                        {{ $project->category->name }}
                                    </span>

                                </div>

                            @endif

                        </a>


                        {{-- Content --}}
                        <div class="p-6">

                            <div class="flex items-center justify-between gap-4">

                                <p class="text-xs font-semibold uppercase
                                          tracking-widest text-red-600">
                                    {{ $project->year ?? '—' }}
                                </p>

                                @if($project->area_sqm)

                                    <p class="text-xs text-slate-400">
                                        {{ number_format($project->area_sqm, 0, ',', '.') }}
                                        m²
                                    </p>

                                @endif

                            </div>


                            <h2
                                class="mt-3 text-2xl font-semibold
                                       tracking-tight text-slate-950"
                            >
                                {{ $project->title }}
                            </h2>


                            @if($project->location)

                                <p class="mt-3 text-sm text-slate-500">
                                    {{ $project->location }}
                                </p>

                            @endif


                            <a
                                href="{{ route('projects.show', $project) }}"
                                class="mt-6 inline-flex items-center gap-2
                                       text-sm font-semibold text-slate-950
                                       transition group-hover:text-red-600"
                            >
                                Xem dự án

                                <span
                                    class="transition-transform
                                           group-hover:translate-x-1"
                                >
                                    →
                                </span>

                            </a>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- Pagination --}}
            <div class="mt-12">

                {{ $projects->links() }}

            </div>

        @else

            <div class="py-24 text-center">

                <div class="mx-auto flex h-20 w-20 items-center
                            justify-center rounded-full bg-slate-100">

                    <span class="text-2xl">
                        📐
                    </span>

                </div>

                <h2 class="mt-6 text-2xl font-semibold text-slate-950">
                    Chưa có dự án phù hợp
                </h2>

                <p class="mt-3 text-slate-500">
                    Hiện tại chưa có dự án nào thuộc bộ lọc này.
                </p>

                <a
                    href="{{ route('projects.index') }}"
                    class="mt-7 inline-flex rounded-lg
                           bg-slate-950 px-6 py-3
                           text-sm font-semibold text-white
                           transition hover:bg-red-600"
                >
                    Xem tất cả dự án
                </a>

            </div>

        @endif

    </div>

</section>

@endsection