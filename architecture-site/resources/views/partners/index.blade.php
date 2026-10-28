@extends('layouts.app')

@section('title', 'Đối tác chiến lược | '.config('site.name'))
@section('description', 'Các đối tác đồng hành cùng Tân Minh Nhân trong hành trình kiến tạo công trình bền vững.')

@section('content')
    <section class="bg-white pb-20 pt-32 text-slate-900">
        <section class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#EB323A]">Đồng hành phát triển</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-950 sm:text-5xl">
                    Đối tác chiến lược
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600">
                    Chúng tôi trân trọng sự tin tưởng và hợp tác của các thương hiệu, đơn vị và đối tác đã cùng tạo nên những công trình chất lượng.
                </p>
            </div>

            @if ($partners->isNotEmpty())
                <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach ($partners as $partner)
                        <article class="flex min-h-40 flex-col items-center justify-center gap-4 rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:border-slate-300 hover:shadow-md">
                            <img
                                src="{{ cloudinary_image_url($partner->logo, 500) }}"
                                alt="{{ $partner->name }}"
                                class="h-20 w-full object-contain"
                                loading="lazy"
                                decoding="async"
                            >
                            <h2 class="line-clamp-2 text-sm font-semibold text-slate-700">{{ $partner->name }}</h2>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-12 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-16 text-center">
                    <p class="text-base font-semibold text-slate-700">Danh sách đối tác đang được cập nhật.</p>
                    <p class="mt-2 text-sm text-slate-500">Vui lòng quay lại trong thời gian tới.</p>
                </div>
            @endif
        </section>
    </section>
@endsection
