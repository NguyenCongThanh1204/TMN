{{-- =========================================================
     HOME - NEWS SLIDESHOW & SIDEBAR (FIXED BLACK SPACES)
     resources/views/sections/news.blade.php
========================================================= --}}

@php
    use Illuminate\Support\Facades\Storage;

    $homeNews = isset($latestPosts) ? $latestPosts : (isset($posts) ? $posts : collect());

    $homeNews = $homeNews
        ->filter(function ($post) {
            return $post->published_at && $post->published_at->lte(now());
        })
        ->sortByDesc('published_at')
        ->take(8)
        ->values();

    $getImageUrl = fn ($path, $width = 400) => cloudinary_image_url($path, $width);
@endphp

<section id="news" class="relative overflow-hidden bg-white pt-[36px] pb-[28px] md:pt-[54px] md:pb-[40px] select-none border-b border-slate-200/80 font-sans">
    
    {{-- Lớp nền Ambient Glow mềm mại --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -right-40 top-20 h-96 w-96 rounded-full bg-blue-100/40 blur-3xl"></div>
        <div class="absolute -left-40 bottom-0 h-96 w-96 rounded-full bg-red-100/30 blur-3xl"></div>
    </div>

    {{-- KHUNG CHỨA 1440PX --}}
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12 relative z-10">

        @if($homeNews->isEmpty())
            <div class="p-12 text-center bg-slate-50 border border-slate-200 rounded-lg text-slate-500">
                Chưa có bài viết tin tức nào được xuất bản.
            </div>
        @else
            <div 
                class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch"
                x-data="{
                    activeIdx: 0,
                    postsCount: {{ $homeNews->count() }},
                    isHovered: false,
                    timer: null,
                    init() {
                        this.startAutoplay();
                    },
                    startAutoplay() {
                        this.timer = setInterval(() => {
                            if (!this.isHovered && this.postsCount > 1) {
                                this.activeIdx = (this.activeIdx + 1) % this.postsCount;
                            }
                        }, 5000);
                    },
                    stopAutoplay() {
                        clearInterval(this.timer);
                    },
                    nextSlide() {
                        this.activeIdx = (this.activeIdx + 1) % this.postsCount;
                    },
                    prevSlide() {
                        this.activeIdx = (this.activeIdx - 1 + this.postsCount) % this.postsCount;
                    },
                    selectSlide(index) {
                        this.activeIdx = index;
                    }
                }"
                @mouseenter="isHovered = true; stopAutoplay()"
                @mouseleave="isHovered = false; startAutoplay()"
            >
                
                {{-- ================= CỘT TRÁI: SLIDESHOW TIN TỨC (8/12) ================= --}}
                <div class="lg:col-span-8 flex flex-col justify-between">
                    <div>
                        {{-- Header Tin Tức --}}
                        <div class="mb-5 flex items-end justify-between">
                            <div>
                                <div class="mb-2.5 inline-flex items-center gap-2.5 text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#EB323A]">
                                    <span class="h-0.5 w-6 bg-[#EB323A]"></span>
                                    Tin tức & Hoạt động
                                </div>
                                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
                                    Góc nhìn <span class="font-light text-slate-400">Tân Minh Nhân</span>
                                </h2>
                            </div>
                            <a href="{{ route('news.index') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-[#EB323A] transition-colors pb-2">
                                Xem tất cả &rarr;
                            </a>
                        </div>

                        <div class="border border-slate-200 shadow-xl overflow-hidden bg-[#0e2e60] rounded-sm flex flex-col justify-between">
                            {{-- 📸 KHUNG SLIDESHOW CHÍNH (Tối ưu tốc độ tải ảnh đầu tiên) --}}
                            <div class="relative w-full aspect-[16/10] overflow-hidden bg-[#0e2e60] group">
                                
                                @foreach($homeNews as $idx => $post)
                                    @php
                                        $imgUrl = $getImageUrl($post->thumbnail, 800);
                                    @endphp
                                    <div 
                                        class="absolute inset-0 w-full h-full transition-opacity duration-500 ease-in-out"
                                        x-show="activeIdx === {{ $idx }}"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-105"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        style="display: {{ $idx === 0 ? 'block' : 'none' }};"
                                    >
                                        <a href="{{ route('news.show', $post) }}" class="block w-full h-full relative">
                                            @if($imgUrl)
                                                <img
                                                    src="{{ $imgUrl }}"
                                                    alt="{{ $post->title }}"
                                                    class="w-full h-full object-cover object-center pointer-events-none transition-transform duration-700 group-hover:scale-105"
                                                    @if($idx === 0)
                                                        loading="eager"
                                                        fetchpriority="high"
                                                    @else
                                                        loading="lazy"
                                                    @endif
                                                />
                                            @else
                                                <div class="w-full h-full bg-[#0e2e60] flex items-center justify-center text-slate-400 font-mono text-sm uppercase tracking-widest">
                                                    TMN News
                                                </div>
                                            @endif

                                            {{-- Lớp phủ Gradient mờ tinh tế giúp ảnh sáng rực rỡ hơn --}}
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/15 to-transparent"></div>
                                        </a>

                                        {{-- Danh mục bài viết (Badge) --}}
                                        @if(optional($post->category)->name)
                                            <div class="absolute top-4 left-4 z-10 pointer-events-none">
                                                <span class="rounded-xs bg-[#EB323A] px-3.5 py-1.5 text-[11px] font-extrabold uppercase tracking-wider text-white shadow-md">
                                                    {{ $post->category->name }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- Tiêu đề đè lên ảnh --}}
                                        <div class="absolute bottom-5 left-5 right-5 z-10 pointer-events-auto">
                                            <div class="flex items-center gap-2 mb-1.5 text-xs font-mono text-slate-300 tracking-wider">
                                                <span class="text-[#EB323A] font-bold">{{ optional($post->published_at)->format('d/m/Y') }}</span>
                                            </div>
                                            <a href="{{ route('news.show', $post) }}" class="hover:text-red-400 transition-colors block">
                                                <p class="font-extrabold text-base sm:text-xl leading-snug line-clamp-2 text-white drop-shadow-md">
                                                    {{ $post->title }}
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Thanh Thumbnail bên dưới --}}
                            <div class="p-[5px] bg-[#0a224a] grid grid-flow-col auto-cols-fr gap-1.5 overflow-x-auto scrollbar-none border-t border-[1px] border-white/10">
                                @foreach($homeNews as $idx => $post)
                                    @php
                                        $thumbUrl = $getImageUrl($post->thumbnail);
                                    @endphp
                                    <button
                                        type="button"
                                        @click="selectSlide({{ $idx }})"
                                        class="relative w-full aspect-[16/10] overflow-hidden transition-all cursor-pointer rounded-xs bg-slate-900"
                                        :class="activeIdx === {{ $idx }} ? 'border-[#EB323A] opacity-100 scale-105 ring-1 ring-[#EB323A] z-10' : 'border-transparent opacity-50 hover:opacity-100'"
                                    >
                                        @if($thumbUrl)
                                            <img src="{{ $thumbUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover pointer-events-none" loading="lazy" />
                                        @else
                                            <div class="w-full h-full bg-slate-800"></div>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= CỘT PHẢI: VIDEO & TUYỂN DỤNG (4/12) ================= --}}
                <div class="lg:col-span-4 flex flex-col justify-between h-full pt-0 lg:pt-[52px]">
                    
                    {{-- KHỐI 1: VIDEO --}}
                    <div>
                        <div class="mb-4">
                            <h3 class="text-xl font-bold uppercase tracking-wider text-slate-900">
                                Video Nổi Bật
                            </h3>
                            <div class="w-12 h-[3px] bg-[#EB323A] mt-1.5"></div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-slate-700 font-semibold text-sm line-clamp-1">
                                Tân Minh Nhân - Hành trình phát triển
                            </p>
                            <div class="aspect-video w-full overflow-hidden rounded-sm shadow-xl border border-slate-200 bg-black">
                                <iframe
                                    class="w-full h-full"
                                    src="https://www.youtube.com/embed/Yjfn2Ra1CC8"
                                    title="Video giới thiệu"
                                    loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    </div>

                    {{-- KHỐI 2: TUYỂN DỤNG --}}
                    <div class="mt-6 lg:mt-6">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold uppercase tracking-wider text-slate-900">
                                Tuyển dụng
                            </h3>
                            <div class="w-12 h-[3px] bg-[#EB323A] mt-1.5"></div>
                        </div>

                        <a
                            href="{{ url('/careers') }}"
                            class="block aspect-[16/10] overflow-hidden rounded-sm border border-slate-200 shadow-xl group relative bg-[#0e2e60]"
                        >
                            <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlDTkXwnwVmBb9swD4vgDv8_gucYa_NnBQoy30TCfwHA&s"
                                alt="Tuyển dụng"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-90"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a224a]/95 via-transparent to-transparent flex items-end p-5">
                                <span class="text-white text-sm font-bold uppercase tracking-wider group-hover:text-[#EB323A] transition-colors flex items-center gap-1.5">
                                    Gia nhập đội ngũ <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                                </span>
                            </div>
                        </a>
                    </div>

                </div>

            </div>
        @endif

    </div>
</section>