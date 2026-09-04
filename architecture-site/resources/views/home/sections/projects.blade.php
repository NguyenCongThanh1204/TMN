{{-- =========================================================
     HOME - PROJECTS SECTION (LUXURY ARCHITECTURAL ACCORDION WALL)
     resources/views/sections/projects.blade.php
========================================================= --}}

<section
    id="projects"
    class="relative bg-[#FAFAFA] py-24 sm:py-32 border-b border-slate-200/80 text-slate-900 overflow-hidden"
    x-data="{
        activeId: {{ $featuredProjects->first()?->id ?? 1 }},
        activeCategory: 'all',
        projects: [
            @foreach($featuredProjects as $project)
            @php
                $cover = $project->cover_image;
                if ($cover && !Illuminate\Support\Str::startsWith($cover, ['http://', 'https://', '/'])) {
                    $cover = asset('storage/' . ltrim($cover, '/'));
                }
            @endphp
            {
                id: {{ $project->id }},
                title: '{{ addslashes($project->title) }}',
                location: '{{ addslashes($project->location ?? 'Đà Nẵng') }}',
                category: '{{ optional($project->category)->name ?? 'Công trình' }}',
                categorySlug: '{{ optional($project->category)->slug ?? '' }}',
                year: '{{ $project->year ?? '' }}',
                area: '{{ $project->area_sqm ? number_format($project->area_sqm, 0, ',', '.') . ' m²' : '' }}',
                image: '{{ $cover ?? 'https://images.unsplash.com/photo-1541888946425-d0fbb186156f?auto=format&fit=crop&w=1400&q=80' }}',
                url: '{{ route('projects.show', $project) }}'
            },
            @endforeach
        ],

        get filteredProjects() {
            if (this.activeCategory === 'all') return this.projects.slice(0, 5);
            const list = this.projects.filter(p => p.categorySlug === this.activeCategory);
            return list.length ? list.slice(0, 5) : this.projects.slice(0, 5);
        }
    }"
>
    {{-- Background Hairline CAD Grid mờ sang trọng --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(#0f172a 1px, transparent 1px), linear-gradient(90deg, #0f172a 1px, transparent 1px); background-size: 64px 64px;">
    </div>

    <div class="relative mx-auto max-w-7xl px-6 md:px-12 z-10">

        {{-- =====================================================
             SECTION HEADER (EDITORIAL ARCHITECTURE STYLE)
        ====================================================== --}}
         <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 border-b border-slate-200/90 pb-8">
            <div>
                <div class="flex items-center gap-2.5 mb-2.5">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                        Hồ Sơ Thực Thi
                    </span>
                </div>
                <!-- <h2 class="font-heading text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-950 leading-none">
                    Dấu ấn <span class="font-light text-slate-400">kiến trúc.</span>
                </h2> -->
            </div>

        </div>

        {{-- =====================================================
             CATEGORY FILTER TABS (TỐI GIẢN CHUẨN THIẾT KẾ Ý)
        ====================================================== --}}
        <!-- <div class="mt-8 flex flex-wrap items-center gap-8 border-b border-slate-100 pb-3">
            <button
                type="button"
                @click="activeCategory = 'all'"
                class="relative pb-3 text-xs font-bold uppercase tracking-[0.18em] transition-colors focus:outline-none cursor-pointer"
                :class="activeCategory === 'all' ? 'text-[#EB323A]' : 'text-slate-400 hover:text-slate-900'"
            >
                <span>Mới nhất (Tất cả)</span>
                <span
                    class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#EB323A] transition-transform duration-300"
                    :class="activeCategory === 'all' ? 'scale-x-100' : 'scale-x-0'"
                ></span>
            </button>

            @if($projectCategories->count())
                @foreach($projectCategories as $category)
                    <button
                        type="button"
                        @click="activeCategory = '{{ $category->slug }}'"
                        class="relative pb-3 text-xs font-bold uppercase tracking-[0.18em] transition-colors focus:outline-none cursor-pointer"
                        :class="activeCategory === '{{ $category->slug }}' ? 'text-[#EB323A]' : 'text-slate-400 hover:text-slate-900'"
                    >
                        <span>{{ $category->name }}</span>
                        <span
                            class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#EB323A] transition-transform duration-300"
                            :class="activeCategory === '{{ $category->slug }}' ? 'scale-x-100' : 'scale-x-0'"
                        ></span>
                    </button>
                @endforeach
            @endif
        </div> -->

        {{-- =====================================================
             DESKTOP: ARCHITECTURAL EXPANDING WALL (580PX)
        ====================================================== --}}
        <div class="mt-12 hidden lg:flex h-[580px] w-full gap-2.5 overflow-hidden">
            <template x-for="(project, index) in filteredProjects" :key="project.id">
                <div
                    @mouseenter="activeId = project.id"
                    class="relative h-full overflow-hidden cursor-pointer rounded-xs border transition-all duration-700 select-none"
                    :style="'transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);'"
                    :class="activeId === project.id 
                        ? 'flex-[5.5] border-slate-300 shadow-[0_25px_60px_rgba(15,23,42,0.15)] z-20' 
                        : 'flex-[1] border-slate-200/80 hover:border-slate-400 bg-slate-950 z-10'"
                >
                    {{-- Ảnh nền công trình --}}
                    <img
                        :src="project.image"
                        :alt="project.title"
                        class="absolute inset-0 h-full w-full object-cover transition-all duration-1000 ease-out"
                        :class="activeId === project.id 
                            ? 'scale-105 brightness-[0.98] contrast-[1.03]' 
                            : 'scale-100 brightness-[0.55] contrast-[1.1] grayscale hover:grayscale-0'"
                        loading="lazy"
                    />

                    {{-- Gradient phủ điện ảnh khi Active --}}
                    <div
                        class="absolute inset-0 transition-opacity duration-700 pointer-events-none"
                        :class="activeId === project.id 
                            ? 'bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent opacity-95' 
                            : 'bg-slate-950/40 opacity-100'"
                    ></div>

                    {{-- =================================================
                         1. TRẠNG THÁI THU NHỎ (INACTIVE STRIP): MONOLITH KÍNH SANG TRỌNG
                    ================================================== --}}
                    <div
                        x-show="activeId !== project.id"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="absolute inset-0 p-5 flex flex-col justify-between items-center z-10"
                    >
                        {{-- Số thứ tự kỹ thuật trên đầu cột --}}
                        <div class="flex flex-col items-center">
                            <span
                                class="font-mono text-sm font-extrabold text-white/90 tracking-widest"
                                x-text="'0' + (index + 1)"
                            ></span>
                            <span class="w-2.5 h-[1px] bg-white/40 mt-1"></span>
                        </div>

                        {{-- Tên công trình chạy dọc không bị cụt hay lỗi font --}}
                        <div class="h-3/4 flex items-center justify-center overflow-hidden">
                            <span
                                class="text-xs font-bold uppercase tracking-[0.28em] text-white/80 [writing-mode:vertical-lr] rotate-180 drop-shadow-md whitespace-nowrap"
                                x-text="project.title"
                            ></span>
                        </div>

                        {{-- Vệt chỉ đỏ kỹ thuật dưới chân cột --}}
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="h-1 w-1 rounded-full bg-[#EB323A]"></span>
                            <span class="h-5 w-[1px] bg-[#EB323A]/80"></span>
                        </div>
                    </div>

                    {{-- =================================================
                         2. TRẠNG THÁI MỞ RỘNG (ACTIVE HERO STRIP): ĐẲNG CẤP VƯỢT TRỘI
                    ================================================== --}}
                    <div
                        x-show="activeId === project.id"
                        x-transition:enter="transition ease-out duration-500 delay-150"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute inset-0 p-8 sm:p-10 flex flex-col justify-between z-20 pointer-events-none"
                    >
                        {{-- Top Bar: Badge danh mục & Số watermark khổng lồ --}}
                        <div class="flex items-start justify-between">
                            <span class="bg-white/95 backdrop-blur-md px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-950 border border-slate-200/80 shadow-sm">
                                <span class="text-[#EB323A] mr-1.5">●</span>
                                <span x-text="project.category"></span>
                            </span>

                            <span
                                class="font-mono text-7xl sm:text-8xl font-black text-white/15 leading-none select-none"
                                x-text="'0' + (index + 1)"
                            ></span>
                        </div>

                        {{-- Bottom Spec Card: Thẻ thông số kính mờ nổi bật --}}
                        <div class="max-w-2xl pointer-events-auto">
                            <div class="bg-slate-950/60 backdrop-blur-md p-6 sm:p-7 rounded-xs border border-white/15 shadow-2xl">
                                
                                {{-- Hàng metadata --}}
                                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-300 font-medium mb-3">
                                    <span class="text-white font-bold" x-text="project.location"></span>
                                    <template x-if="project.area">
                                        <span class="flex items-center gap-2">
                                            <span class="text-[#EB323A]">•</span>
                                            <span x-text="project.area"></span>
                                        </span>
                                    </template>
                                    <template x-if="project.year">
                                        <span class="flex items-center gap-2">
                                            <span class="text-[#EB323A]">•</span>
                                            <span x-text="'Hoàn thành ' + project.year"></span>
                                        </span>
                                    </template>
                                </div>

                                {{-- Tiêu đề dự án lớn sắc nét --}}
                                <p class="text-2xl sm:text-3xl font-extrabold text-red-600 tracking-tight leading-snug drop-shadow-sm">
                                    <span x-text="project.title"></span>
                                </p>

                                {{-- CTA Link --}}
                                <div class="mt-5 pt-4 border-t border-white/10 flex items-center justify-between">
                                    <a
                                        :href="project.url"
                                        class="group/link inline-flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] text-white hover:text-[#EB323A] transition-colors"
                                    >
                                        <span class="text-white">Khám phá hồ sơ chi tiết</span>
                                        <span class="transition-transform duration-300 group-hover/link:translate-x-1.5 text-white">→</span>
                                    </a>

                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white text-xs border border-white/20">
                                        ↗
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>

        {{-- =====================================================
             MOBILE & TABLET: BỐ CỤC THẺ SÁNG TÁCH BẠCH
        ====================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:hidden mt-8">
            <template x-for="(project, index) in filteredProjects" :key="project.id">
                <a :href="project.url" class="group block relative aspect-[16/11] overflow-hidden rounded-xs border border-slate-200 bg-slate-950 shadow-sm">
                    <img
                        :src="project.image"
                        :alt="project.title"
                        class="h-full w-full object-cover brightness-[0.9] transition-transform duration-700 group-hover:scale-105"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/95 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-950" x-text="project.category"></span>
                    </div>

                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <p class="text-[11px] text-slate-300 mb-1" x-text="project.location + (project.year ? ' • ' + project.year : '')"></p>
                        <h3 class="text-lg font-bold leading-snug" x-text="project.title"></h3>
                    </div>
                </a>
            </template>
        </div>

    </div>
</section>