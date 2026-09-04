@extends('layouts.app')

@section('content')

<div class="page-transition">

    {{-- =====================================================
         CONTACT HERO
         ===================================================== --}}
    <section class="relative overflow-hidden bg-slate-950 pt-36 text-white sm:pt-44">

        <div class="container-page relative z-10">

            <div class="grid min-h-[620px] items-end gap-12 pb-20 lg:grid-cols-[1fr_.55fr] lg:pb-24">

                <div>

                    <p class="eyebrow !text-red-400">
                        Liên hệ
                    </p>

                    <h1
                        class="mt-7 max-w-6xl font-display text-6xl font-semibold leading-[0.88] tracking-[-0.07em] text-white sm:text-7xl lg:text-[8rem]"
                    >
                        HÃY XÂY DỰNG
                        <br>
                        CÙNG NHAU.
                    </h1>

                    <p class="mt-8 max-w-2xl text-base leading-8 text-white/55 sm:text-lg">
                        Hãy kể cho chúng tôi về dự án, mục tiêu và lịch trình của bạn.
                        Đội ngành của chúng tôi sẵn sàng giúp định nghĩa con
                        đường đúng đắn từ ý tưởng đến thiết kế.
                    </p>

                </div>


                <div class="lg:pb-3">

                    <div class="border-l border-white/20 pl-6">

                        <p class="font-display text-[10px] font-bold uppercase tracking-[0.16em] text-white/35">
                            Bắt đầu cuộc trò chuyện
                        </p>

                        <p class="mt-4 font-display text-2xl font-medium leading-tight tracking-[-0.035em] text-white">
                            Kiến trúc.
                            Kỹ thuật.
                            Xây dựng.
                        </p>

                        <a
                            href="#quote-form"
                            class="mt-7 inline-flex items-center gap-3 font-display text-xs font-bold uppercase tracking-[0.1em] text-white transition-colors hover:text-red-400"
                        >
                            Yêu cầu báo giá
                            <span>↓</span>
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Architectural grid --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.08]"
            aria-hidden="true"
        >

            <div class="absolute inset-y-0 left-[20%] w-px bg-white"></div>

            <div class="absolute inset-y-0 left-[50%] w-px bg-white"></div>

            <div class="absolute inset-y-0 left-[80%] w-px bg-white"></div>

            <div class="absolute left-0 right-0 top-[50%] h-px bg-white"></div>

        </div>

    </section>


    {{-- =====================================================
         DIRECT CONTACT
         ===================================================== --}}
    <section class="border-b border-slate-200 bg-white">

        <div class="container-page">

            <div class="grid divide-y divide-slate-200 md:grid-cols-3 md:divide-x md:divide-y-0">

                {{-- Hotline --}}
                <a
                    href="tel:{{ config('site.phone') }}"
                    class="group py-8 md:px-7 md:first:pl-0"
                >

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                        Số điện thoại
                    </p>

                    <div class="mt-4 flex items-center justify-between gap-5">

                        <span class="font-display text-xl font-semibold tracking-[-0.03em]">
                            {{ config('site.phone') }}
                        </span>

                        <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 transition-all duration-300 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white">
                            →
                        </span>

                    </div>

                </a>


                {{-- Email --}}
                <a
                    href="mailto:{{ config('site.email') }}"
                    class="group py-8 md:px-7"
                >

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                        Email
                    </p>

                    <div class="mt-4 flex items-center justify-between gap-5">

                        <span class="break-all font-display text-xl font-semibold tracking-[-0.03em]">
                            {{ config('site.email') }}
                        </span>

                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 transition-all duration-300 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white">
                            →
                        </span>

                    </div>

                </a>


                {{-- Address --}}
                <div class="py-8 md:px-7 md:last:pr-0">

                    <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                        Head office
                    </p>

                    <p class="mt-4 font-display text-base font-semibold leading-6">
                        {{ config('site.address') }}
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         QUOTE SECTION
         ===================================================== --}}
    <section id="quote-form" class="section bg-slate-50">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.65fr_1.35fr]">

                {{-- Left --}}
                <div>

                    <p class="eyebrow">
                        Request a quote
                    </p>

                    <h2 class="mt-5 max-w-md font-display text-4xl font-semibold leading-[0.98] tracking-[-0.055em] sm:text-5xl lg:text-6xl">
                        Tell us about
                        your project.
                    </h2>

                    <p class="mt-7 max-w-md text-sm leading-7 text-slate-500">
                        The more context you provide, the better we can
                        understand your requirements and connect you with
                        the right technical team.
                    </p>


                    <div class="mt-10 space-y-6">

                        <div class="border-l-2 border-red-600 pl-5">

                            <p class="font-display text-sm font-semibold">
                                Bước tiếp theo là gì?
                            </p>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                We review your request, understand the
                                project scope and contact you to discuss
                                the next step.
                            </p>

                        </div>


                        <div class="border-l-2 border-slate-300 pl-5">

                            <p class="font-display text-sm font-semibold">
                                Phản hồi điển hình
                            </p>

                            <p class="mt-2 text-sm leading-7 text-slate-500">
                                Our technical or business team will get
                                back to you with an initial discussion.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Form --}}
                <div>

                    <form
                        action="{{ route('contact.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="bg-white p-6 shadow-xl ring-1 ring-slate-200 sm:p-8 lg:p-10"
                    >

                        @csrf


                        {{-- Success --}}
                        @if(session('success'))

                            <div class="mb-8 border border-emerald-200 bg-emerald-50 p-5">

                                <p class="font-display text-sm font-semibold text-emerald-900">
                                    Yêu cầu đã được gửi thành công.
                                </p>

                                <p class="mt-1 text-sm leading-6 text-emerald-700">
                                    {{ session('success') }}
                                </p>

                            </div>

                        @endif


                        {{-- Errors --}}
                        @if($errors->any())

                            <div class="mb-8 border border-red-200 bg-red-50 p-5">

                                <p class="font-display text-sm font-semibold text-red-900">
                                    Please review the following:
                                </p>

                                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">

                                    @foreach($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        {{-- Form grid --}}
                        <div class="grid gap-5 sm:grid-cols-2">


                            {{-- Full name --}}
                            <div class="sm:col-span-2">

                                <label
                                    for="full_name"
                                    class="form-label"
                                >
                                    Họ và tên *
                                </label>

                                <input
                                    id="full_name"
                                    name="full_name"
                                    type="text"
                                    value="{{ old('full_name') }}"
                                    required
                                    autocomplete="name"
                                    class="form-input"
                                    placeholder="Họ và tên của bạn"
                                >

                            </div>


                            {{-- Phone --}}
                            <div>

                                <label
                                    for="phone"
                                    class="form-label"
                                >
                                    Số điện thoại *
                                </label>

                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    required
                                    autocomplete="tel"
                                    class="form-input"
                                    placeholder="+84..."
                                >

                            </div>


                            {{-- Email --}}
                            <div>

                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    Email *
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    class="form-input"
                                    placeholder="you@example.com"
                                >

                            </div>


                            {{-- Project type --}}
                            <div>

                                <label
                                    for="project_type"
                                    class="form-label"
                                >
                                    Loại dự án *
                                </label>

                                <select
                                    id="project_type"
                                    name="project_type"
                                    required
                                    class="form-input"
                                >

                                    <option value="">
                                        Chọn loại dự án
                                    </option>

                                    <option
                                        value="Residential"
                                        @selected(old('project_type') === 'Residential')
                                    >
                                        Dân cư
                                    </option>

                                    <option
                                        value="Commercial"
                                        @selected(old('project_type') === 'Commercial')
                                    >
                                        Thương mại
                                    </option>

                                    <option
                                        value="Industrial"
                                        @selected(old('project_type') === 'Industrial')
                                    >
                                        Công nghiệp
                                    </option>

                                    <option
                                        value="Hospitality"
                                        @selected(old('project_type') === 'Hospitality')
                                    >
                                        Đểu hành
                                    </option>

                                    <option
                                        value="Interior & Fit-Out"
                                        @selected(old('project_type') === 'Interior & Fit-Out')
                                    >
                                        Nội thất & Hoàn thiện
                                    </option>

                                    <option
                                        value="Other"
                                        @selected(old('project_type') === 'Other')
                                    >
                                        Khác
                                    </option>

                                </select>

                            </div>


                            {{-- Budget --}}
                            <div>

                                <label
                                    for="estimated_budget"
                                    class="form-label"
                                >
                                    Ngân sách dự kế
                                </label>

                                <select
                                    id="estimated_budget"
                                    name="estimated_budget"
                                    class="form-input"
                                >

                                    <option value="">
                                        Chọn dảy ngân sách
                                    </option>

                                    <option
                                        value="Under 1B VND"
                                        @selected(old('estimated_budget') === 'Under 1B VND')
                                    >
                                        Dưới 1 tữ VND
                                    </option>

                                    <option
                                        value="1B - 5B VND"
                                        @selected(old('estimated_budget') === '1B - 5B VND')
                                    >
                                        1 tữ – 5 tữ VND
                                    </option>

                                    <option
                                        value="5B - 20B VND"
                                        @selected(old('estimated_budget') === '5B - 20B VND')
                                    >
                                        5 tữ – 20 tữ VND
                                    </option>

                                    <option
                                        value="20B - 50B VND"
                                        @selected(old('estimated_budget') === '20B - 50B VND')
                                    >
                                        20 tữ – 50 tữ VND
                                    </option>

                                    <option
                                        value="50B+ VND"
                                        @selected(old('estimated_budget') === '50B+ VND')
                                    >
                                        50+ tữ VND
                                    </option>

                                    <option
                                        value="To be discussed"
                                        @selected(old('estimated_budget') === 'To be discussed')
                                    >
                                        Còn hợp thương lượng
                                    </option>

                                </select>

                            </div>


                            {{-- Location --}}
                            <div class="sm:col-span-2">

                                <label
                                    for="project_location"
                                    class="form-label"
                                >
                                    Vị trí dự án
                                </label>

                                <input
                                    id="project_location"
                                    name="project_location"
                                    type="text"
                                    value="{{ old('project_location') }}"
                                    class="form-input"
                                    placeholder="Thành phố / tỉnh / vị trí nơi đấu"
                                >

                            </div>


                            {{-- Timeline --}}
                            <div>

                                <label
                                    for="timeline"
                                    class="form-label"
                                >
                                    Thời hạn thực hiện
                                </label>

                                <select
                                    id="timeline"
                                    name="timeline"
                                    class="form-input"
                                >

                                    <option value="">
                                        Chọn thời hạn
                                    </option>

                                    <option
                                        value="Urgent / ASAP"
                                        @selected(old('timeline') === 'Urgent / ASAP')
                                    >
                                        Gấp gỏ / Không trễ
                                    </option>

                                    <option
                                        value="Within 1 month"
                                        @selected(old('timeline') === 'Within 1 month')
                                    >
                                        Trong 1 tháng
                                    </option>

                                    <option
                                        value="1 - 3 months"
                                        @selected(old('timeline') === '1 - 3 months')
                                    >
                                        1 – 3 tháng
                                    </option>

                                    <option
                                        value="3 - 6 months"
                                        @selected(old('timeline') === '3 - 6 months')
                                    >
                                        3 – 6 tháng
                                    </option>

                                    <option
                                        value="6+ months"
                                        @selected(old('timeline') === '6+ months')
                                    >
                                        6+ tháng
                                    </option>

                                </select>

                            </div>


                            {{-- Service --}}
                            <div>

                                <label
                                    for="service_required"
                                    class="form-label"
                                >
                                    Dịch vụ cần thiết
                                </label>

                                <select
                                    id="service_required"
                                    name="service_required"
                                    class="form-input"
                                >

                                    <option value="">
                                        Chọn dịch vụ
                                    </option>

                                    <option
                                        value="Architectural Design"
                                        @selected(old('service_required') === 'Architectural Design')
                                    >
                                        Thiết kế Kiến trúc
                                    </option>

                                    <option
                                        value="General Construction"
                                        @selected(old('service_required') === 'General Construction')
                                    >
                                        Xây dựng Đại trà
                                    </option>

                                    <option
                                        value="Interior & Fit-Out"
                                        @selected(old('service_required') === 'Interior & Fit-Out')
                                    >
                                        Nội thất & Hoàn thiện
                                    </option>

                                    <option
                                        value="Project Supervision"
                                        @selected(old('service_required') === 'Project Supervision')
                                    >
                                        Giám sát Dự án
                                    </option>

                                    <option
                                        value="Design & Build"
                                        @selected(old('service_required') === 'Design & Build')
                                    >
                                        Thiết kế & Xây dựng
                                    </option>

                                </select>

                            </div>


                            {{-- Attachment --}}
                            <div class="sm:col-span-2">

                                <label
                                    for="attachment"
                                    class="form-label"
                                >
                                    Thông tin dự án
                                </label>

                                <input
                                    id="attachment"
                                    name="attachment"
                                    type="file"
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.dwg,.zip"
                                    class="form-input"
                                >

                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                    Tuỳ chọn. Bạn có thể tải lên sơ đổ nơi đấu,
                                    về kỳ thuậ t, tài liệu PDF hoặc tài liệu tham khảo.
                                </p>

                            </div>


                            {{-- Message --}}
                            <div class="sm:col-span-2">

                                <label
                                    for="message"
                                    class="form-label"
                                >
                                    Tổng quan dự án *
                                </label>

                                <textarea
                                    id="message"
                                    name="message"
                                    rows="7"
                                    required
                                    class="form-input form-textarea"
                                    placeholder="Hãy cho chúng tôi biết về nơi đấu, kựu hình, yêu cầu, mục tiêu và bất cứ thông tin nào khác chúng tôi nên biết..."
                                >{{ old('message') }}</textarea>

                            </div>


                            {{-- Privacy --}}
                            <div class="sm:col-span-2">

                                <label class="flex items-start gap-3 text-sm leading-6 text-slate-500">

                                    <input
                                        type="checkbox"
                                        name="privacy"
                                        value="1"
                                        required
                                        class="mt-1"
                                    >

                                    <span>
                                        Tôi đồng ý rằng thông tin
                                        được cung cấp có thể được sử dụng để liên hệ
                                        với tôi về dự án này.
                                    </span>

                                </label>

                            </div>


                            {{-- Submit --}}
                            <div class="sm:col-span-2">

                                <button
                                    type="submit"
                                    class="btn-primary w-full sm:w-auto sm:min-w-[240px]"
                                >
                                    Gửi Phiến yêu cầu Dự án →
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MAP + CONTACT INFO
         ===================================================== --}}
    <section class="bg-white">

        <div class="container-page">

            <div class="grid lg:grid-cols-[1fr_.65fr]">

                {{-- Map --}}
                <div class="min-h-[420px] bg-slate-100">

                    <iframe
                        title="Company location map"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1!2d0!3d0"
                        class="h-full min-h-[420px] w-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>

                </div>


                {{-- Information --}}
                <div class="bg-slate-950 p-8 text-white sm:p-12 lg:p-16">

                    <p class="eyebrow !text-red-400">
                        Find us
                    </p>

                    <h2 class="mt-6 font-display text-4xl font-semibold leading-[0.98] tracking-[-0.05em] text-white sm:text-5xl">
                        Come talk
                        to us.
                    </h2>


                    <div class="mt-10 space-y-7">

                        <div>

                            <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">
                                Head office
                            </p>

                            <p class="mt-2 max-w-sm text-sm leading-7 text-white/60">
                                {{ config('site.address') }}
                            </p>

                        </div>


                        <div>

                            <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">
                                Hotline
                            </p>

                            <a
                                href="tel:{{ config('site.phone') }}"
                                class="mt-2 block font-display text-xl font-semibold text-white hover:text-red-400"
                            >
                                {{ config('site.phone') }}
                            </a>

                        </div>


                        <div>

                            <p class="font-display text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">
                                Email
                            </p>

                            <a
                                href="mailto:{{ config('site.email') }}"
                                class="mt-2 block break-all font-display text-xl font-semibold text-white hover:text-red-400"
                            >
                                {{ config('site.email') }}
                            </a>

                        </div>

                    </div>


                    <div class="mt-10 border-t border-white/10 pt-7">

                        <p class="text-xs leading-6 text-white/30">
                            Technical consultations, project meetings
                            and site discussions are available by
                            appointment.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         PROCESS
         ===================================================== --}}
    <section class="section bg-slate-50">

        <div class="container-page">

            <div class="mb-14">

                <p class="eyebrow">
                    What happens next
                </p>

                <h2 class="section-title max-w-5xl">
                    From enquiry
                    to next step.
                </h2>

            </div>


            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">

                <div class="process-step">

                    <span class="process-step-number">
                        01
                    </span>

                    <h3 class="process-step-title">
                        We review
                    </h3>

                    <p class="process-step-description">
                        Our team reviews your requirements, scope,
                        location and available documents.
                    </p>

                </div>


                <div class="process-step">

                    <span class="process-step-number">
                        02
                    </span>

                    <h3 class="process-step-title">
                        We contact you
                    </h3>

                    <p class="process-step-description">
                        We connect with you to clarify requirements and
                        understand the project's priorities.
                    </p>

                </div>


                <div class="process-step">

                    <span class="process-step-number">
                        03
                    </span>

                    <h3 class="process-step-title">
                        We define scope
                    </h3>

                    <p class="process-step-description">
                        We identify the right service model, technical
                        approach and project next steps.
                    </p>

                </div>


                <div class="process-step">

                    <span class="process-step-number">
                        04
                    </span>

                    <h3 class="process-step-title">
                        We move forward
                    </h3>

                    <p class="process-step-description">
                        Once aligned, we proceed into the appropriate
                        design, engineering or construction stage.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FAQ
         ===================================================== --}}
    <section class="section bg-white">

        <div class="container-page">

            <div class="grid gap-14 lg:grid-cols-[0.55fr_1.45fr]">

                <div>

                    <p class="eyebrow">
                        FAQ
                    </p>

                    <h2 class="mt-5 font-display text-4xl font-semibold leading-[0.98] tracking-[-0.055em] sm:text-5xl">
                        Common
                        questions.
                    </h2>

                </div>


                <div
                    x-data="{ active: null }"
                    class="divide-y divide-slate-200 border-y border-slate-200"
                >

                    {{-- FAQ 01 --}}
                    <div>

                        <button
                            type="button"
                            @click="active === 1 ? active = null : active = 1"
                            class="flex w-full items-center justify-between gap-6 py-6 text-left"
                        >

                            <span class="font-display text-lg font-semibold">
                                What information should I provide?
                            </span>

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200"
                            >
                                <span
                                    x-text="active === 1 ? '−' : '+'"
                                ></span>
                            </span>

                        </button>


                        <div
                            x-cloak
                            x-show="active === 1"
                            x-transition
                            class="pb-6 pr-12"
                        >

                            <p class="text-sm leading-7 text-slate-500">
                                Project type, location, approximate area,
                                target timeline, budget range and any
                                available drawings or reference materials
                                are helpful.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 02 --}}
                    <div>

                        <button
                            type="button"
                            @click="active === 2 ? active = null : active = 2"
                            class="flex w-full items-center justify-between gap-6 py-6 text-left"
                        >

                            <span class="font-display text-lg font-semibold">
                                Can I send drawings or documents?
                            </span>

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200"
                            >
                                <span
                                    x-text="active === 2 ? '−' : '+'"
                                ></span>
                            </span>

                        </button>


                        <div
                            x-cloak
                            x-show="active === 2"
                            x-transition
                            class="pb-6 pr-12"
                        >

                            <p class="text-sm leading-7 text-slate-500">
                                Yes. The enquiry form supports common
                                project documents such as PDF, image,
                                Word, DWG and ZIP files, subject to the
                                server's upload limits.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 03 --}}
                    <div>

                        <button
                            type="button"
                            @click="active === 3 ? active = null : active = 3"
                            class="flex w-full items-center justify-between gap-6 py-6 text-left"
                        >

                            <span class="font-display text-lg font-semibold">
                                Do you handle design and construction?
                            </span>

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200"
                            >
                                <span
                                    x-text="active === 3 ? '−' : '+'"
                                ></span>
                            </span>

                        </button>


                        <div
                            x-cloak
                            x-show="active === 3"
                            x-transition
                            class="pb-6 pr-12"
                        >

                            <p class="text-sm leading-7 text-slate-500">
                                The company can provide architectural,
                                engineering, construction, interior
                                and project supervision services,
                                depending on the project's scope.
                            </p>

                        </div>

                    </div>


                    {{-- FAQ 04 --}}
                    <div>

                        <button
                            type="button"
                            @click="active === 4 ? active = null : active = 4"
                            class="flex w-full items-center justify-between gap-6 py-6 text-left"
                        >

                            <span class="font-display text-lg font-semibold">
                                How does the quotation process work?
                            </span>

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200"
                            >
                                <span
                                    x-text="active === 4 ? '−' : '+'"
                                ></span>
                            </span>

                        </button>


                        <div
                            x-cloak
                            x-show="active === 4"
                            x-transition
                            class="pb-6 pr-12"
                        >

                            <p class="text-sm leading-7 text-slate-500">
                                After the initial discussion, the team
                                assesses the project scope and determines
                                the appropriate next stage for a more
                                detailed technical or commercial proposal.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FINAL CTA
         ===================================================== --}}
    <section class="section section-blueprint">

        <div class="container-page relative z-10">

            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">

                <div>

                    <p class="eyebrow !text-white/60">
                        Start today
                    </p>

                    <h2 class="mt-6 max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.06em] text-white sm:text-7xl lg:text-8xl">
                        YOUR NEXT
                        <br>
                        PROJECT STARTS
                        <br>
                        HERE.
                    </h2>

                    <p class="mt-7 max-w-xl text-sm leading-7 text-white/55">
                        Tell us what you are building and let our team
                        help turn the idea into a clear execution path.
                    </p>

                </div>


                <a
                    href="#quote-form"
                    class="btn-white group min-w-[220px]"
                >

                    Request a Quote

                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                        ↑
                    </span>

                </a>

            </div>

        </div>

    </section>

</div>


{{-- =========================================================
     LOCAL BUSINESS JSON-LD
     ========================================================= --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => config('site.name'),
    'url' => config('app.url'),
    'telephone' => config('site.phone'),
    'email' => config('site.email'),
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => config('site.address'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@endsection