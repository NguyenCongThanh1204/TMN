@extends('layouts.app')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;

    // Bộ ảnh công trường & kỹ sư dự phòng chất lượng cao
    $jobFallbackImages = [
        'https://images.unsplash.com/photo-1541888946425-d0fbb1861593?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1517581177682-a085bb7ffb15?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1590274853856-f22d5ee3d228?q=80&w=600&auto=format&fit=crop'
    ];

    // Helper giải quyết đường dẫn ảnh an toàn
    $resolveCareerImage = function ($career, $index) use ($jobFallbackImages) {
        if (!empty($career->cover_url)) {
            return $career->cover_url;
        }

        $rawPath = $career->cover_image ?? ($career->image ?? null);
        if (!empty($rawPath)) {
            if (str_starts_with($rawPath, 'http://') || str_starts_with($rawPath, 'https://')) {
                return $rawPath;
            }
            return Storage::disk('cloudinary')->url(ltrim($rawPath, '/'));
        }

        return $jobFallbackImages[$index % count($jobFallbackImages)];
    };
@endphp

<div class="bg-white text-slate-800 select-none font-sans">

    {{-- =========================================================
         1. HERO SECTION
         ========================================================= --}}
    <section 
        class="relative w-full min-h-[500px] sm:min-h-[560px] bg-slate-900 text-white flex items-center overflow-hidden"
        x-data="{
            current: 0,
            slides: [
                {
                    title: 'KIẾN TẠO BIỂU TƯỢNG',
                    sub: 'CÙNG TÂN MINH NHÂN',
                    desc: 'Môi trường làm việc chuẩn mực, chế độ đãi ngộ xứng tầm và lộ trình sự nghiệp vững chắc cho các kỹ sư tài năng.',
                    image: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1920&auto=format&fit=crop'
                },
                {
                    title: 'BỨT PHÁ BẢN THÂN',
                    sub: 'CHINH PHỤC CÔNG TRÌNH',
                    desc: 'Trực tiếp đồng hành xây dựng các dự án nghỉ dưỡng, khách sạn 5 sao và hạ tầng quy mô lớn trên toàn quốc.',
                    image: 'https://images.unsplash.com/photo-1541888946425-d0fbb1861593?q=80&w=1920&auto=format&fit=crop'
                },
                {
                    title: 'ĐÃI NGỘ XỨNG ĐÁNG',
                    sub: 'GẮN KẾT BỀN VỮNG',
                    desc: 'Chính sách công tác xa minh bạch, phụ cấp chu đáo và thưởng quyết toán dự án rõ ràng cho đội ngũ cán bộ.',
                    image: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=1920&auto=format&fit=crop'
                }
            ],
            timer: null,
            start() {
                this.timer = setInterval(() => {
                    this.current = (this.current + 1) % this.slides.length;
                }, 5000);
            },
            goTo(index) {
                this.current = index;
                clearInterval(this.timer);
                this.start();
            }
        }"
        x-init="start()"
    >
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out pointer-events-none"
                :class="current === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
            >
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover brightness-90 filter" />
            </div>
        </template>

        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-transparent z-10 pointer-events-none"></div>

        <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12 relative z-20 py-12 w-full">
            <div class="max-w-3xl space-y-5">
                
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-mono tracking-widest text-[#EB323A] shadow-md">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#EB323A]"></span>
                    <span>THÔNG BÁO TUYỂN DỤNG 2026</span>
                </div>

                <div class="space-y-3 min-h-[160px] flex flex-col justify-center">
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black uppercase tracking-tight text-white leading-[1.1] drop-shadow-md">
                        <span x-text="slides[current].title"></span><br>
                        <span class="text-[#EB323A]" x-text="slides[current].sub"></span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-100 max-w-2xl leading-relaxed pt-1 drop-shadow-sm font-medium" x-text="slides[current].desc"></p>
                </div>

                <div class="pt-2">
                    <a 
                        href="#jobs-list" 
                        class="px-8 py-3.5 rounded-full bg-[#EB323A] hover:bg-red-700 text-white font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-300 shadow-xl shadow-red-600/30 inline-flex items-center gap-2 group cursor-pointer"
                    >
                        <span>Xem vị trí tuyển dụng</span>
                        <span class="transition-transform group-hover:translate-x-1 font-mono text-base">↓</span>
                    </a>
                </div>

            </div>
        </div>

        <div class="absolute bottom-6 right-6 sm:bottom-8 sm:right-12 z-20 flex items-center gap-2">
            <template x-for="(slide, index) in slides" :key="'dot-' + index">
                <button 
                    @click="goTo(index)" 
                    class="h-2.5 rounded-full transition-all duration-300 cursor-pointer shadow-sm"
                    :class="current === index ? 'w-10 bg-[#EB323A]' : 'w-2.5 bg-white/60 hover:bg-white'"
                ></button>
            </template>
        </div>
    </section>

    {{-- CONTAINER CHÍNH CHUẨN 1440PX --}}
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12 py-10 sm:py-12 space-y-12 sm:space-y-14">

        {{-- =========================================================
             2. VÌ SAO LỰA CHỌN CHÚNG TÔI ? (CHỮ IN ĐẬM SANG MÀU XANH #264abc)
             ========================================================= --}}
        <section class="border-b border-slate-200/80 pb-12 sm:pb-14">
            <div class="mb-7 space-y-2.5">
                <div class="flex items-center gap-2 font-mono text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                    CHÍNH SÁCH ĐÃI NGỘ & PHÁT TRIỂN
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight" style="color: #264abc !important;">
                    Vì Sao Lại Lựa Chọn Chúng Tôi ?
                </h2>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-5xl pt-1">
                    Gia nhập <strong class="font-bold" style="color: #264abc !important;">Tân Minh Nhân</strong> để cùng kiến tạo những công trình bền vững và phát triển sự nghiệp vững chắc. Chúng tôi mang đến môi trường làm việc chuyên nghiệp, cơ hội học hỏi từ các dự án thực tế, chế độ đãi ngộ cạnh tranh, phúc lợi đầy đủ và lộ trình phát triển rõ ràng. Mỗi thành viên đều được trân trọng, đồng hành và tạo điều kiện để phát huy tối đa năng lực.
                </p>
            </div>

            {{-- 6 Khối lợi ích: Chữ in đậm màu xanh #264abc --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- 1. Thu nhập --}}
                <div class="p-6 sm:p-7 rounded-sm border border-slate-200 bg-slate-50/70 hover:bg-white hover:border-[#264abc]/60 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-2.5 h-2.5 bg-[#EB323A]"></span>
                        <h3 class="font-bold text-lg sm:text-xl uppercase tracking-tight" style="color: #264abc !important;">Thu nhập cạnh tranh</h3>
                    </div>
                    <ul class="text-[15px] sm:text-base text-slate-600 space-y-2.5 list-disc list-inside leading-relaxed">
                        <li>Mức lương thỏa thuận theo đúng năng lực.</li>
                        <li>Thưởng lễ, Tết, thưởng dự án và thưởng quyết toán công trình.</li>
                    </ul>
                </div>

                {{-- 2. Công tác xa --}}
                <div class="p-6 sm:p-7 rounded-sm border border-slate-200 bg-slate-50/70 hover:bg-white hover:border-[#264abc]/60 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-2.5 h-2.5 bg-[#EB323A]"></span>
                        <h3 class="font-bold text-lg sm:text-xl uppercase tracking-tight" style="color: #264abc !important;">Chế độ công tác xa</h3>
                    </div>
                    <ul class="text-[15px] sm:text-base text-slate-600 space-y-2.5 list-disc list-inside leading-relaxed">
                        <li>Sau mỗi 40 ngày công tác xa, được nghỉ 04 ngày và hưởng nguyên lương.</li>
                        <li>Bố trí lịch nghỉ luân phiên linh hoạt, hỗ trợ tối đa việc thăm gia đình.</li>
                    </ul>
                </div>

                {{-- 3. Chính sách --}}
                <div class="p-6 sm:p-7 rounded-sm border border-slate-200 bg-slate-50/70 hover:bg-white hover:border-[#264abc]/60 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-2.5 h-2.5 bg-[#EB323A]"></span>
                        <h3 class="font-bold text-lg sm:text-xl uppercase tracking-tight" style="color: #264abc !important;">Chính sách hấp dẫn</h3>
                    </div>
                    <ul class="text-[15px] sm:text-base text-slate-600 space-y-2.5 list-disc list-inside leading-relaxed">
                        <li>Công ty đài thọ 100% vé máy bay khi đi công tác dự án.</li>
                        <li>Hỗ trợ phụ cấp từ 200.000 – 300.000 VNĐ/ngày tùy khu vực.</li>
                        <li>Hỗ trợ chỗ ở đầy đủ tiện nghi trong suốt thời gian công tác.</li>
                    </ul>
                </div>

                {{-- 4. Cơ hội phát triển --}}
                <div class="p-6 sm:p-7 rounded-sm border border-slate-200 bg-slate-50/70 hover:bg-white hover:border-[#264abc]/60 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-2.5 h-2.5 bg-[#EB323A]"></span>
                        <h3 class="font-bold text-lg sm:text-xl uppercase tracking-tight" style="color: #264abc !important;">Cơ hội phát triển</h3>
                    </div>
                    <ul class="text-[15px] sm:text-base text-slate-600 space-y-2.5 list-disc list-inside leading-relaxed">
                        <li>Được đào tạo bài bản, nâng cao nghiệp vụ kỹ thuật thực chiến.</li>
                        <li>Lộ trình phát triển nghề nghiệp rõ ràng, minh bạch.</li>
                        <li>Cơ hội trực tiếp tham gia các đại dự án quy mô lớn trên toàn quốc.</li>
                    </ul>
                </div>

                {{-- 5. Môi trường --}}
                <div class="p-6 sm:p-7 rounded-sm border border-slate-200 bg-slate-50/70 hover:bg-white hover:border-[#264abc]/60 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-2.5 h-2.5 bg-[#EB323A]"></span>
                        <h3 class="font-bold text-lg sm:text-xl uppercase tracking-tight" style="color: #264abc !important;">Môi trường chuyên nghiệp</h3>
                    </div>
                    <ul class="text-[15px] sm:text-base text-slate-600 space-y-2.5 list-disc list-inside leading-relaxed">
                        <li>Đồng nghiệp thân thiện, gắn kết và sẵn sàng hỗ trợ.</li>
                        <li>Văn hóa làm việc kỷ luật, tôn trọng và đề cao tinh thần trách nhiệm.</li>
                        <li>Luôn đặt an toàn lao động và chất lượng công trình lên hàng đầu.</li>
                    </ul>
                </div>

                {{-- 6. Phúc lợi --}}
                <div class="p-6 sm:p-7 rounded-sm border border-slate-200 bg-slate-50/70 hover:bg-white hover:border-[#264abc]/60 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-2.5 h-2.5 bg-[#EB323A]"></span>
                        <h3 class="font-bold text-lg sm:text-xl uppercase tracking-tight" style="color: #264abc !important;">Chế độ phúc lợi đầy đủ</h3>
                    </div>
                    <ul class="text-[15px] sm:text-base text-slate-600 space-y-2.5 list-disc list-inside leading-relaxed">
                        <li>Tham gia đầy đủ BHXH, BHYT, BHTN theo quy định pháp luật.</li>
                        <li>Hỗ trợ chi phí điện thoại và trang bị đầy đủ bảo hộ đạt chuẩn.</li>
                    </ul>
                </div>

            </div>
        </section>


        {{-- =========================================================
             3. CƠ HỘI VIỆC LÀM: SÁT LẠI VỚI NHAU & HOVER CHUYỂN ĐỎ
             ========================================================= --}}
        <section id="jobs-list" class="scroll-mt-16">
            
            <div class="flex items-center gap-3 mb-6">
                <span class="h-1 w-8 bg-[#EB323A]"></span>
                <h2 class="text-2xl sm:text-4xl font-black uppercase tracking-wide" style="color: #264abc !important;">
                    CƠ HỘI VIỆC LÀM
                </h2>
            </div>

            @if(isset($careers) && $careers->isNotEmpty())
                {{-- THU GỌN KHOẢNG CÁCH SÁT LẠI: gap-x-6 gap-y-6 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                    @foreach($careers as $index => $career)
                        @php
                            $jobImg = $resolveCareerImage($career, $index);
                        @endphp

                        {{-- TỪNG Ô CÔNG VIỆC: HOVER VIỀN TRÊN CHUYỂN ĐỎ --}}
                        <div class="border-t-2 border-slate-300 hover:border-[#EB323A] pt-4 flex items-start gap-4 group transition-colors duration-300 cursor-pointer">
                            
                            {{-- ẢNH VUÔNG BÊN TRÁI --}}
                            <div class="w-28 h-28 sm:w-32 sm:h-32 shrink-0 overflow-hidden bg-slate-100 rounded-sm border border-slate-200/80 group-hover:border-[#EB323A]/50 relative shadow-xs transition-colors duration-300">
                                <a href="{{ route('careers.show', $career->id) }}" class="block w-full h-full">
                                    <img
                                        src="{{ $jobImg }}"
                                        alt="{{ $career->job_title }}"
                                        class="w-full h-full aspect-square object-cover object-center transition-transform duration-500 ease-out group-hover:scale-105"
                                        loading="eager"
                                    />
                                </a>
                            </div>

                            {{-- NỘI DUNG BÊN PHẢI: MÀU XANH -> HOVER ĐỔI SANG ĐỎ --}}
                            <div class="flex-1 min-w-0 flex flex-col justify-between min-h-[112px] sm:min-h-[128px]">
                                
                                <div class="space-y-1.5">
                                    {{-- Tên vị trí: XANH -> HOVER CHUYỂN ĐỎ --}}
                                    <h3 class="text-base sm:text-lg font-bold leading-snug line-clamp-2 transition-colors duration-300">
                                        <a 
                                            href="{{ route('careers.show', $career->id) }}"
                                            class="block group-hover:!text-[#EB323A] transition-colors duration-200"
                                            style="color: #264abc;"
                                        >
                                            {{ $career->job_title }}
                                        </a>
                                    </h3>

                                    {{-- Hạn nộp --}}
                                    <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 font-medium">
                                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#EB323A] transition-colors shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>
                                            {{ $career->deadline ? $career->deadline->format('d/m/Y') : 'Tuyển liên tục' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Link xem chi tiết: HOVER CHUYỂN ĐỎ & DỊCH CHUYỂN MŨI TÊN --}}
                                <div class="pt-1.5">
                                    <a
                                        href="{{ route('careers.show', $career->id) }}"
                                        class="text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1 group-hover:!text-[#EB323A] transition-colors duration-200"
                                        style="color: #000;"
                                    >
                                        <span>Xem chi tiết</span>
                                        <span class="font-mono text-sm group-hover:translate-x-1 transition-transform">→</span>
                                    </a>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 border border-dashed border-slate-300 rounded-sm bg-slate-50">
                    <p class="text-base text-slate-600 font-medium">Hiện tại công ty đã tuyển đủ nhân sự. Các đợt tuyển dụng mới sẽ sớm được cập nhật!</p>
                </div>
            @endif

        </section>


        {{-- =========================================================
             4. HỒ SƠ ỨNG TUYỂN & NƠI NHẬN HỒ SƠ (CHỮ IN ĐẬM MÀU XANH)
             ========================================================= --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 pt-6 border-t border-slate-200/80">
            
            {{-- Cột Trái: Hồ sơ ứng tuyển (Accordion) --}}
            <div class="lg:col-span-6" x-data="{ openItem: 1 }">
                <div class="border-b-2 border-[#EB323A] pb-2 mb-5 inline-block">
                    <h3 class="text-xl sm:text-2xl font-extrabold uppercase" style="color: #264abc !important;">
                        Hồ sơ ứng tuyển
                    </h3>
                </div>

                <div class="divide-y divide-slate-200 border-y border-slate-200 text-base">
                    
                    {{-- Mục 1: Thông tin ứng viên --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 1 ? null : 1)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Thông tin ứng viên</span>
                            </span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform" :class="openItem === 1 ? 'rotate-180 text-[#EB323A]' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openItem === 1" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            Theo mẫu của công ty (<a href="NS-TD01-2020-thong-tin-ung-vien-v5.doc" class="text-[#EB323A] hover:underline font-semibold">tải tại đây</a>)
                        </div>
                    </div>

                    {{-- Mục 2: Sơ yếu lý lịch --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 2 ? null : 2)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Sơ yếu lý lịch</span>
                            </span>
                            <span class="text-slate-400 font-mono text-base">›</span>
                        </button>
                        <div x-show="openItem === 2" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            Bản sơ yếu lý lịch có xác nhận của chính quyền địa phương trong vòng 6 tháng gần nhất.
                        </div>
                    </div>

                    {{-- Mục 3: Đơn xin việc --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 3 ? null : 3)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Đơn xin việc</span>
                            </span>
                            <span class="text-slate-400 font-mono text-base">›</span>
                        </button>
                        <div x-show="openItem === 3" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            Đơn xin việc nêu rõ kinh nghiệm công tác và vị trí ứng tuyển.
                        </div>
                    </div>

                    {{-- Mục 4: Văn bằng --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 4 ? null : 4)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a10.912 10.912 0 01.352 1.897L2.4 12.2A1 1 0 003 13.6h14a1 1 0 00.6-1.4l-3.202-2.252a10.92 10.92 0 01.352-1.897l2.644-1.131a1 1 0 000-1.84l-7-3zM3.31 16.03a1 1 0 00-.31.72V18a1 1 0 001 1h12a1 1 0 001-1v-1.25a1 1 0 00-.31-.72l-2.022-1.618a12.91 12.91 0 01-8.336 0L3.31 16.03z"></path>
                                </svg>
                                <span>Văn bằng chứng chỉ</span>
                            </span>
                            <span class="text-slate-400 font-mono text-base">›</span>
                        </button>
                        <div x-show="openItem === 4" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            Bản sao bằng tốt nghiệp đại học/cao đẳng và các chứng chỉ liên quan.
                        </div>
                    </div>

                    {{-- Mục 5: Chứng minh nhân dân --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 5 ? null : 5)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Chứng minh nhân dân / CCCD</span>
                            </span>
                            <span class="text-slate-400 font-mono text-base">›</span>
                        </button>
                        <div x-show="openItem === 5" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            Bản sao công chứng CCCD gắn chip.
                        </div>
                    </div>

                    {{-- Mục 6: Ảnh thẻ --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 6 ? null : 6)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Ảnh thẻ</span>
                            </span>
                            <span class="text-slate-400 font-mono text-base">›</span>
                        </button>
                        <div x-show="openItem === 6" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            02 ảnh 3x4 chụp trong vòng 6 tháng gần nhất.
                        </div>
                    </div>

                    {{-- Mục 7: Giấy khám sức khỏe --}}
                    <div class="py-3">
                        <button
                            type="button"
                            @click="openItem = (openItem === 7 ? null : 7)"
                            class="w-full flex items-center justify-between text-left font-bold focus:outline-none cursor-pointer hover:text-[#EB323A] transition-colors"
                            style="color: #264abc;"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Giấy chứng nhận sức khỏe</span>
                            </span>
                            <span class="text-slate-400 font-mono text-base">›</span>
                        </button>
                        <div x-show="openItem === 7" x-collapse class="pt-2 pl-8 text-slate-600 text-sm sm:text-base leading-relaxed">
                            Giấy khám sức khỏe từ bệnh viện tuyến quận/huyện trở lên cấp trong 6 tháng gần nhất.
                        </div>
                    </div>

                </div>
            </div>

            {{-- Cột Phải: Nơi nhận hồ sơ & Google Maps --}}
            <div class="lg:col-span-6 space-y-3.5">
                <div class="border-b-2 border-[#EB323A] pb-2 mb-5 inline-block">
                    <h3 class="text-xl sm:text-2xl font-extrabold uppercase" style="color: #264abc !important;">
                        Nơi nhận hồ sơ
                    </h3>
                </div>

                <div class="space-y-2.5 text-base text-slate-700 leading-relaxed bg-white p-5 rounded-sm border border-slate-200 shadow-xs">
                    <p class="flex items-center gap-3">
                        <span class="font-bold min-w-[95px]" style="color: #264abc !important;">Email:</span>
                        <a href="mailto:contact@tanminhnhan.com.vn" class="text-slate-800 hover:text-[#EB323A] font-semibold">contact@tanminhnhan.com.vn</a>
                    </p>

                    <p class="flex items-center gap-3">
                        <span class="font-bold min-w-[95px]" style="color: #264abc !important;">Điện thoại:</span>
                        <a href="tel:(0236) 3 958718" class="text-slate-800 hover:text-[#EB323A] font-semibold">(0236) 3 958718</a>
                    </p>

                    <p class="flex items-start gap-3">
                        <span class="font-bold min-w-[95px] shrink-0" style="color: #264abc !important;">Địa chỉ:</span>
                        <span>246-250 Lê Văn Hiến, Phường Khuê Mỹ, Quận Ngũ Hành Sơn, TP. Đà Nẵng, Việt Nam.</span>
                    </p>
                </div>

                <div class="w-full aspect-[16/10] rounded-sm overflow-hidden border border-slate-200 shadow-xs mt-2">
                    <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.6897623929062!2d108.24456827589188!3d16.02965744049452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142175af0706bff%3A0x185f7d5651d72061!2zQ8O0bmcgdHkgQ-G7lSBwaOG6p24gWMOieSBk4buxbmcgS2nhur9uIHRyw7pjIFTDom4gTWluaCBOaMOibg!5e0!3m2!1svi!2s!4v1784776803513!5m2!1svi!2s"
                        class="w-full h-full border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>

        </section>

    </div>
</div>
@endsection