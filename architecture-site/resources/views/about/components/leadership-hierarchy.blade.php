{{-- =========================================================
     ABOUT - TAB 2: CÁN BỘ CHỦ CHỐT (DB DYNAMIC & STREAMLINED HĐQT)
     resources/views/about/components/leadership-hierarchy.blade.php
========================================================= --}}

@php
    // 1. Truy vấn toàn bộ danh sách lãnh đạo từ CSDL bảng leaders
    $dbLeaders = class_exists(\App\Models\Leader::class) 
        ? \App\Models\Leader::orderBy('level_id')->orderBy('position_order')->get() 
        : collect();

    // 2. Định nghĩa cấu trúc khung các cấp bậc
    $hierarchyConfig = [
        1 => [
            'levelId' => 1,
            'levelName' => 'Hội Đồng Quản Trị',
            'tabLabel' => 'Hội Đồng Quản Trị',
            'description' => 'Định hướng chiến lược & Xây dựng văn hóa Tân Minh Nhân',
            'badgeColor' => 'border-red-200 bg-red-50 text-[#EB323A]',
            'type' => 'single',
        ],
        2 => [
            'levelId' => 2,
            'levelName' => 'Ban Tổng Giám Đốc',
            'tabLabel' => 'Ban Tổng Giám Đốc',
            'description' => 'Điều hành chiến lược tổng thể & Quản trị vận hành',
            'badgeColor' => 'border-amber-200 bg-amber-50 text-amber-700',
            'type' => 'tiered',
        ],
        3 => [
            'levelId' => 3,
            'levelName' => 'Trợ Lý Chủ Tịch HĐQT & Giám Đốc Khối',
            'tabLabel' => 'Trợ Lý & GĐ Khối',
            'description' => 'Cố vấn chiến lược, Chuyển đổi số & Quản lý các khối chuyên môn',
            'badgeColor' => 'border-blue-200 bg-blue-50 text-blue-700',
            'type' => 'single',
        ],
        4 => [
            'levelId' => 4,
            'levelName' => 'Khối Điều Hành Dự Án',
            'tabLabel' => 'Giám Đốc Dự Án',
            'description' => 'Trực tiếp quản lý dự án, kỹ thuật công trình & phòng ban chức năng',
            'badgeColor' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
            'type' => 'single',
        ],
    ];

    // 3. Gom nhóm dữ liệu từ CSDL vào từng cấp bậc tương ứng
    $hierarchyData = [];
    foreach ($hierarchyConfig as $id => $config) {
        $membersInLevel = $dbLeaders->where('level_id', $id)->values();
        
        $config['members'] = $membersInLevel->toArray();
        $config['ceo'] = null;
        $config['deputies'] = [];

        if ($config['type'] === 'tiered' && $membersInLevel->isNotEmpty()) {
            $config['ceo'] = $membersInLevel->first();
            $config['deputies'] = $membersInLevel->skip(1)->values()->toArray();
        }

        $hierarchyData[] = $config;
    }
@endphp

<div
    class="py-12 sm:py-16 bg-[#F8FAFC] text-[#0F172A] relative select-none rounded-b-2xl px-6 sm:px-10 lg:px-12"
    x-data="{
        activeLevel: 1,
        selectedLeader: null,

        openModal(leader) {
            this.selectedLeader = leader;
            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.selectedLeader = null;
            document.body.classList.remove('overflow-hidden');
        }
    }"
    @keydown.escape.window="closeModal()"
>
    {{-- Background Grid Pattern mờ --}}
    <div
        class="absolute inset-0 opacity-[0.03] pointer-events-none rounded-b-2xl"
        style="background-image: linear-gradient(to right, #000000 1px, transparent 1px), linear-gradient(to bottom, #000000 1px, transparent 1px); background-size: 32px 32px;"
    ></div>

    <div class="max-w-[1440px] mx-auto relative z-10">

        {{-- HEADER TIÊU ĐỀ --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#EB323A] bg-red-50 px-4.5 py-1.5 rounded-full border border-red-200 inline-block mb-3 shadow-xs">
                Sơ Đồ Tổ Chức
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold uppercase tracking-tight text-[#264abc]">
                Bộ Máy <span class="text-[#EB323A]">Ban Lãnh Đạo</span>
            </h2>
            <div class="w-16 h-1.5 bg-[#EB323A] mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- 4 SUB-TABS ĐIỀU HƯỚNG --}}
        <div class="flex items-center justify-center gap-3 sm:gap-4 flex-wrap mb-12">
            @foreach($hierarchyData as $level)
                <button
                    type="button"
                    @click="activeLevel = {{ $level['levelId'] }}"
                    class="px-5 py-3 sm:px-6 sm:py-3.5 rounded-xl text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all duration-200 focus:outline-none cursor-pointer shadow-xs"
                    :class="activeLevel === {{ $level['levelId'] }}
                        ? 'bg-[#EB323A] text-white shadow-md shadow-red-600/25 scale-[1.02]'
                        : 'bg-white text-slate-700 hover:text-slate-900 hover:bg-slate-100 border border-slate-200'"
                >
                    <span>{{ $level['tabLabel'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- KHU VỰC NỘI DUNG TỪNG CẤP BẬC --}}
        @foreach($hierarchyData as $level)
            <div
                x-show="activeLevel === {{ $level['levelId'] }}"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-3"
                x-transition:enter-end="opacity-100 translate-y-0"
                style="{{ $level['levelId'] === 1 ? '' : 'display: none;' }}"
                class="w-full flex flex-col items-center"
            >
                {{-- Mô tả cấp bậc --}}
                <div class="text-center mb-10 flex flex-col items-center">
                    <!-- <span class="text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border {{ $level['badgeColor'] }} mb-3 inline-block shadow-xs">
                        {{ $level['levelName'] }}
                    </span> -->
                    <p class="text-sm sm:text-base text-slate-600 font-normal max-w-2xl leading-relaxed">
                        {{ $level['description'] }}
                    </p>
                </div>

                {{-- 🌟 CẤP 1 (HĐQT): LAYOUT ĐƠN GIẢN, THANH LỊCH, PHÙ HỢP ẢNH VUÔNG 600x600 --}}
                @if($level['levelId'] === 1)
                    @if(count($level['members']) > 0)
                        <div class="flex flex-wrap justify-center gap-6 sm:gap-8 w-full max-w-[1100px]">
                            @foreach($level['members'] as $member)
                                <div
                                    @click="openModal({{ json_encode($member) }})"
                                    class="w-[280px] sm:w-[320px] bg-white border border-slate-200/90 rounded-2xl overflow-hidden cursor-pointer hover:border-[#EB323A] hover:shadow-[0_12px_30px_rgba(235,50,58,0.15)] transition-all duration-300 hover:-translate-y-1 group shadow-xs"
                                >
                                    {{-- Khung ảnh vuông 600x600 tối ưu --}}
                                    <div class="aspect-square w-full relative overflow-hidden bg-slate-50">
                                        @php
                                            $imgUrl = !empty($member['image']) 
                                                ? (str_starts_with($member['image'], 'http') ? $member['image'] : asset('storage/' . $member['image'])) 
                                                : asset('images/default-avatar.png');
                                        @endphp
                                        <img
                                            src="{{ $imgUrl }}"
                                            alt="{{ $member['name'] ?? '' }}"
                                            class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                            loading="eager"
                                            fetchpriority="high"
                                        />
                                    </div>
                                    <div class="p-5 text-center relative z-10 bg-white">
                                        <span class="text-[10px] font-bold text-[#EB323A] uppercase tracking-wider block mb-1">
                                            {{ $member['title'] ?? '' }}
                                        </span>
                                        <h4 class="font-extrabold text-base sm:text-lg uppercase text-[#264abc] group-hover:text-[#EB323A] transition-colors line-clamp-1">
                                            {{ $member['name'] ?? '' }}
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 text-sm italic">Đang cập nhật danh sách HĐQT...</p>
                    @endif
                @endif

                {{-- Dạng 1: Cấp thông thường (Cấp 3, 4) --}}
                @if($level['type'] === 'single' && $level['levelId'] !== 1)
                    @if(count($level['members']) > 0)
                        <div class="flex flex-wrap justify-center gap-6 sm:gap-8 w-full max-w-[1300px]">
                            @foreach($level['members'] as $member)
                                <div
                                    @click="openModal({{ json_encode($member) }})"
                                    class="w-[220px] sm:w-[250px] bg-white border border-slate-200/90 rounded-2xl overflow-hidden cursor-pointer hover:border-[#EB323A] hover:shadow-[0_12px_30px_rgba(235,50,58,0.15)] transition-all duration-300 hover:-translate-y-1 group shadow-xs"
                                >
                                    <div class="aspect-square w-full relative overflow-hidden bg-slate-50">
                                        @php
                                            $imgUrl = !empty($member['image']) 
                                                ? (str_starts_with($member['image'], 'http') ? $member['image'] : asset('storage/' . $member['image'])) 
                                                : asset('images/default-avatar.png');
                                        @endphp
                                        <img
                                            src="{{ $imgUrl }}"
                                            alt="{{ $member['name'] ?? '' }}"
                                            class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="p-4 sm:p-5 text-center relative z-10 bg-white">
                                        <h4 class="font-extrabold text-sm sm:text-base uppercase text-[#264abc] group-hover:text-[#EB323A] transition-colors line-clamp-1">
                                            {{ $member['name'] ?? '' }}
                                        </h4>
                                        <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 line-clamp-1">
                                            {{ $member['title'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 text-sm italic">Đang cập nhật danh sách nhân sự...</p>
                    @endif
                @endif

                {{-- Dạng 2: Cấp 2 chia làm 2 tầng --}}
                @if($level['type'] === 'tiered')
                    <div class="flex flex-col items-center w-full max-w-[1300px] gap-6">
                        {{-- Hàng 1: Tổng Giám Đốc --}}
                        @if($level['ceo'])
                            <div class="flex justify-center w-full">
                                <div
                                    @click="openModal({{ json_encode($level['ceo']) }})"
                                    class="w-[220px] sm:w-[250px] bg-white border border-slate-200/90 rounded-2xl overflow-hidden cursor-pointer hover:border-[#EB323A] hover:shadow-[0_12px_30px_rgba(235,50,58,0.15)] transition-all duration-300 hover:-translate-y-1 group shadow-xs"
                                >
                                    <div class="aspect-square w-full relative overflow-hidden bg-slate-50">
                                        @php
                                            $ceoImg = !empty($level['ceo']['image']) 
                                                ? (str_starts_with($level['ceo']['image'], 'http') ? $level['ceo']['image'] : asset('storage/' . $level['ceo']['image'])) 
                                                : asset('images/default-avatar.png');
                                        @endphp
                                        <img
                                            src="{{ $ceoImg }}"
                                            alt="{{ $level['ceo']['name'] ?? '' }}"
                                            class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="p-4 sm:p-5 text-center relative z-10 bg-white">
                                        <h4 class="font-extrabold text-sm sm:text-base uppercase text-[#264abc] group-hover:text-[#EB323A] transition-colors line-clamp-1">
                                            {{ $level['ceo']['name'] ?? '' }}
                                        </h4>
                                        <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 line-clamp-1">
                                            {{ $level['ceo']['title'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-[2px] h-6 bg-gradient-to-b from-[#EB323A] to-slate-300"></div>
                        @endif

                        {{-- Hàng 2: Các Phó Tổng Giám Đốc --}}
                        @if(count($level['deputies']) > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 sm:gap-8 w-full justify-items-center">
        @foreach($level['deputies'] as $deputy)
            <div
                @click="openModal({{ json_encode($deputy) }})"
                class="w-full max-w-[250px] bg-white border border-slate-200/90 rounded-2xl overflow-hidden cursor-pointer hover:border-[#EB323A] hover:shadow-[0_12px_30px_rgba(235,50,58,0.15)] transition-all duration-300 hover:-translate-y-1 group shadow-xs"
            >
                <div class="aspect-square w-full relative overflow-hidden bg-slate-50">
                    @php
                        $depImg = !empty($deputy['image']) 
                            ? (str_starts_with($deputy['image'], 'http') ? $deputy['image'] : asset('storage/' . $deputy['image'])) 
                            : asset('images/default-avatar.png');
                    @endphp
                    <img
                        src="{{ $depImg }}"
                        alt="{{ $deputy['name'] ?? '' }}"
                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    />
                </div>
                <div class="p-4 sm:p-5 text-center relative z-10 bg-white">
                    <h4 class="font-extrabold text-sm sm:text-base uppercase text-[#264abc] group-hover:text-[#EB323A] transition-colors line-clamp-1">
                        {{ $deputy['name'] ?? '' }}
                    </h4>
                    <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 line-clamp-1">
                        {{ $deputy['title'] ?? '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endif
                    </div>
                @endif
            </div>
        @endforeach

    </div>

    {{-- =========================================================
         POPUP DETAIL MODAL
         ========================================================= --}}
    <div
        x-show="selectedLeader"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeModal()"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs cursor-pointer"
        style="display: none;"
    >
        <div
            @click.stop
            x-show="selectedLeader"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="relative w-full max-w-2xl bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-2xl p-6 sm:p-8 flex flex-col sm:flex-row gap-6 sm:gap-8 cursor-default items-center"
        >
            <button
                type="button"
                @click="closeModal()"
                class="absolute top-3.5 right-3.5 p-2 rounded-full bg-slate-100 text-slate-500 hover:text-white hover:bg-[#EB323A] transition-colors z-20 cursor-pointer focus:outline-none"
            >
                <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="w-full sm:w-5/12 aspect-square rounded-xl overflow-hidden bg-slate-100 relative shrink-0 shadow-sm">
                <template x-if="selectedLeader?.image">
                    <img
                        :src="selectedLeader.image.startsWith('http') ? selectedLeader.image : '/storage/' + selectedLeader.image"
                        :alt="selectedLeader?.name"
                        class="w-full h-full object-cover object-top"
                    />
                </template>
            </div>

            <div class="w-full sm:w-7/12 flex flex-col max-h-[70vh]">
                <span
                    class="text-xs sm:text-sm font-bold text-[#EB323A] uppercase tracking-wider block mb-1.5"
                    x-text="selectedLeader?.title"
                ></span>
                <h3
                    class="text-lg sm:text-xl font-extrabold uppercase text-[#264abc] mb-2"
                    x-text="selectedLeader?.name"
                ></h3>
                <div class="w-8 h-[2.5px] bg-[#EB323A] mb-4 rounded-full shrink-0"></div>
                
                <div class="overflow-y-auto pr-2">
                    <p
                        class="text-slate-600 text-sm sm:text-base leading-relaxed font-normal"
                        x-text="selectedLeader?.bio || 'Đang cập nhật tiểu sử...'"
                    ></p>
                </div>
            </div>
        </div>
    </div>
</div>