@extends('layouts.app')

@section('content')

@php
// Helper chuẩn hóa đường dẫn ảnh an toàn qua Storage Facade
$resolveImageUrl = function ($path) {
if (empty($path)) {
return null;
}
if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
return $path;
}
return cloudinary_image_url($path, 800);
};

// Helper format diện tích an toàn cho varchar
$formatArea = function ($area) {
if (empty($area)) {
return null;
}
if (is_numeric($area)) {
return number_format((float)$area, 0, ',', '.') . ' m²';
}
return (string)$area;
};

$coverImg = $resolveImageUrl($project->cover_image);

// Lấy danh sách ảnh chi tiết từ quan hệ media (ProjectMedia model)
$galleryImages = $project->media->map(function ($mediaItem) use ($resolveImageUrl) {
return $resolveImageUrl($mediaItem->file_path);
})->filter()->values();
@endphp

<div class="page-transition bg-[#F8FAFC] text-[#0F172A] select-none font-sans min-h-screen relative pt-20 sm:pt-24 pb-20">

    {{-- Background Grid Pattern mờ --}}
    <div
        class="absolute inset-0 opacity-[0.03] pointer-events-none"
        style="background-image: linear-gradient(to right, #000000 1px, transparent 1px), linear-gradient(to bottom, #000000 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">

        {{-- BREADCRUMBS & ĐIỀU HƯỚNG QUAY LẠI --}}
        <div class="flex items-center justify-between py-6 border-b border-slate-200/80 mb-8">
            <a
                href="{{ route('projects.index') }}"
                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-[#EB323A] transition-colors">
                <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Quay lại danh sách dự án
            </a>
            <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                <span>Dự án</span>
                <span>/</span>
                <span class="text-[#0F172A] font-bold truncate max-w-[200px]">{{ $project->title }}</span>
            </div>
        </div>

        {{-- TIÊU ĐỀ & THÔNG TIN CƠ BẢN --}}
        <div class="mb-8">
            <div class="flex flex-wrap items-center gap-2.5 mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#EB323A] bg-red-50 px-3 py-1 rounded-full border border-red-200 shadow-xs">
                    {{ optional($project->category)->name ?? 'Công trình kiến trúc' }}
                </span>
                @if($project->year)
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Năm {{ $project->year }}
                </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-[#0F172A] leading-tight tracking-tight mb-4 uppercase">
                {{ $project->title }}
            </h1>

            @if(!empty($project->location))
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-600 font-medium">
                <svg class="w-4 h-4 text-[#EB323A] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <span>{{ $project->location }}</span>
            </div>
            @endif
        </div>

        {{-- HỆ THỐNG HIỂN THỊ ẢNH CHÍNH & THUMBNAIL (SỬ DỤNG ALPINE.JS) --}}
        @if($coverImg)
        <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-12"
            x-data="{
                    activeImage: '{{ $coverImg }}',
                    openLightbox: false,
                    lightboxImg: ''
                }">
            {{-- Khung ảnh lớn --}}
            <div class="lg:col-span-9 aspect-[16/10] rounded-2xl overflow-hidden bg-slate-200 relative group shadow-sm border border-slate-200/80">
                <img
                    :src="activeImage"
                    alt="{{ $project->title }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
            </div>

            {{-- Danh sách Thumbnail bên cạnh (Bao gồm ảnh bìa + các ảnh trong project_media) --}}
            @php
            $allThumbnails = collect([$coverImg])->merge($galleryImages)->unique()->values();
            @endphp

            @if($allThumbnails->count() > 1)
            <div class="lg:col-span-3 flex lg:flex-col gap-3 overflow-x-auto lg:overflow-y-auto lg:overflow-x-hidden lg:max-h-[540px] pr-1">
                @foreach($allThumbnails as $thumbUrl)
                <button
                    type="button"
                    @click="activeImage = '{{ $thumbUrl }}'"
                    class="flex-shrink-0 w-24 sm:w-32 lg:w-full aspect-[16/10] rounded-xl overflow-hidden border-2 transition-all cursor-pointer focus:outline-none"
                    :class="activeImage === '{{ $thumbUrl }}' ? 'border-[#EB323A] shadow-md scale-[1.02]' : 'border-transparent opacity-70 hover:opacity-100'">
                    <img src="{{ $thumbUrl }}" alt="Thumbnail" class="w-full h-full object-cover" />
                </button>
                @endforeach
            </div>
            @endif

        </div>
        @endif

        {{-- NỘI DUNG CHÍNH & KHUNG THÔNG SỐ KỸ THUẬT BÊN PHẢI --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start relative">

            {{-- Cột trái: Nội dung chi tiết dự án --}}
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 md:p-8 shadow-xs">
                    <h2 class="text-lg font-black uppercase tracking-tight text-[#0F172A] mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#EB323A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                        Tổng quan dự án
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
                        @if($project->body_content)
                        {!! $project->body_content !!}
                        @else
                        <p class="text-slate-500 italic">Nội dung chi tiết dự án đang được cập nhật.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Cột phải: Thông số kỹ thuật chuẩn hồ sơ năng lực (Sticky Sidebar) --}}
            <div class="lg:col-span-4 lg:sticky lg:top-28 z-20 self-start space-y-6">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-3 border-b border-slate-100 mb-2">
                        Thông tin dự án
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block mb-0.5 uppercase tracking-wider text-[10px]">Chủ đầu tư</span>
                            <span class="font-bold text-[#0F172A] text-sm">{{ $project->client_name ?: ($project->client ?? 'Tân Minh Nhân') }}</span>
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <span class="text-slate-400 block mb-0.5 uppercase tracking-wider text-[10px]">Vị trí công trình</span>
                            <span class="font-bold text-[#0F172A]">{{ $project->location ?? 'Chưa cập nhật' }}</span>
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <span class="text-slate-400 block mb-0.5 uppercase tracking-wider text-[10px]">Quy mô sàn</span>
                            <span class="font-bold text-[#0F172A]">{{ $formatArea($project->area_sqm) ?? 'Quy mô lớn' }}</span>
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <span class="text-slate-400 block mb-0.5 uppercase tracking-wider text-[10px]">Phạm vi công việc</span>
                            <span class="font-bold text-[#EB323A]">{{ optional($project->category)->name ?? 'Tổng thầu thi công' }}</span>
                        </div>

                        @if(!empty($project->year))
                        <div class="pt-2 border-t border-slate-100">
                            <span class="text-slate-400 block mb-0.5 uppercase tracking-wider text-[10px]">Năm thực hiện</span>
                            <span class="font-bold text-[#0F172A]">{{ $project->year }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- DỰ ÁN KHÁC / LIÊN QUAN --}}
        @if(isset($relatedProjects) && $relatedProjects->count() > 0)
        <div class="mt-16">
            <div class="flex items-center justify-between gap-4 mb-6">
                <h3 class="text-xl sm:text-2xl font-black text-[#0F172A] uppercase tracking-tight">
                    Dự án khác
                </h3>
                <a
                    href="{{ route('projects.index') }}"
                    class="text-xs font-bold uppercase tracking-wider text-[#EB323A] hover:text-red-700">
                    Xem tất cả
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProjects as $item)
                @php
                $relImg = $resolveImageUrl($item->cover_image);
                @endphp
                <a
                    href="{{ route('projects.show', $item->slug ?? $item->id) }}"
                    class="group block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-transform duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="aspect-[4/3] overflow-hidden bg-slate-200">
                        @if($relImg)
                        <img
                            src="{{ $relImg }}"
                            alt="{{ $item->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs font-medium">
                            Chưa có hình ảnh
                        </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#EB323A]">
                                {{ $item->location ?? 'Dự án' }}
                            </span>
                            @if($item->year)
                            <span class="text-[10px] text-slate-500">
                                {{ $item->year }}
                            </span>
                            @endif
                        </div>
                        <h4 class="text-base sm:text-lg font-bold text-[#0F172A] line-clamp-2 leading-snug">
                            {{ $item->title }}
                        </h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection