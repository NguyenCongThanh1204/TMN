{{-- =========================================================
     ABOUT - TAB 3: CHÍNH SÁCH NHÂN SỰ (HR POLICY - ENLARGED & BLUE HEADINGS)
     resources/views/about/components/hr-policy.blade.php
========================================================= --}}

@php
    $policySections = [
        ['id' => 'moi-truong', 'title' => '1. Môi trường làm việc'],
        ['id' => 'chinh-sach-ld', 'title' => '2. Chính sách lao động'],
        ['id' => 'tien-luong', 'title' => '3. Tiền lương'],
        ['id' => 'bao-hiem', 'title' => '4. Bảo hiểm xã hội'],
        ['id' => 'dao-tao', 'title' => '5. Đào tạo'],
        ['id' => 'phuc-loi', 'title' => '6. Phụ cấp, Phúc lợi và đãi ngộ'],
    ];
@endphp

<div
    class="py-12 sm:py-16 bg-[#F8FAFC] text-[#0F172A] relative select-none rounded-xl px-6 sm:px-10 lg:px-12"
    x-data="{
        activeSection: 'moi-truong',
        isClickScrolling: false,
        sections: {{ json_encode(array_column($policySections, 'id')) }},

        init() {
            window.addEventListener('scroll', () => this.handleScroll(), { passive: true });
        },

        scrollToSection(id) {
            this.activeSection = id;
            this.isClickScrolling = true;

            const element = document.getElementById(id);
            if (element) {
                const yOffset = -120; // Khoảng bù trừ bên dưới Navbar & Sticky Tab
                const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });

                setTimeout(() => {
                    this.isClickScrolling = false;
                }, 650);
            }
        },

        handleScroll() {
            if (this.isClickScrolling) return;

            const scrollMarker = 140;
            let current = this.sections[0];

            for (let i = 0; i < this.sections.length; i++) {
                const id = this.sections[i];
                const el = document.getElementById(id);
                if (el) {
                    const top = el.getBoundingClientRect().top;
                    if (top <= scrollMarker) {
                        current = id;
                    } else {
                        break;
                    }
                }
            }
            this.activeSection = current;
        }
    }"
>

    {{-- Background Grid Pattern mờ nhẹ --}}
    <div
        class="absolute inset-0 opacity-[0.03] pointer-events-none rounded-xl"
        style="background-image: linear-gradient(to right, #000000 1px, transparent 1px), linear-gradient(to bottom, #000000 1px, transparent 1px); background-size: 32px 32px;"
    ></div>

    <div class="max-w-[1440px] mx-auto relative z-10">

        {{-- HEADER TỔNG QUAN --}}
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#EB323A] bg-red-50 px-4.5 py-1.5 rounded-full border border-red-200 inline-block mb-3 shadow-xs">
                Nguồn Lực Phát Triển
            </span>
            <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tight text-[#264abc]">
                Chính Sách <span class="text-[#EB323A]">Nhân Sự</span>
            </h2>
            <div class="w-16 h-1.5 bg-[#EB323A] mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- THÔNG ĐIỆP CỐT LÕI --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs mb-14 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-36 h-36 bg-red-500/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="flex items-start gap-6">
                <div class="p-3.5 bg-red-50 text-[#EB323A] rounded-xl border border-red-100 shrink-0 hidden sm:block">
                    {{-- Icon Users --}}
                    <svg class="w-7 h-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl md:text-2xl font-extrabold uppercase text-[#264abc] mb-3 flex items-center gap-2.5">
                        <span>Con người là chìa khóa của thành công</span>
                        {{-- Icon Sparkles --}}
                        <svg class="w-5 h-5 text-[#EB323A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                        </svg>
                    </p>
                    <p class="text-slate-700 text-base sm:text-lg leading-relaxed font-normal">
                        Nguồn nhân lực trong bộ máy công ty Tân Minh Nhân được xem là tài sản quý giá nhất. Do vậy, chúng tôi luôn quan tâm xây dựng đội ngũ Cán bộ quản lý và nhân viên chuyên nghiệp để đưa Công ty phát triển ngày càng vững mạnh. Công ty đánh giá khách quan, đúng mức về sự đóng góp của mỗi thành viên nhằm giúp Cán bộ nhân viên (CBNV) ý thức vai trò của mình trong việc hình thành văn hóa Công ty, không ngừng học tập, sáng tạo, cần cù và chính trực. Chính sách nhân sự luôn được cải tiến để CBNV Tân Minh Nhân có được môi trường làm việc tốt nhất:
                    </p>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start relative">

            {{-- 📌 SIDEBAR MỤC LỤC CỐ ĐỊNH (STICKY TOP) --}}
            <div class="lg:col-span-4 lg:sticky lg:top-[160px] z-20 self-start">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#264abc] px-3 mb-3">
                        Mục lục chính sách
                    </p>
                    <nav class="space-y-1.5">
                        @foreach($policySections as $sec)
                            <button
                                type="button"
                                @click="scrollToSection('{{ $sec['id'] }}')"
                                class="w-full flex items-center justify-between p-3.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-left cursor-pointer focus:outline-none"
                                :class="activeSection === '{{ $sec['id'] }}'
                                    ? 'bg-red-50 text-[#EB323A] border border-red-200/60 shadow-xs'
                                    : 'text-slate-700 hover:bg-slate-50 hover:text-[#264abc]'"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="w-2.5 h-2.5 rounded-full transition-colors"
                                        :class="activeSection === '{{ $sec['id'] }}' ? 'bg-[#EB323A]' : 'bg-slate-300'"
                                    ></span>
                                    <span>{{ $sec['title'] }}</span>
                                </div>
                                <svg
                                    class="w-4 h-4 transition-transform"
                                    :class="activeSection === '{{ $sec['id'] }}' ? 'translate-x-1 text-[#EB323A]' : 'opacity-0'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- CHI TIẾT NỘI DUNG CHÍNH SÁCH --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- 1. MÔI TRƯỜNG LÀM VIỆC --}}
                <div id="moi-truong" class="scroll-mt-32 bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs">
                    <div class="flex items-center gap-3.5 mb-5 pb-3.5 border-b border-slate-100">
                        <div class="p-2.5 bg-red-50 text-[#EB323A] rounded-xl">
                            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <p class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc]">1. Môi trường làm việc</p>
                    </div>
                    <ul class="space-y-4 text-base sm:text-lg text-slate-700 font-normal leading-relaxed">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#EB323A] shrink-0 mt-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Công ty quan tâm đến điều kiện làm việc của CBNV: bố trí nơi làm việc tiện nghi, thoáng mát, sạch sẽ; cung cấp đầy đủ máy móc, thiết bị, phương tiện làm việc cần thiết; trang bị đồng phục cho CBNV cũng như đầy đủ thiết bị bảo hộ lao động cá nhân cho CBNV làm việc ở công trường.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#EB323A] shrink-0 mt-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Môi trường làm việc năng động, chuyên nghiệp, luôn tạo điều kiện để mỗi CBNV đều có cơ hội tự khẳng định, phát huy hết năng lực của bản thân. Trong công việc luôn có sự hỗ trợ hướng dẫn của cấp trên, sự phối hợp của đồng nghiệp và các bộ phận liên quan trên tinh thần vì sự phát triển chung của Công ty.</span>
                        </li>
                    </ul>
                </div>

                {{-- 2. CHÍNH SÁCH LAO ĐỘNG --}}
                <div id="chinh-sach-ld" class="scroll-mt-32 bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs">
                    <div class="flex items-center gap-3.5 mb-5 pb-3.5 border-b border-slate-100">
                        <div class="p-2.5 bg-red-50 text-[#EB323A] rounded-xl">
                            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                        <p class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc]">2. Chính sách lao động</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="p-4.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <span class="text-sm sm:text-base font-bold text-[#264abc] block mb-1">Thời gian làm việc</span>
                            <span class="text-sm sm:text-base text-slate-700">Công ty thực hiện chế độ làm việc <strong>48 tiếng/tuần</strong>.</span>
                        </div>
                        <div class="p-4.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <span class="text-sm sm:text-base font-bold text-[#264abc] block mb-1">Nghỉ Lễ, Phép</span>
                            <span class="text-sm sm:text-base text-slate-700">Chế độ nghỉ Lễ, Phép và nghỉ khác tuân thủ theo qui định của Bộ luật lao động.</span>
                        </div>
                    </div>

                    <h4 class="text-sm sm:text-base font-extrabold uppercase tracking-wider text-[#264abc] mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#EB323A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span>Quy định kỷ luật và trách nhiệm CBNV</span>
                    </h4>
                    <ul class="space-y-3 text-base sm:text-lg text-slate-700 leading-relaxed font-normal bg-slate-50/60 p-5 rounded-xl border border-slate-100">
                        <li>• CBNV Tân Minh Nhân đến nơi làm việc phải mặc đồng phục theo qui định và nghiêm túc chấp hành kỷ luật Công ty.</li>
                        <li>• Nêu cao tinh thần trách nhiệm, tính đoàn kết nội bộ để hoàn thành tốt mọi nhiệm vụ được giao.</li>
                        <li>• Tuân thủ tuyệt đối sự phân công công việc và điều động của cấp trên.</li>
                        <li>• Báo cáo đầy đủ và trung thực nhiệm vụ được giao. Khi gặp khó khăn trong công việc phải xin ý kiến chỉ đạo của cấp trên để giải quyết kịp thời.</li>
                        <li>• Cán bộ đặc trách công tác chuyên môn nghiệp vụ không được lợi dụng chức quyền để nhận hoa hồng, tiền bồi dưỡng từ bất kỳ tổ chức, cá nhân nào dưới bất cứ hình thức nào gây mất uy tín cho Công ty.</li>
                        <li>• Không được dùng danh nghĩa của Công ty để làm việc cá nhân. Nghiêm cấm các hành vi gian dối trong lao động và trong tác nghiệp dẫn đến thiệt hại về tài sản và lợi ích của Công ty.</li>
                        <li>• Nghiêm cấm mọi hình thức tiết lộ thông tin, tự ý mang tài liệu ra khỏi văn phòng làm việc hoặc cung cấp thông tin của Công ty ra bên ngoài khi chưa có sự đồng ý của cấp trên.</li>
                        <li>• Giữ bí mật kinh doanh của Công ty.</li>
                        <li>• Thu nhập của Cá nhân được căn cứ vào việc nhận xét đánh giá của cấp lãnh đạo trực tiếp và nhìn nhận của cấp trên, do vậy không được tiết lộ thu nhập của cá nhân.</li>
                    </ul>
                </div>

                {{-- 3. TIỀN LƯƠNG --}}
                <div id="tien-luong" class="scroll-mt-32 bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs">
                    <div class="flex items-center gap-3.5 mb-5 pb-3.5 border-b border-slate-100">
                        <div class="p-2.5 bg-red-50 text-[#EB323A] rounded-xl">
                            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <p class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc]">3. Tiền lương</p>
                    </div>
                    <ul class="space-y-4 text-base sm:text-lg text-slate-700 font-normal leading-relaxed">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#EB323A] shrink-0 mt-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Cơ sở xây dựng lương:</strong> Chính sách lương xây dựng trên cơ sở công việc được giao và hiệu quả Công việc thực hiện.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#EB323A] shrink-0 mt-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Xem xét tăng lương:</strong> Định kỳ trong năm, Công ty sẽ xem xét thực hiện công việc của CBNV để làm cơ sở tăng lương thông qua việc nhận xét đánh giá của cấp lãnh đạo trực tiếp.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#EB323A] shrink-0 mt-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Chế độ thưởng:</strong> Ngoài tiền lương, Công ty cũng xem xét thưởng thỏa đáng nhằm động viên khuyến khích tinh thần làm việc cho CBNV: Thưởng Lễ, Tết và thưởng theo hiệu quả công việc, thưởng công trình.</span>
                        </li>
                    </ul>
                </div>

                {{-- 4. BẢO HIỂM XÃ HỘI --}}
                <div id="bao-hiem" class="scroll-mt-32 bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs">
                    <div class="flex items-center gap-3.5 mb-5 pb-3.5 border-b border-slate-100">
                        <div class="p-2.5 bg-red-50 text-[#EB323A] rounded-xl">
                            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <p class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc]">4. Bảo hiểm xã hội</p>
                    </div>
                    <p class="text-base sm:text-lg text-slate-700 font-normal leading-relaxed mb-5">
                        Thực hiện trích nộp bảo hiểm xã hội, bảo hiểm y tế cho người lao động theo qui định hiện hành. Các chế độ về thai sản, bảo hiểm tai nạn lao động, trợ cấp thôi việc theo đúng qui định của pháp luật.
                    </p>
                    <div class="p-5 bg-red-50/60 border border-red-100 rounded-xl space-y-2.5">
                        <span class="text-sm sm:text-base font-bold text-[#EB323A] uppercase tracking-wider block">Các loại bảo hiểm bổ sung khác:</span>
                        <ul class="text-base sm:text-lg text-slate-700 space-y-2 font-normal">
                            <li>• Bảo hiểm sức khỏe toàn diện. Tùy theo vị trí công tác và CBNV đi công tác xa… Công ty có mức bảo hiểm sức khỏe toàn diện cho người thân trong gia đình.</li>
                            <li>• Bảo hiểm khi công tác nước ngoài.</li>
                        </ul>
                    </div>
                </div>

                {{-- 5. ĐÀO TẠO --}}
                <div id="dao-tao" class="scroll-mt-32 bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs">
                    <div class="flex items-center gap-3.5 mb-5 pb-3.5 border-b border-slate-100">
                        <div class="p-2.5 bg-red-50 text-[#EB323A] rounded-xl">
                            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <p class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc]">5. Đào tạo</p>
                    </div>

                    <p class="text-base sm:text-lg text-slate-700 font-normal leading-relaxed mb-6">
                        Nhằm xây dựng đội ngũ nhân sự am tường công việc, có chuyên môn giỏi và đạo đức nghề nghiệp, hàng năm, Công ty xây dựng kế hoạch đào tạo phù hợp với chiến lược phát triển của Công ty.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="p-5 border border-slate-200/90 rounded-xl bg-white shadow-xs">
                            <span class="text-sm sm:text-base font-bold uppercase block mb-1.5 text-[#264abc]">Đào tạo hội nhập</span>
                            <p class="text-sm sm:text-base text-slate-700 font-normal leading-relaxed">Giúp nhân sự mới hiểu lịch sử, quy trình, văn hóa Tân Minh Nhân để nhanh chóng hòa nhập. Huấn luyện nghiệp vụ cho giám sát mới.</p>
                        </div>
                        <div class="p-5 border border-slate-200/90 rounded-xl bg-white shadow-xs">
                            <span class="text-sm sm:text-base font-bold uppercase block mb-1.5 text-[#264abc]">Lãnh đạo tiềm năng</span>
                            <p class="text-sm sm:text-base text-slate-700 font-normal leading-relaxed">Đề cử CBNV xuất sắc vào CLB Lãnh đạo tiềm năng, đào tạo chuyên sâu về kỹ năng quản lý, lập kế hoạch và tổ chức công việc.</p>
                        </div>
                        <div class="p-5 border border-slate-200/90 rounded-xl bg-white shadow-xs">
                            <span class="text-sm sm:text-base font-bold uppercase block mb-1.5 text-[#264abc]">Đào tạo nội bộ & Kỹ năng</span>
                            <p class="text-sm sm:text-base text-slate-700 font-normal leading-relaxed">Thường xuyên mời chuyên gia giảng dạy nghiệp vụ kỹ thuật sâu. Bồi dưỡng kỹ năng mềm: giao tiếp, thuyết trình, đàm phán.</p>
                        </div>
                        <div class="p-5 border border-slate-200/90 rounded-xl bg-white shadow-xs">
                            <span class="text-sm sm:text-base font-bold uppercase block mb-1.5 text-[#264abc]">Đào tạo ngắn hạn quốc tế</span>
                            <p class="text-sm sm:text-base text-slate-700 font-normal leading-relaxed">Hàng năm cử các cán bộ quản lý tham quan, học hỏi mô hình kiến trúc & xây dựng tiên tiến tại nước ngoài.</p>
                        </div>
                    </div>
                </div>

                {{-- 6. PHỤ CẤP, PHÚC LỢI VÀ ĐÃI NGỘ --}}
                <div id="phuc-loi" class="scroll-mt-32 bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-xs">
                    <div class="flex items-center gap-3.5 mb-5 pb-3.5 border-b border-slate-100">
                        <div class="p-2.5 bg-red-50 text-[#EB323A] rounded-xl">
                            <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </div>
                        <p class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc]">6. Phụ cấp, Phúc lợi và đãi ngộ</p>
                    </div>

                    <div class="space-y-6 text-base sm:text-lg text-slate-700 font-normal">
                        <div>
                            <h4 class="font-bold text-[#264abc] mb-1.5">6.1. Phụ cấp:</h4>
                            <p class="text-sm sm:text-base text-slate-700 leading-relaxed">Công ty xây dựng đầy đủ các phụ cấp, tạo điều kiện để CBNV hoàn thành tốt nhiệm vụ: phụ cấp bữa ăn, phụ cấp điện thoại, phụ cấp công tác,...</p>
                        </div>

                        <div>
                            <h4 class="font-bold text-[#264abc] mb-3">6.2. Phúc lợi:</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 shadow-xs">
                                    <svg class="w-6 h-6 text-[#EB323A] mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                    <span class="font-bold text-sm sm:text-base text-[#264abc] block mb-1">Du lịch</span>
                                    <span class="text-xs sm:text-sm text-slate-700 leading-snug block">Hàng năm Công ty tổ chức chuyến du lịch, nghỉ mát cho CBNV trong và ngoài nước nhằm tái tạo sức lao động, tạo sự đoàn kết gắn bó trong CBNV Công ty.</span>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 shadow-xs">
                                    <svg class="w-6 h-6 text-[#EB323A] mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007-6.75H18a3.75 3.75 0 003.75-3.75V3.75H2.25v1.5A3.75 3.75 0 006 9h3.493m5.007 0a3.75 3.75 0 01-7.5 0m7.5 0v3.75m-7.5-3.75v3.75" />
                                    </svg>
                                    <span class="font-bold text-sm sm:text-base text-[#264abc] block mb-1">Các hoạt động thể thao</span>
                                    <span class="text-xs sm:text-sm text-slate-700 leading-snug block">Hội thao Tân Minh Nhân được tổ chức định kỳ nhằm tạo điều kiện cho CBNV luyện tập thể thao, thi đấu giao lưu giữa các Bộ phận/Phòng/Ban.</span>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 shadow-xs">
                                    <svg class="w-6 h-6 text-[#EB323A] mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                    <span class="font-bold text-sm sm:text-base text-[#264abc] block mb-1">Chăm lo đời sống</span>
                                    <span class="text-xs sm:text-sm text-slate-700 leading-snug block">Tổ chức họp mặt tặng quà cho CBNV vào các dịp Lễ Tết truyền thống; Quà cho các cháu là con CBNV nhân ngày Quốc tế Thiếu nhi (1/6), tết Trung Thu; Quà khuyến khích tinh thần cho các cháu có thành tích tốt trong học tập.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>