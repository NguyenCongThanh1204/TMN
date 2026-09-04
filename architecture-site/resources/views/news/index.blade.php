@extends('layouts.app')

@section('content')

<div class="page-transition">

    {{-- =====================================================
         NEWS HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 pt-36 text-white sm:pt-44">

        <div class="container-page relative z-10">

            <div class="grid min-h-[560px] items-end gap-12 pb-20 lg:grid-cols-[1fr_.55fr] lg:pb-24">

                <div>

                    <p class="eyebrow !text-red-400">
                        Tin tức & Những chiến lược
                    </p>

                    <h1
                        class="mt-7 max-w-6xl font-display text-6xl font-semibold leading-[0.88] tracking-[-0.07em] text-white sm:text-7xl lg:text-[8rem]"
                    >
                        Ý TƯỞNG
                        <br>
                        ĐỨC
                        <br>
                        ĐẾU
                        <br>
                        XÂY DỰNG.
                    </h1>

                </div>


                <div class="lg:pb-3">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Biên tập
                        </p>

                        <p class="mt-4 max-w-sm text-base leading-7 text-white/55">
                            Quan điểm về kiến trúc, công nghệ xây dựng,
                            thiết kế, kỹ thuật và những người
                            hình thành môi trường xây dựng.
                        </p>

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
         FEATURED ARTICLE
         ===================================================== --}}
    @if(isset($featuredPost) && $featuredPost)

        <section class="section bg-white">

            <div class="container-page">

                <div class="mb-12">

                    <p class="eyebrow">
                        Câu chuyện nổi bật
                    </p>

                    <h2 class="section-title max-w-5xl">
                        Những ý tưởng đáng đọc.
                    </h2>

                </div>


                <a
                    href="{{ route('news.show', $featuredPost->slug) }}"
                    class="group grid overflow-hidden bg-slate-950 lg:grid-cols-[1.35fr_.65fr]"
                >

                    {{-- Image --}}
                    <div class="relative aspect-[16/10] overflow-hidden lg:aspect-auto lg:min-h-[560px]">

                        @if($featuredPost->thumbnail)

                            <img
                                src="{{ asset('storage/' . $featuredPost->thumbnail) }}"
                                alt="{{ $featuredPost->title }}"
                                class="h-full w-full object-cover transition-transform duration-[1000ms] ease-out group-hover:scale-105"
                                loading="eager"
                            >

                        @else

                            <div class="flex h-full min-h-[400px] items-center justify-center bg-slate-800">

                                <span class="font-display text-xs uppercase tracking-[0.15em] text-white/30">
                                    Bài viết nổi bật
                                </span>

                            </div>

                        @endif


                        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/10 via-transparent to-slate-950/30"></div>


                        <div class="absolute left-6 top-6 sm:left-8 sm:top-8">

                            <span class="tag border-white/20 bg-black/20 text-white backdrop-blur-md">
                                Nổi bật
                            </span>

                        </div>

                    </div>


                    {{-- Content --}}
                    <div class="flex flex-col justify-between p-8 sm:p-10 lg:p-12 xl:p-14">

                        <div>

                            <div class="flex flex-wrap items-center gap-3">

                                <span class="font-display text-[10px] font-bold uppercase tracking-[0.14em] text-red-400">
                                    {{ $featuredPost->category->name ?? 'Insights' }}
                                </span>

                                @if($featuredPost->published_at)

                                    <span class="text-xs text-white/30">
                                        {{ $featuredPost->published_at->format('d M Y') }}
                                    </span>

                                @endif

                            </div>


                            <h3 class="mt-7 font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] text-white sm:text-5xl lg:text-6xl">

                                {{ $featuredPost->title }}

                            </h3>


                            @if($featuredPost->excerpt)

                                <p class="mt-7 text-base leading-8 text-white/50">
                                    {{ $featuredPost->excerpt }}
                                </p>

                            @endif

                        </div>


                        <div class="mt-10 flex items-center justify-between gap-6">

                            <span class="font-display text-[10px] font-bold uppercase tracking-[0.12em] text-white/40">
                                Đọc bài viết nổi bật
                            </span>

                            <span
                                class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 text-lg text-white transition-all duration-300 group-hover:border-white group-hover:bg-white group-hover:text-slate-950"
                            >
                                →
                            </span>

                        </div>

                    </div>

                </a>

            </div>

        </section>

    @endif


    {{-- =====================================================
         CATEGORY FILTER
         ===================================================== --}}
    <section class="border-y border-slate-200 bg-slate-50">

        <div class="container-page">

            <div class="flex flex-col gap-5 py-7 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                        Khám phá chủ đề
                    </p>

                </div>


                <div class="flex gap-2 overflow-x-auto pb-1">

                    <a
                        href="{{ route('news.index') }}"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200
                            {{ !request('category')
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                            }}"
                    >
                        Tất cả câu chuyện
                    </a>


                    <a
                        href="{{ route('news.index', ['category' => $category->slug]) }}"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200
                            {{ request('category') === 'Construction Technology'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                            }}"
                    >
                        Construction Technology
                    </a>


                    <a
                        href="{{ route('news.index', ['category' => 'Design Trends']) }}"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200
                            {{ request('category') === 'Design Trends'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                            }}"
                    >
                        Xu hướng Thiết kế
                    </a>


                    <a
                        href="{{ route('news.index', ['category' => 'Feng Shui & Space']) }}"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200
                            {{ request('category') === 'Feng Shui & Space'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                            }}"
                    >
                        Phong Thủy & Không gian
                    </a>


                    <a
                        href="{{ route('news.index', ['category' => 'Corporate Updates']) }}"
                        class="whitespace-nowrap border px-4 py-2.5 font-display text-[10px] font-bold uppercase tracking-[0.10em] transition-all duration-200
                            {{ request('category') === 'Corporate Updates'
                                ? 'border-slate-950 bg-slate-950 text-white'
                                : 'border-slate-200 bg-white text-slate-500 hover:border-slate-950 hover:text-slate-950'
                            }}"
                    >
                        Cập nhật Công ty
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         ARTICLES
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="mb-12 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <p class="eyebrow">
                        Câu chuyện mới nhất
                    </p>

                    <h2 class="section-title">
                        Từ tờ báo.
                    </h2>

                </div>


                @if(isset($posts))

                    <p class="font-display text-sm font-semibold text-slate-400">
                        {{ method_exists($posts, 'total') ? $posts->total() : $posts->count() }}
                        bài viết
                    </p>

                @endif

            </div>


            @if(isset($posts) && $posts->count())

                <div class="grid gap-x-6 gap-y-12 md:grid-cols-2 lg:grid-cols-3">

                    @foreach($posts as $post)

                        <article class="group">

                            <a
                                href="{{ route('news.show', $post->slug) }}"
                                class="block"
                            >

                                {{-- Image --}}
                                <div class="news-card-image relative overflow-hidden bg-slate-100">

                                    @if($post->thumbnail)

                                        <img
                                            src="{{ asset('storage/' . $post->thumbnail) }}"
                                            alt="{{ $post->title }}"
                                            class="h-full w-full object-cover transition-transform duration-[800ms] ease-out group-hover:scale-105"
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center">

                                            <span class="font-display text-xs uppercase tracking-[0.12em] text-slate-400">
                                                Biên tập
                                            </span>

                                        </div>

                                    @endif


                                    <div
                                        class="absolute inset-0 bg-slate-950/0 transition-colors duration-300 group-hover:bg-slate-950/10"
                                    ></div>

                                </div>


                                {{-- Content --}}
                                <div class="pt-5">

                                    <div class="flex flex-wrap items-center gap-3">

                                        <span class="news-card-category">
                                            {{ $post->category->name ?? 'Insights' }}
                                        </span>

                                        @if($post->published_at)

                                            <span class="text-xs text-slate-400">
                                                {{ $post->published_at->format('d M Y') }}
                                            </span>

                                        @endif

                                    </div>


                                    <h3 class="mt-3 max-w-xl font-display text-2xl font-semibold leading-[1.05] tracking-[-0.035em] transition-colors duration-300 group-hover:text-red-600 sm:text-3xl">
                                        {{ $post->title }}
                                    </h3>


                                    @if($post->excerpt)

                                        <p class="mt-3 max-w-xl text-sm leading-7 text-slate-500">
                                            {{ $post->excerpt }}
                                        </p>

                                    @endif


                                    <div class="mt-5 flex items-center gap-2 font-display text-[10px] font-bold uppercase tracking-[0.1em]">

                                        Đọc bài viết

                                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                                            →
                                        </span>

                                    </div>

                                </div>

                            </a>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if(method_exists($posts, 'links'))

                    <div class="mt-16 border-t border-slate-200 pt-8">

                        {{ $posts->withQueryString()->links() }}

                    </div>

                @endif

            @else

                {{-- Empty state --}}
                <div class="border border-dashed border-slate-300 bg-slate-50 px-8 py-24 text-center">

                    <p class="eyebrow justify-center">
                        Biên tập
                    </p>

                    <h2 class="mt-5 font-display text-3xl font-semibold tracking-[-0.04em]">
                        Không tìm thấy câu chuyện nào.
                    </h2>

                    <p class="mx-auto mt-4 max-w-lg text-sm leading-7 text-slate-500">
                        Hiện tại không có bài viết đã xuất bản nào khớp
                        với danh mục được chọn.
                    </p>

                    @if(request('category'))

                        <a
                            href="{{ route('news.index') }}"
                            class="btn-dark mt-7"
                        >
                            Xem tất cả câu chuyện
                        </a>

                    @endif

                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         EDITORIAL STATEMENT
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="grid gap-12 lg:grid-cols-[0.4fr_1.6fr]">

                <div>

                    <p class="eyebrow">
                        Quan điểm của chúng tôi
                    </p>

                </div>


                <div>

                    <h2 class="max-w-5xl font-display text-4xl font-semibold leading-[1] tracking-[-0.055em] sm:text-6xl">

                        Môi trường xây dựng luôn
                        thay đổi. Chúng tôi tin rằng
                        những ý tưởng tốt nhất nên được chia sẻ.

                    </h2>


                    <div class="mt-10 grid gap-8 md:grid-cols-2">

                        <p class="leading-8 text-slate-500">
                            Từ công nghệ xây dựng nổi lên đến
                            những cách tiếp cận mới về thiết kế, nền tảng
                            biên tập của chúng tôi khám phá những ý tưởng
                            ảnh hưởng đến cách các dự án
                            được hình thành và thực hiện.
                        </p>

                        <p class="leading-8 text-slate-500">
                            Chúng tôi chia sẻ những quan điểm thực tiễn
                            từ thực địa cùng những cuộc trò chuyện rộng
                            hơn về kiến trúc, kỹ thuật và tương lai
                            của môi trường xây dựng.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         NEWSLETTER
         ===================================================== --}}
    <section class="section bg-slate-950 text-white">

        <div class="container-page">

            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">

                <div>

                    <p class="eyebrow !text-white/50">
                        Cập nhật thông tin
                    </p>

                    <h2 class="mt-6 max-w-4xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl">

                        LẤY
                        <br>
                        CÁC Ý TƯỞNG MỚI NHẤT.

                    </h2>

                    <p class="mt-7 max-w-xl text-sm leading-7 text-white/45">
                        Các bản cập nhật thỉnh thoảng về kiến trúc,
                        công nghệ xây dựng, thông tin chi tiết dự án
                        và tin tức công ty.
                    </p>

                </div>


                <form
                    action="#"
                    method="POST"
                    class="w-full max-w-xl"
                >

                    @csrf

                    <label
                        for="newsletter-email"
                        class="sr-only"
                    >
                        Địa chỉ email
                    </label>


                    <div class="flex flex-col gap-3 sm:flex-row">

                        <input
                            id="newsletter-email"
                            name="email"
                            type="email"
                            required
                            placeholder="Địa chỉ email của bạn"
                            class="min-h-[54px] min-w-0 flex-1 border border-white/10 bg-white/5 px-4 text-sm text-white outline-none transition-colors placeholder:text-white/25 focus:border-white/30 focus:bg-white/10"
                        >


                        <button
                            type="submit"
                            class="min-h-[54px] shrink-0 bg-red-600 px-7 font-display text-[10px] font-bold uppercase tracking-[0.12em] text-white transition-colors hover:bg-red-700"
                        >
                            Đăng ký
                        </button>

                    </div>


                    <p class="mt-3 text-xs leading-5 text-white/25">
                        Bằng cách đăng ký, bạn đồng ý nhận các bản
                        cập nhật công ty và biên tập thỉnh thoảng.
                    </p>

                </form>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FINAL CTA
         ===================================================== --}}
    <section class="section-sm bg-white">

        <div class="container-page">

            <div class="flex flex-col gap-7 border-t border-slate-200 pt-10 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <p class="font-display text-3xl font-semibold tracking-[-0.04em]">
                        Có dự án để thảo luận?
                    </p>

                    <p class="mt-2 text-slate-500">
                        Hãy để chúng tôi biến ý tưởng tiếp theo thành hiện thực.
                    </p>

                </div>


                <a
                    href="{{ route('contact.index') }}"
                    class="btn-primary"
                >
                    Bắt đầu cuộc trò chuyện →
                </a>

            </div>

        </div>

    </section>

</div>

@endsection