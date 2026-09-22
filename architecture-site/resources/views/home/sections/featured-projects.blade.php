{{-- =========================================================
    HOME — FEATURED PROJECTS
========================================================= --}}

<section
    id="featured-projects"
    class="relative overflow-hidden bg-white pt-[32px] pb-[16px] md:pt-[50px] md:pb-[20px]"
>

    {{-- Background decoration --}}
    <div
        class="pointer-events-none absolute -right-40 top-20
               h-[500px] w-[500px] rounded-full
               bg-red-50 blur-3xl"
    ></div>

    <div
        class="pointer-events-none absolute -left-40 bottom-0
               h-[400px] w-[400px] rounded-full
               bg-blue-50 blur-3xl"
    ></div>


    <div class="container-page relative">


        {{-- =================================================
            SECTION HEADER
        ================================================== --}}
        <div
            class="mb-12 flex flex-col gap-7
                   lg:flex-row lg:items-end lg:justify-between"
        >

            <div class="max-w-3xl">

                <div class="flex items-center gap-3">

                    <span
                        class="h-px w-10 bg-red-600"
                    ></span>

                    <p
                        class="text-xs font-bold uppercase
                               tracking-[0.25em] text-red-600"
                    >
                        Công trình tiêu biểu
                    </p>

                </div>


                <h2
                    class="mt-5 text-4xl font-semibold
                           tracking-tight text-slate-950
                           sm:text-5xl lg:text-6xl"
                >
                    Những công trình
                    <br class="hidden sm:block">

                    <span class="text-slate-400">
                        tạo nên dấu ấn.
                    </span>
                </h2>


                <p
                    class="mt-6 max-w-2xl text-base
                           leading-7 text-slate-500 sm:text-lg"
                >
                    Khám phá những dự án kiến trúc và xây dựng
                    tiêu biểu được đội ngũ của chúng tôi triển khai
                    từ ý tưởng, thiết kế đến hoàn thiện.
                </p>

            </div>


            {{-- View all --}}
            <div class="shrink-0">

                <a
                    href="{{ route('projects.index') }}"
                    class="group inline-flex items-center gap-3
                           border-b-2 border-slate-950
                           pb-2 text-sm font-semibold
                           text-slate-950
                           transition hover:border-red-600
                           hover:text-red-600"
                >

                    Xem toàn bộ dự án

                    <span
                        class="text-lg transition-transform
                               duration-300
                               group-hover:translate-x-2"
                    >
                        →
                    </span>

                </a>

            </div>

        </div>


        {{-- =================================================
            PROJECTS
        ================================================== --}}

        @if(isset($featuredProjects) && $featuredProjects->count())

            <div
                class="grid gap-6
                       md:grid-cols-2
                       lg:grid-cols-3"
            >

                @foreach($featuredProjects as $project)

                    <article
                        class="group relative overflow-hidden
                               bg-slate-100"
                    >

                        {{-- =================================
                            IMAGE
                        ================================== --}}
                        <a
                            href="{{ route('projects.show', $project) }}"
                            class="relative block aspect-[4/3]
                                   overflow-hidden"
                        >

                            @if($project->cover_image)

                                <img
                                    src="{{ cloudinary_image_url($project->cover_image, 800) }}"
                                    alt="{{ $project->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover
                                           transition-transform
                                           duration-700
                                           ease-out
                                           group-hover:scale-110"
                                >

                            @else

                                <div
                                    class="flex h-full w-full
                                           items-center justify-center
                                           bg-slate-200"
                                >

                                    <div class="text-center">

                                        <div
                                            class="mx-auto flex h-14 w-14
                                                   items-center justify-center
                                                   border border-slate-300"
                                        >
                                            <span
                                                class="text-2xl text-slate-400"
                                            >
                                                ▦
                                            </span>
                                        </div>

                                        <p
                                            class="mt-3 text-xs
                                                   font-medium
                                                   text-slate-400"
                                        >
                                            Chưa có hình ảnh
                                        </p>

                                    </div>

                                </div>

                            @endif


                            {{-- Dark overlay --}}
                            <div
                                class="absolute inset-0
                                       bg-gradient-to-t
                                       from-slate-950/90
                                       via-slate-950/20
                                       to-transparent
                                       opacity-70
                                       transition duration-500
                                       group-hover:opacity-100"
                            ></div>


                            {{-- Category --}}
                            @if($project->category)

                                <div
                                    class="absolute left-5 top-5"
                                >

                                    <span
                                        class="inline-flex
                                               bg-white px-3 py-1.5
                                               text-xs font-semibold
                                               text-slate-900 shadow-sm"
                                    >
                                        {{ $project->category->name }}
                                    </span>

                                </div>

                            @endif


                            {{-- Project number --}}
                            <div
                                class="absolute right-5 top-5"
                            >

                                <span
                                    class="text-xs font-bold
                                           tracking-[0.2em]
                                           text-white/70"
                                >
                                    {{ sprintf('%02d', $loop->iteration) }}
                                </span>

                            </div>


                            {{-- Bottom image information --}}
                            <div
                                class="absolute inset-x-0 bottom-0
                                       p-6 text-white"
                            >

                                @if($project->location)

                                    <div
                                        class="mb-2 flex items-center
                                               gap-2 text-xs
                                               text-white/60"
                                    >

                                        <span>
                                            ●
                                        </span>

                                        <span>
                                            {{ $project->location }}
                                        </span>

                                    </div>

                                @endif


                                <h3
                                    class="text-2xl font-semibold
                                           tracking-tight
                                           sm:text-3xl"
                                >
                                    {{ $project->title }}
                                </h3>


                                <div
                                    class="mt-4 flex translate-y-3
                                           items-center gap-4
                                           text-xs text-white/70
                                           opacity-0
                                           transition-all duration-500
                                           group-hover:translate-y-0
                                           group-hover:opacity-100"
                                >

                                    @if($project->year)

                                        <span>
                                            {{ $project->year }}
                                        </span>

                                    @endif


                                    @if($project->area_sqm)

                                        <span class="h-3 w-px bg-white/30"></span>

                                        <span>
                                            {{ number_format($project->area_sqm, 0, ',', '.') }}
                                            m²
                                        </span>

                                    @endif


                                    @if($project->structural_type)

                                        <span class="h-3 w-px bg-white/30"></span>

                                        <span>
                                            {{ $project->structural_type }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- Arrow --}}
                            <div
                                class="absolute bottom-6 right-6
                                       flex h-11 w-11
                                       translate-y-4 items-center
                                       justify-center
                                       bg-red-600 text-white
                                       opacity-0
                                       transition-all duration-500
                                       group-hover:translate-y-0
                                       group-hover:opacity-100"
                            >

                                <span
                                    class="text-lg transition-transform
                                           duration-300
                                           group-hover:translate-x-1"
                                >
                                    →
                                </span>

                            </div>

                        </a>

                    </article>

                @endforeach

            </div>


        @else

            {{-- =================================================
                EMPTY STATE
            ================================================== --}}

            <div
                class="border border-dashed border-slate-300
                       bg-slate-50 px-6 py-20 text-center"
            >

                <div
                    class="mx-auto flex h-16 w-16
                           items-center justify-center
                           border border-slate-300
                           bg-white"
                >

                    <span class="text-2xl text-slate-400">
                        ▦
                    </span>

                </div>


                <h3
                    class="mt-6 text-xl font-semibold
                           text-slate-950"
                >
                    Chưa có dự án nổi bật
                </h3>


                <p
                    class="mx-auto mt-3 max-w-md
                           text-sm leading-6 text-slate-500"
                >
                    Các dự án được đánh dấu
                    <strong class="text-slate-700">
                        Featured
                    </strong>
                    và có trạng thái
                    <strong class="text-slate-700">
                        Published
                    </strong>
                    sẽ tự động xuất hiện tại đây.
                </p>


                <a
                    href="{{ route('projects.index') }}"
                    class="mt-7 inline-flex
                           bg-slate-950 px-6 py-3
                           text-sm font-semibold text-white
                           transition hover:bg-red-600"
                >
                    Xem danh sách dự án
                </a>

            </div>

        @endif


        {{-- =================================================
            BOTTOM CTA
        ================================================== --}}

        @if(isset($featuredProjects) && $featuredProjects->count())

            <div
                class="mt-10 flex flex-col gap-5
                       border-t border-slate-200
                       pt-7 sm:flex-row
                       sm:items-center
                       sm:justify-between"
            >

                <p
                    class="text-sm text-slate-500"
                >
                    Khám phá toàn bộ danh mục công trình của chúng tôi.
                </p>


                <a
                    href="{{ route('projects.index') }}"
                    class="inline-flex items-center gap-2
                           text-sm font-semibold
                           text-slate-950
                           transition hover:text-red-600"
                >

                    Portfolio đầy đủ

                    <span>
                        →
                    </span>

                </a>

            </div>

        @endif

    </div>

</section>