{{-- =========================================================
     ARCHITECTURE & CONSTRUCTION FOOTER (COMPACT STUDIO)
     resources/views/components/footer.blade.php
     ========================================================= --}}

<footer
    class="relative text-slate-100 border-t border-[#0f2347] select-none overflow-hidden"
    style="background-color: #0e2e60 !important;">

    {{-- Dải line đỏ điểm nhấn thương hiệu Tân Minh Nhân --}}
    <div class="h-0.5 w-full bg-gradient-to-r from-red-600 via-red-500 to-red-700"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-10 pt-10 pb-8">

        {{-- KHỐI 1: THƯƠNG HIỆU & ĐỊNH VỊ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-8 border-b border-white/10">
            <div>
                {{-- Logo chữ: TÂN MINH NHÂN kèm CORPORATION chính giữa bên dưới --}}
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center mb-2">
                    <span class="text-xl sm:text-2xl font-extrabold tracking-[0.16em] text-white group-hover:text-red-400 transition-colors uppercase block">
                        TÂN MINH NHÂN
                    </span>
                    <span class="text-[9px] font-bold tracking-[0.45em] text-red-500 uppercase block text-center w-full mt-0.5">
                        CORPORATION
                    </span>
                </a>
            </div>

            <p class="text-xs text-slate-300 font-normal leading-relaxed max-w-xl md:text-right">
                Định hình tiêu chuẩn thi công chuẩn xác, tiên phong đổi mới công nghệ và kiến tạo những công trình biểu tượng bền vững theo thời gian.
            </p>
        </div>

        {{-- KHỐI 2: LƯỚI THÔNG TIN CHÍNH --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-0 py-8 border-b border-white/10 text-xs">

            {{-- CỘT 1: TRỤ SỞ & LIÊN HỆ (5 CỘT) --}}
            <div class="lg:col-span-5 lg:pr-8 lg:border-r border-white/10 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1.5 mb-3">
                        <p class="text-[11px] font-bold tracking-widest text-slate-200 uppercase ">Trụ sở & Mạng lưới</p>
                    </div>

                    <div class="space-y-3 text-slate-300 font-normal">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 block mb-0.5 font-semibold">Văn phòng chính</span>
                            <p class="text-slate-200 leading-relaxed">
                                246-250 Lê Văn Hiến, phường Ngũ Hành Sơn, TP. Đà Nẵng, Việt Nam
                            </p>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 block mb-0.5 font-semibold">Khu vực dự án</span>
                            <p class="text-white font-medium">
                                Cả Nước
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Hotline & Email --}}
                <div class="grid grid-cols-2 gap-3 mt-5 pt-4 border-t border-white/10">
                    <div class="bg-black/20 hover:bg-black/30 p-2.5 border border-white/10 rounded-sm transition-colors">
                        <span class="text-[9px] uppercase tracking-wider text-slate-400 block font-semibold">Hotline</span>
                        <a href="tel:{{ config('site.phone') }}" class="text-xs font-semibold text-white hover:text-red-400 transition-colors mt-0.5 block">
                            (0236) 3 958718
                        </a>
                    </div>
                    <div class="bg-black/20 hover:bg-black/30 p-2.5 border border-white/10 rounded-sm transition-colors">
                        <span class="text-[9px] uppercase tracking-wider text-slate-400 block font-semibold">Email</span>
                        <a href="mailto:{{ config('site.email') }}" class="text-xs font-semibold text-white hover:text-red-400 transition-colors mt-0.5 block truncate">
                            contact@tanminhnhan.com.vn
                        </a>
                    </div>
                </div>
            </div>

            {{-- CỘT 2: ĐIỀU HƯỚNG NHANH (3 CỘT) --}}
            <div class="lg:col-span-3 lg:px-8 lg:border-r border-white/10">
                <div class="flex items-center gap-1.5 mb-3">
                    <p class="text-[11px] font-bold tracking-widest text-slate-200 uppercase">Liên kết nhanh</p>
                </div>

                <ul class="space-y-2.5 text-[11px] font-medium uppercase tracking-wider text-slate-300">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Giới thiệu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Dự án
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('careers.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Tuyển dụng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Tin tức
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Liên hệ
                        </a>
                    </li>
                </ul>
            </div>

            {{-- CỘT 3: KÊNH TRUYỀN THÔNG (4 CỘT) --}}
            <div class="lg:col-span-4 lg:pl-8">
                <div class="flex items-center gap-1.5 mb-3">
                    <p class="text-[11px] font-bold tracking-widest text-slate-200 uppercase">Kênh truyền thông</p>
                </div>

                <p class="text-[11px] text-slate-300 leading-relaxed font-normal mb-3.5">
                    Theo dõi video hiện trường, công trình và văn hóa doanh nghiệp mới nhất:
                </p>

                <div class="space-y-2">
                    {{-- Facebook --}}
                    <a
                        href="https://www.facebook.com/tanminhnhan.corp/"
                        target="_blank"
                        rel="noreferrer"
                        class="group flex items-center justify-between p-2 bg-black/20 hover:bg-black/30 border border-white/10 hover:border-white/20 transition-all duration-200">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/20 text-blue-300 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="h-3 w-3 fill-current" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-200 group-hover:text-white transition-colors">
                                Facebook Fanpage
                            </span>
                        </div>
                        <span class="text-slate-400 group-hover:text-white transition-transform duration-200 group-hover:translate-x-0.5 text-xs">↗</span>
                    </a>


                    {{-- YouTube --}}
                    <a
                        href="https://www.youtube.com/@T%C3%A2nMinhNh%C3%A2n"
                        target="_blank"
                        rel="noreferrer"
                        class="group flex items-center justify-between p-2 bg-black/20 hover:bg-black/30 border border-white/10 hover:border-white/20 transition-all duration-200">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-600/20 text-red-400 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="h-3 w-3 fill-current" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-200 group-hover:text-white transition-colors">
                                YouTube Channel
                            </span>
                        </div>
                        <span class="text-slate-400 group-hover:text-white transition-transform duration-200 group-hover:translate-x-0.5 text-xs">↗</span>
                    </a>

                    {{-- web --}}
                    <a
                        href="https://www.tanminhnhan.com.vn/"
                        target="_blank"
                        rel="noreferrer"
                        class="group flex items-center justify-between p-2 bg-black/20 hover:bg-black/30 border border-white/10 hover:border-white/20 transition-all duration-200">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-300 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.5 3a17 17 0 000 18M12.5 3a17 17 0 010 18" />
                                </svg>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-200 group-hover:text-white transition-colors">
                                Website Chính Thức
                            </span>
                        </div>
                        <span class="text-slate-400 group-hover:text-white transition-transform duration-200 group-hover:translate-x-0.5 text-xs">↗</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- KHỐI 3: BẢN QUYỀN & TIÊU CHUẨN --}}
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400">
            <p>© {{ date('Y') }} Tân Minh Nhân Corporation. Tất cả quyền được bảo lưu.</p>

            <div class="flex items-center gap-4 text-[10px]">
                <a href="#" class="hover:text-white transition-colors">Bảo mật</a>
                <span class="text-white/20">/</span>
                <a href="#" class="hover:text-white transition-colors">Điều khoản</a>
                <span class="text-white/20">/</span>
                <span class="font-semibold text-red-400">ISO 9001:2015</span>
            </div>
        </div>

    </div>
</footer>