@extends('layouts.app')

@section('content')

@php
    $thumbnailUrl = fn ($path) => cloudinary_image_url($path, 400);
@endphp

@push('preloads')
    @if(isset($featuredPost) && $featuredPost->thumbnail)
        <link rel="preload" as="image" href="{{ $thumbnailUrl($featuredPost->thumbnail) }}" fetchpriority="high">
    @endif
@endpush

<section class="min-h-screen bg-[#F8FAFC] text-slate-900 pt-[32px] pb-[40px] md:pt-[50px] md:pb-[60px] font-sans select-none">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12">

        {{-- =========================================================
             1. THANH TÌM KIẾM & BỘ LỌC CHUYÊN MỤC
             ========================================================= --}}
        <div class="flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center mb-8 bg-white p-4 border border-slate-200/90 shadow-xs rounded-sm mt-[50px]">
            
            {{-- Form Tìm Kiếm --}}
            <form action="{{ route('news.index') }}" method="GET" class="relative w-full md:w-80">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    placeholder="Tìm kiếm bài viết..."
                    value="{{ $searchTerm ?? request('search') }}"
                    class="w-full bg-slate-50 border border-slate-200 rounded-sm pl-10 pr-4 py-2.5 text-xs sm:text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#EB323A] transition-colors"
                />
            </form>

            {{-- Danh Sách Nút Chuyên Mục --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                <a
                    href="{{ route('news.index', array_filter(['search' => request('search')])) }}"
                    class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-sm transition-all whitespace-nowrap cursor-pointer {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'bg-[#EB323A] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200/80' }}"
                >
                    Tất cả
                </a>

                @if(isset($categories) && $categories->count())
                    @foreach($categories as $cat)
                        <a
                            href="{{ route('news.index', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                            class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-sm transition-all whitespace-nowrap cursor-pointer {{ ($selectedCategory ?? '') === $cat->slug ? 'bg-[#EB323A] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200/80' }}"
                        >
                            {{ $cat->name }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- =========================================================
             2. KHU VỰC TOP: FEATURED POST & XEM NHIỀU NHẤT
             ========================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 mb-14 items-stretch">

            {{-- CỘT TRÁI: FEATURED POST (8/12) - Tải Eager vì nằm ở Above the fold --}}
            @if(isset($featuredPost) && $featuredPost)
                <div class="lg:col-span-8 bg-white border border-slate-200/90 p-6 sm:p-8 shadow-xs flex flex-col justify-between rounded-sm">
                    <div>
                        <a href="{{ route('news.show', $featuredPost->slug) }}" class="group block mb-5">
                            <div class="relative w-full aspect-[16/9] overflow-hidden bg-slate-100 rounded-sm">
                                @if($featuredPost->thumbnail)
                                    <img
                                        src="{{ cloudinary_image_url($featuredPost->thumbnail, 800) }}"
                                        alt="{{ $featuredPost->title }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="eager"
                                        fetchpriority="high"
                                    />
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-mono text-xs uppercase">
                                        NO IMAGE
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="rounded-xs bg-[#EB323A] px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white shadow-md">
                                        {{ $featuredPost->category->name ?? 'Tin tức' }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mb-3 font-mono">
                            <span class="inline-flex items-center gap-1.5 text-slate-700 font-bold">
                                {{ $featuredPost->published_at ? $featuredPost->published_at->format('d/m/Y') : 'Mới cập nhật' }}
                            </span>
                            <span class="text-slate-300">•</span>
                            <span>{{ number_format($featuredPost->views ?? 0) }} lượt xem</span>
                        </div>

                        <a href="{{ route('news.show', $featuredPost->slug) }}">
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 mb-3.5 leading-snug tracking-tight hover:text-[#EB323A] transition-colors">
                                {{ $featuredPost->title }}
                            </h2>
                        </a>

                        @if($featuredPost->excerpt)
                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-normal mb-6 line-clamp-2">
                                {{ $featuredPost->excerpt }}
                            </p>
                        @endif
                    </div>

                    <div>
                        <a
                            href="{{ route('news.show', $featuredPost->slug) }}"
                            class="group inline-flex items-center gap-2 bg-[#EB323A] hover:bg-[#d4272f] text-white font-bold text-xs uppercase px-6 py-3 transition-all shadow-md rounded-xs cursor-pointer"
                        >
                            <span>Đọc bài viết</span>
                            <span class="transition-transform duration-300 group-hover:translate-x-1 font-mono text-base">→</span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- CỘT PHẢI: TOP LƯỢT XEM NHIỀU NHẤT (4/12) --}}
            <div class="lg:col-span-4 bg-white border border-slate-200/90 p-6 shadow-xs flex flex-col justify-between rounded-sm">
                <div>
                    <div class="text-xs sm:text-sm font-extrabold text-slate-900 uppercase tracking-wider pb-3 mb-4 border-b border-slate-200 flex items-center justify-between">
                        <span>Xem nhiều nhất</span>
                        <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($topViewedPosts as $index => $item)
                            <a
                                href="{{ route('news.show', $item->slug) }}"
                                class="flex gap-4 py-4 first:pt-2 last:pb-0 transition-all duration-200 cursor-pointer group"
                            >
                                <div class="relative w-24 h-18 shrink-0 overflow-hidden bg-slate-100 rounded-sm">
                                    <span class="absolute top-1.5 left-1.5 bg-[#EB323A] text-white text-[10px] font-black px-1.5 py-0.5 rounded-xs z-10 shadow-xs">
                                        #{{ $index + 1 }}
                                    </span>
                                    @if($item->thumbnail)
                                        <img
                                            src="{{ $thumbnailUrl($item->thumbnail) }}"
                                            alt="{{ $item->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            loading="eager"
                                        />
                                    @else
                                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 text-[10px]">
                                            NO IMAGE
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col justify-between flex-1 min-w-0">
                                    <h3 class="text-xs sm:text-sm font-bold leading-snug line-clamp-2 text-slate-800 group-hover:text-[#EB323A] transition-colors">
                                        {{ $item->title }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-1.5 font-mono">
                                        <span>{{ $item->published_at ? $item->published_at->format('d/m/Y') : '' }}</span>
                                        <span>•</span>
                                        <span class="text-[#EB323A] font-semibold">{{ number_format($item->views ?? 0) }} xem</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="py-4 text-xs text-slate-400 font-mono">Chưa có bài viết.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================================================
             3. KHU VỰC DƯỚI: DANH SÁCH BÀI VIẾT (LƯỚI 3 CỘT)
             ========================================================= --}}
        <div class="border-t border-slate-200 pt-12">
            @if(isset($posts) && $posts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white border border-slate-200/90 rounded-sm overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col group">
                            
                            {{-- Khung Ảnh Thumbnail --}}
                            <a href="{{ route('news.show', $post->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100">
                                @if($post->thumbnail)
                                    <img
                                        src="{{ $thumbnailUrl($post->thumbnail) }}"
                                        alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                    />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs uppercase">
                                        No Image
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="rounded-xs bg-white/95 px-3.5 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-slate-900 shadow-sm border border-slate-200/80 backdrop-blur-sm">
                                        {{ $post->category->name ?? 'Tin tức' }}
                                    </span>
                                </div>
                            </a>

                            {{-- Nội Dung Thẻ --}}
                            <div class="p-6 flex flex-col flex-1 justify-between">
                                <div>
                                    <div class="flex items-center gap-2.5 text-xs font-mono text-slate-500 tracking-wider mb-3">
                                        <span class="font-bold text-[#264abc]">{{ $post->published_at ? $post->published_at->format('d/m/Y') : '' }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-slate-500 font-semibold">{{ number_format($post->views ?? 0) }} lượt xem</span>
                                    </div>

                                    <a href="{{ route('news.show', $post->slug) }}">
                                        <h4 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-[1.4] line-clamp-2 group-hover:text-[#EB323A] transition-colors mb-3">
                                            {{ $post->title }}
                                        </h4>
                                    </a>

                                    @if($post->excerpt)
                                        <p class="text-sm sm:text-base text-slate-600 line-clamp-2 leading-relaxed font-normal">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                </div>

                                <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                                    <a
                                        href="{{ route('news.show', $post->slug) }}"
                                        class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#264abc]"
                                    >
                                        <span class="group-hover:text-[#EB323A] transition-colors">Chi tiết</span>
                                        <span class="transition-transform duration-200 group-hover:translate-x-1.5 font-mono text-base text-[#EB323A]">→</span>
                                    </a>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>

                {{-- Phân Trang Tùy Chỉnh Giao Diện Icon Hiện Đại --}}
                @if(method_exists($posts, 'hasPages') && $posts->hasPages())
                    <div class="mt-16 pt-8 border-t border-slate-200 flex items-center justify-center">
                        <nav class="flex items-center gap-1.5" role="navigation" aria-label="Pagination Navigation">
                            
                            {{-- Nút Previous (Trang trước) --}}
                            @if ($posts->onFirstPage())
                                <span class="flex items-center justify-center w-10 h-10 rounded-sm border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $posts->previousPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-sm border border-slate-200 text-slate-700 bg-white hover:border-[#EB323A] hover:text-[#EB323A] hover:shadow-sm transition-all cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Các số trang --}}
                            @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                @if ($page == $posts->currentPage())
                                    <span class="flex items-center justify-center w-10 h-10 rounded-sm bg-[#EB323A] text-white font-bold text-xs shadow-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 rounded-sm border border-slate-200 text-slate-700 bg-white hover:border-[#EB323A] hover:text-[#EB323A] hover:shadow-sm font-medium text-xs transition-all cursor-pointer">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Nút Next (Trang sau) --}}
                            @if ($posts->hasMorePages())
                                <a href="{{ $posts->nextPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-sm border border-slate-200 text-slate-700 bg-white hover:border-[#EB323A] hover:text-[#EB323A] hover:shadow-sm transition-all cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span class="flex items-center justify-center w-10 h-10 rounded-sm border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif

                        </nav>
                    </div>
                @endif
            @else
                <div class="text-center py-20 text-slate-500 bg-white border border-dashed border-slate-200 rounded-sm">
                    <p class="text-base mb-2">Chưa có bài viết nào khác.</p>
                    <a
                        href="{{ route('news.index') }}"
                        class="text-xs font-semibold uppercase tracking-wider text-[#EB323A] underline cursor-pointer"
                    >
                        Xem tất cả bài viết
                    </a>
                </div>
            @endif
        </div>

    </div>
</section>
@endsection