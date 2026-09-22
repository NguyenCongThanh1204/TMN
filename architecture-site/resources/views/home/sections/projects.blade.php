{{-- =========================================================
     HOME - PROJECTS SECTION (LUXURY ARCHITECTURAL ACCORDION WALL - 1440PX)
     resources/views/sections/projects.blade.php
========================================================= --}}

@php
use Illuminate\Support\Facades\Storage;

$displayProjects = \App\Models\Project::query()
->with('category')
->where('status', 'published')
->where('is_featured', true)
->latest('updated_at')
->take(5)
->get();

if ($displayProjects->isEmpty()) {
$displayProjects = \App\Models\Project::query()
->with('category')
->where('status', 'published')
->latest('created_at')
->take(5)
->get();
}
@endphp

<section
    id="projects"
    class="relative bg-white pt-[36px] pb-[28px] md:pt-[54px] md:pb-[40px] border-b border-slate-200/80 text-slate-900 overflow-hidden select-none"
    x-data="{
        activeId: {{ $displayProjects->first()?->id ?? 1 }},
        projects: [
            @foreach($displayProjects as $project)
            @php
                $cover = $project->cover_url ?? $project->cover_image;
                if ($cover && !Illuminate\Support\Str::startsWith($cover, ['http://', 'https://'])) {
                    $cover = Storage::disk('cloudinary')->url(ltrim($cover, '/'));
                }
            @endphp
            {
                id: {{ $project->id }},
                title: '{{ addslashes($project->title) }}',
                location: '{{ addslashes($project->location ?? 'Đà Nẵng') }}',
                category: '{{ optional($project->category)->name ?? 'Tổng thầu thi công' }}',
                year: '{{ $project->year ?? '' }}',
                area: '{{ $project->area_sqm ? (is_numeric($project->area_sqm) ? number_format((float)$project->area_sqm, 0, ',', '.') . ' m²' : addslashes($project->area_sqm)) : '' }}',
                image: '{{ $cover ?? 'https://images.unsplash.com/photo-1541888946425-d0fbb186156f?auto=format&fit=crop&w=1600&q=80' }}',
                url: '{{ route('projects.show', $project) }}'
            },
            @endforeach
        ],
        get currentProject() {
            return this.projects.find(p => p.id === this.activeId) || this.projects[0];
        },
        get currentIndex() {
            return this.projects.findIndex(p => p.id === this.activeId);
        }
    }">
    {{-- Nền ánh sáng mờ mịn sang trọng (Không dùng đường kẻ) --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[520px] h-[520px] bg-blue-100/45 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-32 -right-32 w-[480px] h-[480px] bg-red-100/30 rounded-full blur-[110px]"></div>
    </div>

    {{-- CONTAINER CHUẨN 1440PX ĐỒNG BỘ TOÀN BỘ TRANG --}}
    <div class="relative mx-auto max-w-[1440px] px-6 sm:px-10 lg:px-12 z-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 border-b border-slate-200 pb-6">
            <div>
                <div class="flex items-center gap-2.5 mb-2">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                        Hồ Sơ Thực Thi
                    </span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
                    Công Trình & Dự Án <span class="font-light text-slate-400">Tiêu Biểu</span>
                </h2>
            </div>

            <a href="{{ route('projects.index') }}"
                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-600 hover:text-[#EB323A] transition-colors pb-1 group">
                <span>Tất cả dự án</span>
                <span class="transition-transform duration-300 group-hover:translate-x-1 font-mono text-sm">→</span>
            </a>
        </div>

        {{-- Desktop Accordion Wall (Nâng lên 620px bung nở cùng chiều rộng 1440px) --}}
        <div class="mt-8 hidden lg:flex h-[620px] w-full gap-3 overflow-hidden">
            <template x-for="(project, index) in projects" :key="project.id">
                <div
                    @mouseenter="activeId = project.id"
                    class="relative h-full overflow-hidden cursor-pointer rounded-xs border transition-all duration-700 select-none"
                    :style="'transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);' + (activeId !== project.id ? 'background-color: #0e2e60 !important;' : '')"
                    :class="activeId === project.id 
                        ? 'flex-[6] border-slate-300 shadow-[0_20px_50px_rgba(14,46,96,0.14)] z-20' 
                        : 'flex-[1] border-[#18468a] z-10'">
                    {{-- Ảnh nền lớn của từng cột khi Active --}}
                    <div x-show="activeId === project.id" class="absolute inset-0 h-full w-full">
                        <img
                            :src="project.image"
                            :alt="project.title"
                            class="w-full h-full object-cover object-center transition-all duration-700 ease-out"
                            loading="eager"
                            fetchpriority="high" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-70 pointer-events-none"></div>
                    </div>

                    {{-- 1. TRẠNG THÁI THU GỌN: MÀU NỀN #0e2e60 --}}
                    <div
                        x-show="activeId !== project.id"
                        class="absolute inset-0 p-4 flex flex-col justify-between items-center z-10"
                        style="background-color: #0e2e60 !important;">
                        {{-- Thumbnail đơn --}}
                        <div class="flex flex-col items-center gap-2.5 w-full">
                            <div class="w-full aspect-[16/10] rounded-xs overflow-hidden border border-white/20 bg-black/30 shadow">
                                <img :src="project.image" class="w-full h-full object-cover brightness-95" />
                            </div>
                            <span class="font-mono text-xs font-bold text-white tracking-widest" x-text="'0' + (index + 1)"></span>
                        </div>

                        {{-- Tên dự án dọc --}}
                        <div class="h-3/5 flex items-center justify-center overflow-hidden">
                            <span
                                class="text-xs font-bold uppercase tracking-[0.24em] text-white [writing-mode:vertical-lr] rotate-180 whitespace-nowrap"
                                x-text="project.title"></span>
                        </div>

                        {{-- Vệt đỏ chân thẻ --}}
                        <div class="flex flex-col items-center gap-1 pb-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#EB323A]"></span>
                            <span class="h-6 w-[1.5px] bg-[#EB323A]"></span>
                        </div>
                    </div>

                    {{-- 2. TRẠNG THÁI MỞ RỘNG: CARD KÍNH TRONG SUỐT ĐỒNG NHẤT --}}
                    <div
                        x-show="activeId === project.id"
                        class="absolute inset-0 p-8 sm:p-10 lg:p-12 flex flex-col justify-between z-20 pointer-events-none">
                        {{-- Top Header --}}
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <span class="bg-white/95 backdrop-blur-md px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-900 border border-white/60 shadow-sm rounded-xs">
                                    <span class="text-[#EB323A] mr-1.5">●</span>
                                    <span x-text="project.category"></span>
                                </span>
                            </div>

                        </div>

                        {{-- Card thông tin chi tiết --}}
                        <div class="max-w-2xl pointer-events-auto">
                            <div
                                class="relative p-6 sm:p-8 rounded-xs border border-white/60 shadow-xl backdrop-blur-sm"
                                style="background-color: rgba(255, 255, 255, 0.4) !important;">
                                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-800 font-semibold mb-2.5">
                                    <span class="font-bold text-[#EB323A]" x-text="project.location"></span>
                                    <template x-if="project.year">
                                        <span class="flex items-center gap-2">
                                            <span class="text-[#EB323A]">•</span>
                                            <span x-text="'Hoàn thành ' + project.year"></span>
                                        </span>
                                    </template>
                                </div>

                                <!-- TIÊU ĐỀ: Bọc trong thẻ a để bấm vào chuyển trang -->
                                <h3 class="mb-4">
                                    <a
                                        :href="project.url"
                                        class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-snug transition-colors hover:text-[#EB323A] block"
                                        style="color: #264abc !important;">
                                        <span x-text="project.title"></span>
                                    </a>
                                </h3>

                                <div class="mt-4 pt-3.5 border-t border-slate-900/10 flex items-center justify-between">
                                    <a
                                        :href="project.url"
                                        class="group/link inline-flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] transition-colors"
                                        style="color: #264abc;">
                                        <span class="group-hover/link:text-[#EB323A] transition-colors">Khám phá hồ sơ chi tiết</span>
                                        <span class="transition-transform duration-300 group-hover/link:translate-x-1.5 text-[#EB323A]">→</span>
                                    </a>

                                    <!-- ICON MŨI TÊN: Chuyển thành thẻ a có chung :href để click chuyển trang -->
                                    <a
                                        :href="project.url"
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white/85 hover:bg-[#264abc] text-slate-700 hover:text-white text-xs border border-white/90 shadow-sm transition-colors"
                                        title="Xem chi tiết">
                                        ↗
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>

        {{-- Mobile & Tablet --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:hidden mt-6">
            <template x-for="project in projects" :key="project.id">
                <a :href="project.url" class="group block relative aspect-[16/11] overflow-hidden rounded-xs border border-slate-200 bg-white shadow-md">
                    <img :src="project.image" :alt="project.title" class="h-full w-full object-cover object-center brightness-[0.95]" />
                    <div class="absolute inset-0 bg-gradient-to-t from-white/90 via-white/30 to-transparent"></div>

                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <span class="bg-white px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-950 shadow" x-text="project.category"></span>
                        <span class="bg-[#EB323A] text-white px-2 py-1 text-[10px] font-bold uppercase tracking-wider shadow">★ Tiêu biểu</span>
                    </div>

                    <div class="absolute bottom-4 left-4 right-4 text-slate-900">
                        <p class="text-[11px] text-slate-700 mb-1 font-semibold" x-text="project.location + (project.year ? ' • ' + project.year : '')"></p>
                        <h3 class="text-base font-bold" style="color: #264abc !important;" x-text="project.title"></h3>
                    </div>
                </a>
            </template>
        </div>

    </div>
</section>