@extends('layouts.app')

@section('content')

<section
    id="contact"
    class="pt-[114px] pb-16 sm:pt-[146px] sm:pb-24 bg-white text-[#0F172A] relative border-b border-slate-200 select-none font-sans"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
            
            {{-- =========================================================
                 1. THÔNG TIN VĂN PHÒNG (CỘT TRÁI - 5 CỘT)
                 ========================================================= --}}
            <div class="lg:col-span-5">
                <h2 class="text-3xl sm:text-4xl font-light text-[#0F172A] mb-6 sm:mb-8 leading-tight">
                    Văn phòng <span class="italic text-[#EB323A] font-normal">Công ty</span>
                </h2>

                <div class="space-y-6">
                    {{-- VĂN PHÒNG ĐÀ NẴNG --}}
                    <div>
                        <span class="text-xs uppercase tracking-widest text-[#EB323A] font-bold font-mono block mb-3.5">
                            Tại Đà Nẵng
                        </span>
                        <div class="space-y-3.5">
                            {{-- Địa chỉ --}}
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full border border-slate-200 flex items-center justify-center text-[#EB323A] shrink-0 bg-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-500 block font-mono">Địa chỉ</span>
                                    <p class="text-sm font-semibold text-[#0F172A] leading-snug">
                                        246-250 Lê Văn Hiến, phường Ngũ Hành Sơn, TP. Đà Nẵng, Việt Nam
                                    </p>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full border border-slate-200 flex items-center justify-center text-[#EB323A] shrink-0 bg-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-500 block font-mono">Email</span>
                                    <a href="mailto:contact@tanminhnhan.com.vn" class="text-sm font-semibold text-[#0F172A] hover:text-[#EB323A] transition-colors">
                                        contact@tanminhnhan.com.vn
                                    </a>
                                </div>
                            </div>

                            {{-- Website --}}
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full border border-slate-200 flex items-center justify-center text-[#EB323A] shrink-0 bg-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-500 block font-mono">Website</span>
                                    <a href="https://www.tanminhnhan.com.vn" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-[#0F172A] hover:text-[#EB323A] transition-colors">
                                        www.tanminhnhan.com.vn
                                    </a>
                                </div>
                            </div>

                            {{-- Tel --}}
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full border border-slate-200 flex items-center justify-center text-[#EB323A] shrink-0 bg-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-500 block font-mono">Tel</span>
                                    <a href="tel:02363958718" class="text-sm font-semibold text-[#0F172A] hover:text-[#EB323A] transition-colors">
                                        (0236) 3 958718
                                    </a>
                                </div>
                            </div>

                            {{-- Fax --}}
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full border border-slate-200 flex items-center justify-center text-[#EB323A] shrink-0 bg-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-500 block font-mono">Fax</span>
                                    <p class="text-sm font-semibold text-[#0F172A] leading-snug">
                                        (0236) 3 868718
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- VĂN PHÒNG QUẢNG NAM --}}
                    <div class="pt-5 border-t border-slate-200/70">
                        <span class="text-xs uppercase tracking-widest text-[#EB323A] font-bold font-mono block mb-3.5">
                            Tại Quảng Nam
                        </span>
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-full border border-slate-200 flex items-center justify-center text-[#EB323A] shrink-0 bg-white">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 block font-mono">Địa chỉ</span>
                                <p class="text-sm font-semibold text-[#0F172A] leading-snug">
                                    Tổ 3, khối Ngân Giang, Phường Điện Bàn Đông, TP. Đà Nẵng, Việt Nam
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================================================
                 2. FORM GỬI LIÊN HỆ QUA EMAILJS (CỘT PHẢI - 7 CỘT)
                 ========================================================= --}}
            <div class="lg:col-span-7 bg-slate-50/90 p-6 sm:p-8 lg:p-10 border border-slate-200 rounded-sm shadow-xs">
                <form id="contact-form" class="space-y-5">
                    
                    {{-- Tên: đã đổi name="from_name" để khớp EmailJS --}}
                    <div>
                        <label for="name" class="block text-xs uppercase tracking-widest text-slate-700 mb-2 font-semibold font-mono">
                            Họ và Tên
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="from_name"
                            required
                            placeholder="Tên của bạn"
                            class="w-full bg-white border border-slate-300 px-4 py-3 text-sm text-[#0F172A] placeholder-slate-400 focus:outline-none focus:border-[#264ABC] transition-colors rounded-xs"
                        />
                    </div>

                    {{-- Email: đã đổi name="from_email" để khớp EmailJS --}}
                    <div>
                        <label for="email" class="block text-xs uppercase tracking-widest text-slate-700 mb-2 font-semibold font-mono">
                            Địa chỉ Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="from_email"
                            required
                            placeholder="john@example.com"
                            class="w-full bg-white border border-slate-300 px-4 py-3 text-sm text-[#0F172A] placeholder-slate-400 focus:outline-none focus:border-[#264ABC] transition-colors rounded-xs"
                        />
                    </div>

                    {{-- Nội dung: khớp biến {{message}} --}}
                    <div>
                        <label for="message" class="block text-xs uppercase tracking-widest text-slate-700 mb-2 font-semibold font-mono">
                            Nội dung
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            required
                            placeholder="Hãy mô tả tầm nhìn, phạm vi và kế hoạch thực hiện của bạn..."
                            class="w-full bg-white border border-slate-300 px-4 py-3 text-sm text-[#0F172A] placeholder-slate-400 focus:outline-none focus:border-[#264ABC] transition-colors rounded-xs resize-y"
                        ></textarea>
                    </div>

                    {{-- Nút Submit --}}
                    <button
                        id="submit-btn"
                        type="submit"
                        class="w-full bg-[#EB323A] text-white py-3.5 sm:py-4 text-xs uppercase tracking-[0.25em] font-bold hover:bg-[#264ABC] transition-colors duration-300 flex items-center justify-center gap-2 cursor-pointer rounded-xs"
                    >
                        <span id="btn-text">Gửi yêu cầu</span>
                        <svg id="btn-icon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>

                    {{-- Thông báo trạng thái qua JS --}}
                    <p id="status-success" class="hidden text-emerald-600 text-xs uppercase tracking-widest text-center mt-3 font-bold">
                        Cảm ơn bạn. Yêu cầu của bạn đã được gửi đến công ty của chúng tôi.
                    </p>

                    <p id="status-error" class="hidden text-[#EB323A] text-xs uppercase tracking-widest text-center mt-3 font-bold">
                        Gửi yêu cầu thất bại. Vui lòng kiểm tra lại kết nối hoặc thông tin.
                    </p>
                </form>
            </div>

        </div>

        {{-- =========================================================
             3. GOOGLE MAP
             ========================================================= --}}
        <div class="mt-12 sm:mt-16 h-80 rounded-sm overflow-hidden border border-slate-200 shadow-xs">
            <iframe
                title="Vị trí văn phòng Tân Minh Nhân"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.6897623929062!2d108.24456827589188!3d16.02965744049452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142175af0706bff%3A0x185f7d5651d72061!2zQ8O0bmcgdHkgQ-G7lSBwaOG6p24gWMOieSBk4buxbmcgS2nhur9uIHRyw7pjIFTDom4gTWluaCBOaMOibg!5e0!3m2!1svi!2s!4v1784776803513!5m2!1svi!2s"
                width="100%"
                height="100%"
                style="border: 0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>

    </div>
</section>

{{-- =========================================================
     SDK & SCRIPT EMAILJS
     ========================================================= --}}
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>
    (function() {
        emailjs.init({
            publicKey: "{{ config('services.emailjs.public_key') }}",
        });
    })();

    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');
    const statusSuccess = document.getElementById('status-success');
    const statusError = document.getElementById('status-error');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Ẩn thông báo cũ & khóa nút bấm
        statusSuccess.classList.add('hidden');
        statusError.classList.add('hidden');
        submitBtn.disabled = true;
        btnText.textContent = "Đang gửi...";
        btnIcon.classList.add('animate-spin');

        const serviceID = "{{ config('services.emailjs.service_id') }}";
        const templateID = "{{ config('services.emailjs.template_id') }}";

        emailjs.sendForm(serviceID, templateID, this)
            .then(() => {
                statusSuccess.classList.remove('hidden');
                form.reset();
            })
            .catch((error) => {
                console.error('EmailJS Error:', error);
                statusError.classList.remove('hidden');
            })
            .finally(() => {
                submitBtn.disabled = false;
                btnText.textContent = "Gửi yêu cầu";
                btnIcon.classList.remove('animate-spin');
            });
    });
</script>

@endsection