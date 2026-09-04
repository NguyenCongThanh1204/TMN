{{-- =========================================================
     ARCHITECTURE & CONSTRUCTION FOOTER (COMPACT STUDIO)
     resources/views/components/footer.blade.php
     ========================================================= --}}

<footer class="relative bg-slate-900 text-slate-100 border-t border-slate-800 select-none overflow-hidden">

    {{-- Dải line đỏ điểm nhấn thương hiệu Tân Minh Nhân --}}
    <div class="h-0.5 w-full bg-gradient-to-r from-red-600 via-red-500 to-red-700"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-10 pt-10 pb-8">

        {{-- KHỐI 1: THƯƠNG HIỆU & ĐỊNH VỊ (THU NHỎ, GỌN GÀNG) --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-8 border-b border-slate-800">
            <div>
                {{-- Logo chữ: TÂN MINH NHÂN kèm CORPORATION chính giữa bên dưới --}}
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center mb-2">
                    <span class="text-xl sm:text-2xl font-extrabold tracking-[0.16em] text-white group-hover:text-red-500 transition-colors uppercase block">
                        TÂN MINH NHÂN
                    </span>
                    <span class="text-[9px] font-bold tracking-[0.45em] text-red-500 uppercase block text-center w-full mt-0.5">
                        CORPORATION
                    </span>
                </a>
            </div>

            <p class="text-xs text-slate-400 font-normal leading-relaxed max-w-xl md:text-right">
                Định hình tiêu chuẩn thi công chuẩn xác, tiên phong đổi mới công nghệ và kiến tạo những công trình biểu tượng bền vững theo thời gian.
            </p>
        </div>

        {{-- KHỐI 2: LƯỚI THÔNG TIN CHÍNH (3 CỘT GỌN GÀNG) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-0 py-8 border-b border-slate-800 text-xs">

            {{-- CỘT 1: TRỤ SỞ & LIÊN HỆ (5 CỘT) --}}
            <div class="lg:col-span-5 lg:pr-8 lg:border-r border-slate-800 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1.5 mb-3">
                        <!-- <span class="text-[11px] font-bold text-red-500">01.</span> -->
                        <h4 class="text-[11px] font-bold tracking-widest text-slate-300 uppercase">Trụ sở & Mạng lưới</h4>
                    </div>

                    <div class="space-y-3 text-slate-300 font-normal">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 block mb-0.5 font-semibold">Văn phòng chính</span>
                            <p class="text-slate-300 leading-relaxed">
                                246-250 Lê Văn Hiến, phường Ngũ Hành Sơn, TP. Đà Nẵng, Việt Nam
                            </p>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 block mb-0.5 font-semibold">Khu vực dự án</span>
                            <p class="text-slate-300 font-medium">
                                Đà Nẵng • Hà Nam • Vũng Tàu • Phú Quốc
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Hotline & Email thu nhỏ --}}
                <div class="grid grid-cols-2 gap-3 mt-5 pt-4 border-t border-slate-800/80">
                    <div class="bg-slate-800/40 p-2.5 border border-slate-800 rounded-sm">
                        <span class="text-[9px] uppercase tracking-wider text-slate-400 block font-semibold">Hotline</span>
                        <a href="tel:{{ config('site.phone') }}" class="text-xs font-semibold text-white hover:text-red-400 transition-colors mt-0.5 block">
                            (0236) 3 958718
                        </a>
                    </div>
                    <div class="bg-slate-800/40 p-2.5 border border-slate-800 rounded-sm">
                        <span class="text-[9px] uppercase tracking-wider text-slate-400 block font-semibold">Email</span>
                        <a href="mailto:{{ config('site.email') }}" class="text-xs font-semibold text-white hover:text-red-400 transition-colors mt-0.5 block truncate">
                            contact@tanminhnhan.com.vn
                        </a>
                    </div>
                </div>
            </div>

            {{-- CỘT 2: ĐIỀU HƯỚNG NHANH (3 CỘT) --}}
            <div class="lg:col-span-3 lg:px-8 lg:border-r border-slate-800">
                <div class="flex items-center gap-1.5 mb-3">
                    <!-- <span class="text-[11px] font-bold text-red-500">02.</span> -->
                    <h4 class="text-[11px] font-bold tracking-widest text-slate-300 uppercase">Liên kết nhanh</h4>
                </div>

                <ul class="space-y-2.5 text-[11px] font-medium uppercase tracking-wider text-slate-400">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Về chúng tôi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Dự án tiêu biểu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Tin tức & Hoạt động
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1.5 group">
                            <span class="h-1 w-1 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            Liên hệ hợp tác
                        </a>
                    </li>
                </ul>
            </div>

            {{-- CỘT 3: KÊNH TRUYỀN THÔNG (4 CỘT) --}}
            <div class="lg:col-span-4 lg:pl-8">
                <div class="flex items-center gap-1.5 mb-3">
                    <!-- <span class="text-[11px] font-bold text-red-500">03.</span> -->
                    <h4 class="text-[11px] font-bold tracking-widest text-slate-300 uppercase">Kênh truyền thông</h4>
                </div>

                <p class="text-[11px] text-slate-400 leading-relaxed font-normal mb-3.5">
                    Theo dõi video hiện trường, công trình và văn hóa doanh nghiệp mới nhất:
                </p>

                <div class="space-y-2">
                    {{-- Facebook --}}
                    <a
                        href="https://www.facebook.com/tanminhnhan.corp/"
                        target="_blank"
                        rel="noreferrer"
                        class="group flex items-center justify-between p-2 bg-slate-800/30 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 transition-all duration-200"
                    >
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600/20 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="h-3 w-3 fill-current" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-300 group-hover:text-white transition-colors">
                                Facebook Fanpage
                            </span>
                        </div>
                        <span class="text-slate-500 group-hover:text-white transition-transform duration-200 group-hover:translate-x-0.5 text-xs">↗</span>
                    </a>

                    {{-- LinkedIn --}}
                    <a
                        href="https://linkedin.com"
                        target="_blank"
                        rel="noreferrer"
                        class="group flex items-center justify-between p-2 bg-slate-800/30 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 transition-all duration-200"
                    >
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-sky-600/20 text-sky-400 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                                <svg class="h-3 w-3 fill-current" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.762-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-300 group-hover:text-white transition-colors">
                                LinkedIn Network
                            </span>
                        </div>
                        <span class="text-slate-500 group-hover:text-white transition-transform duration-200 group-hover:translate-x-0.5 text-xs">↗</span>
                    </a>

                    {{-- YouTube --}}
                    <a
                        href="https://www.youtube.com/@T%C3%A2nMinhNh%C3%A2n"
                        target="_blank"
                        rel="noreferrer"
                        class="group flex items-center justify-between p-2 bg-slate-800/30 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 transition-all duration-200"
                    >
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-600/20 text-red-400 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="h-3 w-3 fill-current" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </span>
                            <span class="text-[11px] font-semibold text-slate-300 group-hover:text-white transition-colors">
                                YouTube Channel
                            </span>
                        </div>
                        <span class="text-slate-500 group-hover:text-white transition-transform duration-200 group-hover:translate-x-0.5 text-xs">↗</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- KHỐI 3: BẢN QUYỀN & TIÊU CHUẨN --}}
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400">
            <p>© {{ date('Y') }} Tân Minh Nhân Corporation. Tất cả quyền được bảo lưu.</p>

            <div class="flex items-center gap-4 text-[10px]">
                <a href="#" class="hover:text-slate-300 transition-colors">Bảo mật</a>
                <span class="text-slate-700">/</span>
                <a href="#" class="hover:text-slate-300 transition-colors">Điều khoản</a>
                <span class="text-slate-700">/</span>
                <span class="font-semibold text-red-500">ISO 9001:2015</span>
            </div>
        </div>

    </div>
</footer>