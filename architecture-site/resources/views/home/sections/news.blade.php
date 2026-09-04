{{-- =========================================================
     HOME - NEWS & INSIGHTS (FIXED CONTRAST & TYPOGRAPHY)
========================================================= --}}

@php
    $homeNews = isset($latestPosts)
        ? $latestPosts
        : (isset($posts) ? $posts : collect());

    $homeNews = $homeNews
        ->filter(function ($post) {
            return $post->published_at && $post->published_at->lte(now());
        })
        ->sortByDesc('published_at')
        ->values();

    $featuredNews = $homeNews->first();
    $gridNews = $homeNews->skip(1)->take(3);
@endphp

<section id="news" class="relative overflow-hidden bg-[#f8fafc] py-20 sm:py-28 lg:py-32 select-none border-b border-slate-200/80">

    {{-- Decorative background --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -right-40 top-20 h-96 w-96 rounded-full bg-red-100/40 blur-3xl"></div>
        <div class="absolute -left-40 bottom-0 h-96 w-96 rounded-full bg-slate-200/50 blur-3xl"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-slate-200"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        {{-- =====================================================
             HEADER & XEM TẤT CẢ
        ====================================================== --}}
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between pb-8 border-b border-slate-200/90">
            <div>
                <div class="mb-3 inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    Tin tức & Hoạt động
                </div>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-950">
                    Góc nhìn <span class="text-[#EB323A]">Tân Minh Nhân.</span>
                </h2>

                <p class="mt-3 text-sm sm:text-base text-slate-500 font-normal">
                    Những chuyển động mới nhất về dự án, công nghệ thi công và văn hóa doanh nghiệp.
                </p>
            </div>

            {{-- Link sang trang Tin tức --}}
            <div class="shrink-0">
                <a
                    href="{{ route('news.index') }}"
                    class="group inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-950 hover:text-[#EB323A] transition-colors pb-1.5 border-b-2 border-slate-950 hover:border-[#EB323A]"
                >
                    <span>Xem tất cả tin tức</span>
                    <span class="transition-transform duration-300 group-hover:translate-x-1 font-mono text-sm">→</span>
                </a>
            </div>
        </div>

        {{-- =====================================================
             BÀI VIẾT TIÊU ĐIỂM (ÉP MÀU TRẮNG SÁNG TOÀN BỘ TEXT)
        ====================================================== --}}
        @if($featuredNews)
            <div class="mt-12 overflow-hidden rounded-2xl bg-[#0b1329] border border-slate-800 shadow-[0_20px_50px_rgba(15,23,42,0.12)]">
                <div class="grid lg:grid-cols-12 items-stretch">

                    {{-- Image Thumbnail (7 Cột) --}}
                    <a
                        href="{{ route('news.show', $featuredNews) }}"
                        class="group relative min-h-[300px] sm:min-h-[380px] lg:min-h-[440px] lg:col-span-7 overflow-hidden bg-slate-900 block"
                    >
                        @php
                            $featuredImage = null;
                            if ($featuredNews->thumbnail) {
                                $featuredImage = str_starts_with($featuredNews->thumbnail, 'http')
                                    ? $featuredNews->thumbnail
                                    : asset('storage/' . ltrim($featuredNews->thumbnail, '/'));
                            }
                        @endphp

                        @if($featuredImage)
                            <img
                                src="{{ $featuredImage }}"
                                alt="{{ $featuredNews->title }}"
                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                loading="lazy"
                            />
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-800 text-slate-400 font-mono text-xs uppercase tracking-widest">
                                TMN News
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-[#0b1329]/90 via-transparent to-transparent"></div>

                        {{-- Badges --}}
                        <div class="absolute bottom-5 left-5 right-5 flex items-center justify-between z-10">
                            <span class="rounded-full bg-[#EB323A] px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-md">
                                Mới nhất
                            </span>
                            @if(optional($featuredNews->category)->name)
                                <span class="rounded-full bg-white/20 px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-wider text-white backdrop-blur-md border border-white/20">
                                    {{ $featuredNews->category->name }}
                                </span>
                            @endif
                        </div>
                    </a>

                    {{-- Content Cột Phải (5 Cột) --}}
                    <div class="lg:col-span-5 flex flex-col justify-between p-8 sm:p-10 lg:p-12 bg-[#0b1329]">
                        <div>
                            {{-- Ngày đăng & Tác giả --}}
                            <div class="flex items-center gap-2.5 text-xs font-mono font-bold uppercase tracking-wider">
                                <span class="text-[#EB323A]">{{ optional($featuredNews->published_at)->format('d/m/Y') }}</span>
                                <span class="text-white/30">•</span>
                                <span class="text-slate-300 font-sans tracking-normal text-[11px]">{{ $featuredNews->author_name ?? 'Đội ngũ chuyên môn' }}</span>
                            </div>

                            {{-- Tiêu đề lớn: Khóa màu trắng tinh --}}
                            <h3 class="mt-4 text-2xl sm:text-3xl font-extrabold leading-snug !text-white tracking-tight">
                                <a href="{{ route('news.show', $featuredNews) }}" class="!text-white hover:!text-red-400 transition-colors">
                                    {{ $featuredNews->title }}
                                </a>
                            </h3>

                            {{-- Đoạn trích dẫn ngắn --}}
                            @if($featuredNews->excerpt)
                                <p class="mt-4 text-xs sm:text-sm leading-relaxed !text-slate-300 font-normal line-clamp-3">
                                    {{ $featuredNews->excerpt }}
                                </p>
                            @endif
                        </div>

                        {{-- Nút Đọc bài viết --}}
                        <div class="mt-8 pt-6 border-t border-white/10">
                            <a
                                href="{{ route('news.show', $featuredNews) }}"
                                class="group inline-flex items-center gap-2.5 rounded-full bg-[#EB323A] hover:bg-[#d4272f] px-6 py-3 text-xs font-bold uppercase tracking-wider !text-white transition-all duration-300 shadow-lg shadow-red-950/40"
                            >
                                <span class="!text-white">Đọc bài viết</span>
                                <span class="transition-transform duration-300 group-hover:translate-x-1 font-mono text-sm !text-white">→</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        {{-- =====================================================
             DANH SÁCH 3 BÀI TIẾP THEO
        ====================================================== --}}
        @if($gridNews->count())
            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($gridNews as $post)
                    <article class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-900/5">

                        <div>
                            {{-- Thumbnail --}}
                            <a
                                href="{{ route('news.show', $post) }}"
                                class="relative block aspect-[16/10] overflow-hidden bg-slate-100"
                            >
                                @php
                                    $postImage = null;
                                    if ($post->thumbnail) {
                                        $postImage = str_starts_with($post->thumbnail, 'http')
                                            ? $post->thumbnail
                                            : asset('storage/' . ltrim($post->thumbnail, '/'));
                                    }
                                @endphp

                                @if($postImage)
                                    <img
                                        src="{{ $postImage }}"
                                        alt="{{ $post->title }}"
                                        class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                                        loading="lazy"
                                    />
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400 font-mono text-xs uppercase tracking-wider">
                                        TMN News
                                    </div>
                                @endif

                                @if(optional($post->category)->name)
                                    <div class="absolute left-4 top-4">
                                        <span class="rounded-full bg-white/95 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-800 shadow-sm border border-slate-200/60 backdrop-blur-sm">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </a>

                            {{-- Text Content --}}
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-[11px] font-mono text-slate-400">
                                    <span class="font-bold text-slate-500">{{ optional($post->published_at)->format('d/m/Y') }}</span>
                                    <span>•</span>
                                    <span class="truncate font-sans">{{ $post->author_name ?? 'Ban Biên tập' }}</span>
                                </div>

                                <h3 class="mt-3 line-clamp-2 text-base sm:text-lg font-bold leading-snug text-slate-950 transition-colors duration-200 group-hover:text-[#EB323A]">
                                    <a href="{{ route('news.show', $post) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                @if($post->excerpt)
                                    <p class="mt-2.5 line-clamp-2 text-xs leading-relaxed text-slate-500 font-normal">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Footer Link --}}
                        <div class="px-6 pb-6 pt-2">
                            <a
                                href="{{ route('news.show', $post) }}"
                                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-900 group-hover:text-[#EB323A] transition-colors"
                            >
                                <span>Chi tiết</span>
                                <span class="transition-transform duration-200 group-hover:translate-x-1 font-mono text-sm">→</span>
                            </a>
                        </div>

                    </article>
                @endforeach
            </div>
        @endif

        {{-- Trạng thái trống --}}
        @if($homeNews->count() === 0)
            <div class="mt-12 rounded-2xl border border-dashed border-slate-200 bg-white px-6 py-16 text-center">
                <p class="font-mono text-xs uppercase tracking-widest text-slate-400">Tân Minh Nhân</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900">Chưa có bài viết mới</h3>
                <p class="mt-1 text-xs text-slate-500">Các tin tức và hoạt động mới nhất sẽ sớm được cập nhật tại đây.</p>
            </div>
        @endif

    </div>

</section>