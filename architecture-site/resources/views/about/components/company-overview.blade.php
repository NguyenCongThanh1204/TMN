{{-- =========================================================
     ABOUT - TAB 1: TỔNG QUAN CÔNG TY (BALANCED ACCENTS)
     resources/views/about/components/company-overview.blade.php
========================================================= --}}

<div class="w-full bg-white text-slate-900 py-8 sm:py-12 select-none">
    {{-- KHUNG CHỨA NỚI RỘNG CHUẨN 1440PX --}}
    <div class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12">

        {{-- HEADER TIÊU ĐỀ COMPONENT --}}
        <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-16">
            <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#EB323A] bg-red-50 border border-red-200/70 px-4.5 py-1.5 rounded-full inline-block mb-3 shadow-xs">
                Hồ sơ năng lực & Phát triển
            </span>
            {{-- ĐIỂM NHẤN: Tiêu đề chính mang màu xanh Navy chủ đạo --}}
            <p class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight uppercase leading-snug text-[#264abc]">
                Tổng Quan Công Ty
            </p>
            <div class="w-20 h-1.5 bg-[#EB323A] mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="w-full space-y-16 sm:space-y-20">

            {{-- 🎯 MỤC 1: GIỚI THIỆU CÔNG TY (FULL BACKGROUND & DIAGONAL PLACEMENT) --}}
            <section class="relative w-full overflow-hidden bg-slate-900 select-none">
    {{-- 1. ẢNH NỀN HIỂN THỊ ĐẦY ĐỦ 100% KHÔNG BỊ CROP --}}
    <div class="relative w-full">
        <img
            src="/images/background.jpg"
            alt="Tân Minh Nhân Background"
            class="w-full h-auto block object-contain"
            loading="lazy"
        />

        {{-- Lớp phủ gradient nhẹ chỉ ở góc chữ để tăng độ tương phản mà không che mất toà nhà bên phải --}}
        <div class="absolute inset-0 bg-gradient-to-r from-white/90 via-white/40 to-transparent w-full md:w-3/5 pointer-events-none"></div>

        {{-- 2. KHỐI NỘI DUNG NẰM ĐÈ CHUẨN TỌA ĐỘ THEO TỶ LỆ ẢNH --}}
        <div class="absolute inset-0 z-10 mx-auto max-w-[1440px] px-6 md:px-12 pointer-events-none">
            
            {{-- KHỐI GIỚI THIỆU: Góc trên bên trái --}}
            <div class="absolute top-[8%] left-6 md:left-12 max-w-[90%] sm:max-w-md lg:max-w-xl space-y-3 lg:space-y-4 pointer-events-auto">
                {{-- Badge tiêu đề --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-xs text-slate-800 text-xs sm:text-sm font-bold uppercase tracking-wider border border-slate-200 shadow-sm">
                    <svg class="w-4 h-4 text-[#EB323A] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    <span>Về Chúng Tôi</span>
                </div>

                {{-- Đoạn văn giới thiệu --}}
                <p class="text-slate-800 text-xs sm:text-sm md:text-base lg:text-lg leading-relaxed font-medium">
                    Chính thức đi vào hoạt động từ ngày 28/11/2011, qua chặng đường phát triển vững chắc, Tân Minh Nhân đã khẳng định vị thế là một trong những nhà thầu thi công kiến trúc, hoàn thiện và xây dựng uy tín hàng đầu, quy tụ đội ngũ nhân sự chất lượng cao luôn sẵn sàng cống hiến những giá trị tối ưu cho cộng đồng và xã hội.
                </p>
            </div>

            {{-- KHỐI PHƯƠNG CHÂM: Canh chỉnh theo đường chéo dưới --}}
            <div class="absolute bottom-[8%] sm:bottom-[10%] left-6 sm:left-[22%] lg:left-[30%] -translate-x-[50px] max-w-none z-20 space-y-1 pointer-events-auto">
                <span class="text-[10px] sm:text-xs lg:text-sm font-bold uppercase tracking-widest text-[#EB323A] block drop-shadow-xs">
                    Phương Châm Hoạt Động
                </span>
                <p class="text-slate-900 text-xs sm:text-base md:text-lg lg:text-xl font-black italic tracking-wide whitespace-nowrap drop-shadow-sm">
                    "Tuổi trẻ – Năng động – Sáng tạo – Hiệu quả"
                </p>
            </div>

        </div>
    </div>
</section>
            {{-- 🎯 MỤC 2: MỤC TIÊU PHÁT TRIỂN --}}
            <section class="w-full bg-slate-50 border border-slate-200/90 p-6 sm:p-10 rounded-2xl shadow-xs">
                <div class="max-w-3xl mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-slate-700 text-xs font-semibold uppercase tracking-wider mb-3 border border-slate-200 shadow-xs">
                        <svg class="w-4 h-4 text-[#EB323A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <circle cx="12" cy="12" r="6" />
                            <circle cx="12" cy="12" r="2" />
                        </svg>
                        <span>Định Hướng Chiến Lược</span>
                    </div>

                    {{-- ĐIỂM NHẤN: Tiêu đề danh mục mục tiêu chuyển xanh Navy --}}
                    <p class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#264abc]">
                        Mục Tiêu Phát Triển
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all duration-300 group">
                        {{-- ĐIỂM NHẤN: Số thứ tự nổi bật màu đỏ --}}
                        <!-- <span class="text-[#EB323A] font-mono text-lg font-extrabold block mb-1.5">01</span> -->
                        <p class="font-bold text-base sm:text-lg mb-2 text-slate-900 group-hover:text-[#264abc] transition-colors">Nhà Thầu Hàng Đầu</p>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Bứt phá trở thành đối tác chiến lược hàng đầu được ưu tiên lựa chọn bởi các chủ đầu tư quy mô lớn trong và ngoài nước.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all duration-300 group">
                        <!-- <span class="text-[#EB323A] font-mono text-lg font-extrabold block mb-1.5">02</span> -->
                        <p class="font-bold text-base sm:text-lg mb-2 text-slate-900 group-hover:text-[#264abc] transition-colors">Chuyển Đổi Số</p>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Tiên phong ứng dụng các giải pháp phần mềm quản lý thi công tiên tiến, chuyển đổi số toàn diện trong giám sát dự án.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all duration-300 group">
                        <!-- <span class="text-[#EB323A] font-mono text-lg font-extrabold block mb-1.5">03</span> -->
                        <p class="font-bold text-base sm:text-lg mb-2 text-slate-900 group-hover:text-[#264abc] transition-colors">Tối Ưu Nguồn Lực</p>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Phát triển nguồn nhân lực 900+ nhân sự tinh nhuệ, liên tục đào tạo chuyên môn cao cấp cho đội ngũ kỹ sư.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all duration-300 group">
                        <!-- <span class="text-[#EB323A] font-mono text-lg font-extrabold block mb-1.5">04</span> -->
                        <p class="font-bold text-base sm:text-lg mb-2 text-slate-900 group-hover:text-[#264abc] transition-colors">Mở Rộng Thị Trường</p>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Đẩy mạnh triển khai các dự án trọng điểm toàn quốc và từng bước vươn tầm ra khu vực.
                        </p>
                    </div>
                </div>
            </section>

            {{-- 🎯 MỤC 3: CAM KẾT HÀNH ĐỘNG --}}
            <section class="w-full">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-semibold uppercase tracking-wider mb-3 border border-slate-200">
                        <svg class="w-4 h-4 text-[#EB323A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <span>Trách Nhiệm & Giá Trị</span>
                    </div>

                    {{-- ĐIỂM NHẤN: Tiêu đề cam kết hành động màu xanh Navy --}}
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-[#264abc]">
                        Cam Kết Hành Động
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-[#EB323A] border border-red-100 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <circle cx="12" cy="8" r="6" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-base text-slate-900 mb-2 group-hover:text-[#264abc] transition-colors">Chất Lượng Kỹ - Mỹ Thuật</h4>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Đảm bảo tuyệt đối các tiêu chuẩn kỹ thuật theo bản vẽ phê duyệt, không đánh đổi chất lượng vì bất kỳ lý do gì.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#264abc] border border-blue-100 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-base text-slate-900 mb-2 group-hover:text-[#264abc] transition-colors">Tiến Độ Chuẩn Xác</h4>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Quản lý và điều phối tiến độ nghiêm ngặt, đảm bảo bàn giao công trình đúng hoặc trước thời hạn cam kết.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-[#EB323A] border border-red-100 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-base text-slate-900 mb-2 group-hover:text-[#264abc] transition-colors">An Toàn Tuyệt Đối</h4>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Khẩu hiệu "An toàn để sản xuất - Sản xuất phải an toàn", tuân thủ nghiêm ngặt an toàn vệ sinh lao động.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-xs hover:border-[#264abc] hover:shadow-md transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#264abc] border border-blue-100 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-base text-slate-900 mb-2 group-hover:text-[#264abc] transition-colors">Đồng Hành Dài Lâu</h4>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            Cung cấp dịch vụ bảo hành, bảo trì chu đáo, tận tâm và nhanh chóng sau khi dự án đi vào vận hành.
                        </p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>