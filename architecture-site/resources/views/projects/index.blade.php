@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;

    // Helper closure chuẩn hóa đường dẫn ảnh công trình
    $resolveImageUrl = function ($path) {
        if (empty($path)) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return Storage::disk('public')->url(ltrim($path, '/'));
    };

    // Helper format diện tích an toàn cho cả dạng varchar lẫn số
    $formatScale = function ($areaSqm) {
        if (empty($areaSqm)) {
            return 'Quy mô lớn';
        }
        if (is_numeric($areaSqm)) {
            return number_format((float)$areaSqm, 0, ',', '.') . ' m²';
        }
        return (string)$areaSqm;
    };

    // Chuẩn hóa dữ liệu riêng cho Hero Vòng xoay 3D từ biến $wheelProjects (cố định is_featured = 1)
    $formattedWheelProjects = collect($wheelProjects ?? [])->map(function ($item, $index) use ($resolveImageUrl, $formatScale) {
        return [
            'id' => $item->id,
            'number' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
            'title' => $item->title,
            'location' => $item->location ?? 'Đà Nẵng & Miền Trung',
            'category' => optional($item->category)->name ?? 'Công trình trọng điểm',
            'scale' => $formatScale($item->area_sqm),
            'desc' => $item->description ?? $item->excerpt ?? 'Công trình thi công kiến trúc tiêu biểu, khẳng định năng lực tổng thầu uy tín của Tân Minh Nhân.',
            'image' => $resolveImageUrl($item->cover_image),
            'link' => route('projects.show', $item->slug ?? $item->id),
        ];
    })->values();
@endphp

@section('content')
@push('preloads')
    @if(isset($formattedWheelProjects) && $formattedWheelProjects->isNotEmpty())
        <link rel="preload" as="image" href="{{ $formattedWheelProjects->first()['image'] }}" fetchpriority="high">
    @endif
@endpush

<div class="page-transition bg-white select-none text-slate-900">

    {{-- =========================================================
         1. HERO SECTION: VÒNG XOAY 3D TƯƠNG TÁC (3D WHEEL) - CỐ ĐỊNH DỰ ÁN TIÊU BIỂU
         ========================================================= --}}
    @if($formattedWheelProjects->isNotEmpty())
        <section
            x-data="{
                projects: {{ Js::from($formattedWheelProjects) }},
                total: {{ $formattedWheelProjects->count() }},
                rotationAngle: 0,
                activeCardIndex: 0,
                isHovered: false,
                isDragging: false,
                startX: 0,
                radius: 420,
                timer: null,
                intervalMs: 4500,

                get angleStep() {
                    return this.total > 0 ? (360 / this.total) : 0;
                },

                init() {
                    this.updateActiveIndex();
                    this.startAutoPlay();

                    const updateRadius = () => {
                        this.radius = window.innerWidth < 640 ? 250 : (window.innerWidth < 1024 ? 340 : 420);
                    };
                    updateRadius();
                    window.addEventListener('resize', updateRadius);
                },

                startAutoPlay() {
                    if (this.timer) clearInterval(this.timer);
                    this.timer = setInterval(() => {
                        if (!this.isHovered && !this.isDragging && this.total > 1) {
                            this.next();
                        }
                    }, this.intervalMs);
                },

                next() {
                    this.rotationAngle -= this.angleStep;
                    this.updateActiveIndex();
                },

                prev() {
                    this.rotationAngle += this.angleStep;
                    this.updateActiveIndex();
                },

                rotateTo(index) {
                    this.rotationAngle = -index * this.angleStep;
                    this.updateActiveIndex();
                },

                updateActiveIndex() {
                    if (this.total === 0) return;
                    let normalized = ((-this.rotationAngle % 360) + 360) % 360;
                    let earlyTrigger = (normalized + this.angleStep / 2) % 360;
                    this.activeCardIndex = Math.floor(earlyTrigger / this.angleStep) % this.total;
                },

                handlePointerDown(e) {
                    this.isDragging = true;
                    this.startX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
                },

                handlePointerMove(e) {
                    if (!this.isDragging) return;
                    const clientX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
                    const deltaX = clientX - this.startX;
                    this.rotationAngle += deltaX * 0.25;
                    this.startX = clientX;
                    this.updateActiveIndex();
                },

                handlePointerUp() {
                    if (!this.isDragging) return;
                    this.isDragging = false;
                    const nearestIndex = Math.round(-this.rotationAngle / this.angleStep);
                    this.rotationAngle = -nearestIndex * this.angleStep;
                    this.updateActiveIndex();
                }
            }"
            @mouseenter="isHovered = true"
            @mouseleave="isHovered = false; startAutoPlay()"
            @mousedown="handlePointerDown($event)"
            @mousemove="handlePointerMove($event)"
            @mouseup="handlePointerUp()"
            @touchstart="handlePointerDown($event)"
            @touchmove="handlePointerMove($event)"
            @touchend="handlePointerUp()"
            class="relative w-full min-h-screen pt-24 pb-14 bg-[#161E2E] text-white flex flex-col justify-center items-center overflow-hidden"
            style="touch-action: pan-y;"
        >
            <div class="absolute inset-0 w-full h-full pointer-events-none z-0 overflow-hidden">
                <template x-for="(p, idx) in projects" :key="'bg-' + p.id">
                    <div
                        x-show="activeCardIndex === idx"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 scale-105"
                        x-transition:enter-end="opacity-75 scale-100"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-75 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute inset-0 w-full h-full"
                    >
                        <img
                            :src="p.image"
                            :alt="p.title"
                            class="w-full h-full object-cover object-center filter blur-xs brightness-125"
                            loading="eager"
                            fetchpriority="high"
                        />
                    </div>
                </template>
                <div class="absolute inset-0 bg-gradient-to-t from-[#161E2E] via-[#161E2E]/45 to-[#161E2E]/20"></div>
            </div>

            <div
                class="relative w-full max-w-[1200px] h-[500px] flex items-center justify-center z-10"
                style="perspective: 1200px;"
            >
                <div
                    class="relative w-full h-full flex items-center justify-center cursor-grab active:cursor-grabbing"
                    style="transform-style: preserve-3d;"
                >
                    <template x-for="(item, i) in projects" :key="item.id">
                        <div
                            @click="rotateTo(i)"
                            class="absolute w-[290px] sm:w-[360px] h-[450px] rounded-2xl border p-6 flex flex-col justify-between overflow-hidden backdrop-blur-md transition-all duration-300 pointer-events-auto bg-slate-900/80"
                            :class="activeCardIndex === i
                                ? 'border-[#EB323A] shadow-[0_20px_60px_rgba(235,50,58,0.45)] ring-2 ring-[#EB323A]/50 bg-slate-900/90'
                                : 'border-slate-800/80 shadow-2xl bg-slate-900/75'"
                            :style="(() => {
                                const cardAngle = i * angleStep + rotationAngle;
                                const rad = (cardAngle * Math.PI) / 180;
                                const x = radius * Math.sin(rad);
                                const z = radius * Math.cos(rad);
                                const scale = Math.max(0.65, ((z + radius) / (2 * radius)) * 0.4 + 0.65);
                                const opacity = z < -100 ? 0.25 : Math.max(0.35, (z + radius) / (2 * radius));
                                const zIndex = Math.round(z + radius);

                                return `transform: translate3d(${x}px, 0px, ${z}px) rotateY(${cardAngle}deg) scale(${scale}); opacity: ${opacity}; z-index: ${zIndex};`;
                            })()"
                        >
                            <div class="absolute inset-0 w-full h-full overflow-hidden rounded-2xl pointer-events-none bg-slate-900">
                                <template x-if="item.image">
                                    <img
                                        :src="item.image"
                                        :alt="item.title"
                                        draggable="false"
                                        class="w-full h-full object-cover object-center transition-opacity duration-300"
                                        :class="activeCardIndex === i ? 'opacity-100' : 'opacity-40'"
                                    />
                                </template>
                                <div
                                    class="absolute inset-0 transition-all duration-300"
                                    :class="activeCardIndex === i
                                        ? 'bg-gradient-to-t from-[#0B0F17]/95 via-[#0B0F17]/35 to-transparent'
                                        : 'bg-gradient-to-t from-[#0B0F17] via-[#0B0F17]/75 to-[#0B0F17]/40'"
                                ></div>
                            </div>

                            <div class="relative z-10 flex justify-between items-start pointer-events-none">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#EB323A] bg-black/80 backdrop-blur-md px-3 py-1 rounded-full border border-[#EB323A]/40 flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-[#EB323A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span x-text="item.location"></span>
                                </span>

                                <span class="font-mono font-black text-4xl text-white/20 select-none" x-text="item.number"></span>
                            </div>

                            <div class="relative z-10 space-y-2 pointer-events-none">
                                <p class="text-xl sm:text-2xl font-bold text-white leading-snug line-clamp-2" x-text="item.title"></p>

                                <div
                                    x-show="activeCardIndex === i"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="pt-2 pointer-events-auto"
                                >
                                    <a
                                        :href="item.link"
                                        class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-white hover:text-[#EB323A] transition-colors group/btn"
                                    >
                                        <span>Khám phá công trình</span>
                                        <span class="transition-transform group-hover/btn:translate-x-1 font-mono text-sm">→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    @endif

    {{-- =========================================================
         2 & 3. DANH MỤC + BỘ LỌC SERVER-SIDE (MỖI TRANG 10 DỰ ÁN)
         ========================================================= --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-white text-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER DANH MỤC + BỘ LỌC --}}
            <div class="border-b border-slate-200 pb-8 mb-12 sm:mb-16">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2 font-mono text-xs font-bold uppercase tracking-[0.2em] text-[#EB323A] mb-1.5">
                            <span class="w-1.5 h-1.5 bg-[#EB323A] rounded-full"></span>
                            HỒ SƠ NĂNG LỰC THI CÔNG
                        </div>
                        <h2 class="text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-slate-950">
                            Công Trình Tiêu Biểu
                        </h2>
                    </div>

                    <!-- <div class="font-mono text-xs text-slate-500">
                        HIỂN THỊ: <span class="font-bold text-slate-950 font-sans text-sm">{{ $projects->count() }}</span> / TỔNG SỐ <span class="font-bold text-slate-950 font-sans text-sm">{{ $projects->total() }}</span> DỰ ÁN
                    </div> -->
                </div>

                {{-- NÚT BỘ LỌC DANH MỤC --}}
                <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar pt-2" style="scrollbar-width: none;">
                    <a
                        href="{{ route('projects.index', array_merge(request()->except(['category', 'page']), ['page' => 1])) }}"
                        class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 focus:outline-none cursor-pointer {{ !request()->filled('category') ? 'bg-[#EB323A] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                    >
                        Tất cả
                    </a>

                    @foreach($categories as $cat)
                        <a
                            href="{{ route('projects.index', array_merge(request()->except(['page']), ['category' => $cat->id, 'page' => 1])) }}"
                            class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 focus:outline-none cursor-pointer {{ request('category') == $cat->id || request('category') == $cat->slug ? 'bg-[#EB323A] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                        >
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- DANH SÁCH DỰ ÁN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 lg:gap-x-14 gap-y-12 lg:gap-y-16 items-start">
                @forelse($projects as $index => $item)
                    @php
                        $coverImage = !empty($item->cover_image) ? $resolveImageUrl($item->cover_image) : null;
                        $scaleFormatted = $formatScale($item->area_sqm);
                        $displayScale = !empty($item->area_sqm) ? 'Tổng diện tích ' . $scaleFormatted : ($item->scale ?? 'Công trình quy mô lớn');
                        $categoryName = optional($item->category)->name ?? 'Công trình kiến trúc';
                        $clientName = $item->client_name ?: ($item->client ?? 'Tân Minh Nhân');
                        $projectLink = route('projects.show', $item->slug ?? $item->id);
                        $isReverse = ($index % 2 !== 0);
                        $isImageTop = ($index % 2 === 0);
                    @endphp
                    <article class="flex flex-col group {{ $isReverse ? 'md:flex-col-reverse' : '' }}">
                        <a
                            href="{{ $projectLink }}"
                            class="relative block w-full aspect-[16/10] overflow-hidden rounded-sm bg-slate-100 group-hover:shadow-xl transition-all duration-500"
                        >
                            @if($coverImage)
                                <img
                                    src="{{ $coverImage }}"
                                    alt="{{ $item->title }}"
                                    class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                    loading="lazy"
                                />
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-slate-100 text-slate-400 font-mono text-xs uppercase tracking-widest">
                                    Tân Minh Nhân
                                </div>
                            @endif
                        </a>

                        <div class="space-y-2.5 {{ $isImageTop ? 'pt-4 sm:pt-5' : 'pb-4 sm:pb-5' }}">
                            <h3 class="text-base sm:text-lg lg:text-xl font-bold uppercase tracking-tight text-[#1E3A8A] group-hover:text-[#EB323A] transition-colors leading-snug">
                                <a href="{{ $projectLink }}">{{ $item->title }}</a>
                            </h3>

                            <div class="space-y-1.5 text-xs sm:text-[13px] text-slate-700">
                                <div class="leading-relaxed">
                                    <span class="text-slate-400 text-[11px] block font-medium uppercase tracking-wider">Chủ đầu tư</span>
                                    <span class="font-semibold text-slate-900">{{ $clientName }}</span>
                                </div>

                                <div class="leading-relaxed">
                                    <span class="text-slate-400 text-[11px] block font-medium uppercase tracking-wider">Phạm vi công việc</span>
                                    <span class="text-slate-800">{{ $categoryName }}</span>
                                </div>

                                <div class="leading-relaxed">
                                    <span class="text-slate-400 text-[11px] block font-medium uppercase tracking-wider">Quy mô</span>
                                    <span class="text-slate-800">
                                        {{ $displayScale }}
                                        @if($item->location)
                                            <span> • {{ $item->location }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="pt-1">
                                <a
                                    href="{{ $projectLink }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#EB323A] hover:text-red-700 transition-colors"
                                >
                                    <span>Chi tiết dự án</span>
                                    <span class="font-mono text-sm transition-transform group-hover:translate-x-1">→</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full border border-dashed border-slate-300 bg-slate-50 py-16 text-center rounded-xl my-6">
                        <p class="font-mono text-xs text-[#EB323A] uppercase tracking-widest">// HỒ SƠ DỰ ÁN</p>
                        <h3 class="mt-2 text-lg font-bold uppercase text-slate-900">Không tìm thấy công trình thuộc danh mục này</h3>
                        <a
                            href="{{ route('projects.index') }}"
                            class="mt-5 inline-flex px-6 py-2.5 rounded-full font-mono text-xs font-bold uppercase tracking-wider text-white bg-slate-950 hover:bg-[#EB323A] transition-colors cursor-pointer"
                        >
                            Xem tất cả dự án
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- THANH PHÂN TRANG GIAO DIỆN ICON ĐẸP MẮT --}}
            @if($projects->hasPages())
                <div class="mt-16 pt-8 border-t border-slate-200 flex items-center justify-center">
                    <nav class="flex items-center gap-1.5" role="navigation" aria-label="Pagination Navigation">
                        
                        {{-- Nút Previous --}}
                        @if ($projects->onFirstPage())
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $projects->previousPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 text-slate-700 bg-white hover:border-[#EB323A] hover:text-[#EB323A] hover:shadow-sm transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        {{-- Các số trang --}}
                        @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                            @if ($page == $projects->currentPage())
                                <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#EB323A] text-white font-bold text-xs shadow-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 text-slate-700 bg-white hover:border-[#EB323A] hover:text-[#EB323A] hover:shadow-sm font-medium text-xs transition-all">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Nút Next --}}
                        @if ($projects->hasMorePages())
                            <a href="{{ $projects->nextPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 text-slate-700 bg-white hover:border-[#EB323A] hover:text-[#EB323A] hover:shadow-sm transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        @endif

                    </nav>
                </div>
            @endif

        </div>
    </section>

</div>

@endsection