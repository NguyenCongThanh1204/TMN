@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-white pt-20 pb-20">
    {{-- Khung chứa bài viết 1050px --}}
    <div class="w-full max-w-[1050px] mx-auto px-4 sm:px-0">

        {{-- THANH TIÊU ĐỀ: MARGIN DƯỚI 50PX, TIÊU ĐỀ TO RÕ VÀ NÉT NHẸ NHÀNG --}}
        <div class="post-header-bar flex items-center gap-4 pb-4 mt-[50px] mb-[50px] border-b border-gray-200">
    {{-- 1. Icon menu vuông đỏ phóng to (Kích thước 34px, icon svg 20px) --}}
    <span 
        class="inline-flex items-center justify-center bg-[#d32f2f] rounded-[3px] shrink-0 shadow-sm"
        style="width: 34px !important; height: 34px !important; min-width: 34px !important; min-height: 34px !important;"
    >
        <svg 
            class="text-white" 
            style="width: 20px !important; height: 20px !important;" 
            viewBox="0 0 24 24" 
            fill="none" 
            stroke="currentColor" 
            stroke-width="2.3" 
            stroke-linecap="round" 
            stroke-linejoin="round"
        >
            <line x1="3.5" y1="6" x2="20.5" y2="6"></line>
            <line x1="3.5" y1="12" x2="20.5" y2="12"></line>
            <line x1="3.5" y1="18" x2="20.5" y2="18"></line>
        </svg>
    </span>

    {{-- 2. Tiêu đề phóng to rõ nét (32px), font nhẹ nhàng không in đậm (font-weight: 400) --}}
    <h1 
        class="post-main-title m-0 tracking-tight"
        style="font-size: 32px !important; font-weight: 400 !important; color: #222222 !important; line-height: 1.3 !important; font-family: Arial, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;"
    >
        {{ $post->title }}
    </h1>
</div>

        {{-- VÙNG NỘI DUNG NGUYÊN BẢN TỪ FILAMENT --}}
        <article id="article-content" class="raw-filament-content">
            @if($post->content)
                {!! $post->content !!}
            @else
                <p class="text-center text-gray-400 py-10 italic">Nội dung đang được cập nhật...</p>
            @endif
        </article>

    </div>
</div>

<style>
    /* Khoảng cách 50px từ cụm tiêu đề xuống nội dung bên dưới */
    .post-header-bar {
        margin-bottom: 50px !important;
    }

    /* 1. Tiêu đề chính: Cỡ to (28px - 30px), nét chữ nhẹ nhàng thanh thoát (font-weight: 300/400) */
    .post-main-title {
        font-family: Arial, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        font-size: 28px !important;       /* To rõ ràng, không bị chặn */
        font-weight: 300 !important;      /* Nét thanh nhẹ, loại bỏ hoàn toàn nét thô */
        color: #222222 !important;
        line-height: 1.35 !important;
        margin: 0 !important;
        letter-spacing: -0.01em !important;
    }

    @media (max-width: 640px) {
        .post-header-bar {
            margin-bottom: 30px !important;
        }
        .post-main-title {
            font-size: 22px !important;
        }
    }

    /* 2. Môi trường nội dung: Giữ nguyên tùy biến của bạn */
    .raw-filament-content {
        width: 100%;
        word-wrap: break-word;
        font-size: 15px;
        line-height: 1.7;
        color: #333333;
    }

    .raw-filament-content * {
        max-width: 100%;
    }

    /* Đoạn văn: Thoáng dòng, không bị ép gắt */
    .raw-filament-content p {
        margin-top: 0;
        margin-bottom: 1.2rem;
        line-height: 1.7;
    }

    /* Khung ảnh tối đa 900px, căn chính giữa */
    .raw-filament-content figure {
        margin: 1.75rem auto !important;
        display: table !important;
        text-align: center;
        max-width: 900px !important;
    }

    .raw-filament-content figure img,
    .raw-filament-content img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width: 900px !important;
        height: auto;
    }

    /* Chú thích chân ảnh (Caption) */
    .raw-filament-content figcaption {
        caption-side: bottom;
        display: table-caption;
        margin-top: 8px;
        margin-bottom: 14px;
        font-size: 13px;
        color: #555555;
        text-align: center;
        padding: 0 6px;
    }

    /* Bảng dữ liệu */
    .raw-filament-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }
</style>

@endsection