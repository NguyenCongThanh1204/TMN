@extends('layouts.app')

@section('content')
<div class="bg-white text-slate-800 py-12 sm:py-16 select-none font-sans">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Breadcrumb điều hướng quay lại --}}
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500">
            <a href="{{ route('careers.index') }}" class="hover:text-[#EB323A] transition-colors flex items-center gap-1">
                <span>←</span> Danh sách tuyển dụng
            </a>
            <span>/</span>
            <span class="text-slate-900 font-semibold">{{ $career->job_title }}</span>
        </nav>

        {{-- TIÊU ĐỀ CÔNG VIỆC CHÍNH --}}
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#EB323A] tracking-tight">
                {{ $career->job_title }}
            </h1>

            {{-- Thông số dưới tiêu đề --}}
            <div class="flex flex-wrap items-center gap-y-2 gap-x-6 mt-4 text-xs sm:text-sm text-slate-600 border-b border-slate-100 pb-6">
                @if($career->department)
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-medium">Phòng ban:</span>
                        <span class="font-semibold text-slate-800">{{ $career->department }}</span>
                    </div>
                @endif

                @if($career->location)
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-medium">Địa điểm:</span>
                        <span class="font-semibold text-slate-800">{{ $career->location }}</span>
                    </div>
                @endif

                @if($career->salary_range)
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-medium">Mức lương:</span>
                        <span class="font-semibold text-emerald-600">{{ $career->salary_range }}</span>
                    </div>
                @endif

                <div class="flex items-center gap-1.5">
                    <span class="text-slate-400 font-medium">Hạn nộp hồ sơ:</span>
                    <span class="font-semibold text-[#EB323A]">
                        {{ $career->deadline ? $career->deadline->format('d/m/Y') : 'Tuyển liên tục' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- =========================================================
             PARSER NỘI DUNG TỰ ĐỘNG TÁCH TIÊU ĐỀ & DANH SÁCH Ý
             ========================================================= --}}
        @php
            // Chuẩn hóa xuống dòng và tách thành từng dòng text
            $rawLines = explode("\n", str_replace(["\r\n", "\r"], "\n", (string)$career->description));

            // Danh sách từ khóa nhận diện là TIÊU ĐỀ MỤC LỚN
            $headingKeywords = [
                'mô tả công việc',
                'nhiệm vụ chính',
                'yêu cầu ứng viên',
                'yêu cầu công việc',
                'tiêu chuẩn ứng viên',
                'quyền lợi được hưởng',
                'chế độ đãi ngộ',
                'quyền lợi',
                'địa điểm làm việc',
                'thời gian làm việc',
                'hồ sơ bao gồm',
                'thông tin khác'
            ];

            $sections = [];
            $currentTitle = 'Mô tả công việc'; // Tiêu đề mặc định nếu dòng đầu không có header
            $currentItems = [];

            foreach ($rawLines as $line) {
                $cleanLine = trim($line);
                if ($cleanLine === '') continue;

                // Xóa các ký tự bullet đầu dòng nếu có để so khớp
                $textOnly = ltrim($cleanLine, "-*• \t\n\r\0\x0B");
                $lowerText = mb_strtolower($textOnly, 'UTF-8');

                // Kiểm tra xem dòng này có phải là Tiêu đề không
                $isHeader = false;
                foreach ($headingKeywords as $kw) {
                    if (str_starts_with($lowerText, $kw) || str_ends_with($lowerText, $kw)) {
                        $isHeader = true;
                        break;
                    }
                }

                if ($isHeader) {
                    // Lưu lại nhóm trước đó nếu có item
                    if (!empty($currentItems)) {
                        $sections[] = [
                            'title' => $currentTitle,
                            'items' => $currentItems,
                        ];
                        $currentItems = [];
                    }
                    // Cập nhật tiêu đề mới
                    $currentTitle = $textOnly;
                } else {
                    $currentItems[] = $textOnly;
                }
            }

            // Đẩy section cuối cùng vào danh sách
            if (!empty($currentItems) || !empty($currentTitle)) {
                $sections[] = [
                    'title' => $currentTitle,
                    'items' => $currentItems,
                ];
            }
        @endphp

        {{-- HIỂN THỊ TỪNG KHỐI TIÊU ĐỀ VÀ DANH SÁCH Ý TƯƠNG ỨNG --}}
        <div class="space-y-10">
            @foreach($sections as $sec)
                <section class="space-y-4">
                    {{-- Tiêu đề tự động bự ra, in đậm và có gạch đỏ phong cách thương hiệu --}}
                    <div class="border-b-2 border-[#EB323A] pb-2 inline-block">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                            {{ $sec['title'] }}
                        </h2>
                    </div>

                    {{-- Danh sách các ý con dạng chấm tròn chuẩn mực --}}
                    @if(!empty($sec['items']))
                        <ul class="list-disc pl-5 space-y-3 text-xs sm:text-sm text-slate-700 leading-relaxed">
                            @foreach($sec['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach
        </div>

        {{-- =========================================================
             NÚT ỨNG TUYỂN & THÔNG TIN LIÊN HỆ GỬI HỒ SƠ
             ========================================================= --}}
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-500">
                Gửi CV ứng tuyển trực tiếp qua email: 
                <a href="mailto:contact@tanminhnhan.com.vn" class="font-bold text-[#1E3A8A] hover:underline">
                    contact@tanminhnhan.com.vn
                </a>
            </div>

            <a
                href="mailto:contact@tanminhnhan.com.vn?subject=Ứng tuyển vị trí: {{ urlencode($career->job_title) }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#EB323A] hover:bg-red-700 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-sm cursor-pointer"
            >
                <span>Nộp hồ sơ ngay</span>
                <span class="font-mono">→</span>
            </a>
        </div>

    </div>
</div>
@endsection