<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{ProjectCategory, Project, ProjectMedia, PostCategory, Post, Career, User, Partner, Leader};
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder { 
    public function run(): void {
        // 1. Tạo tài khoản đăng nhập admin
        User::firstOrCreate(
            ['email' => 'nct120404@gmail.com'],
            [
                'name' => 'Nguyễn Công Thành',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Danh mục dự án
        $pc = [];
        $projectCategories = [
            1 => ['name' => 'Tổng thầu thi công', 'slug' => 'tong-thau-thi-cong'],
            2 => ['name' => 'Thi công hoàn thiện', 'slug' => 'thi-cong-hoan-thien'],
            3 => ['name' => 'Thi công kết cấu', 'slug' => 'thi-cong-ket-cau'],
        ];
        foreach($projectCategories as $id => $cat){
            $pc[$id] = ProjectCategory::create(['name' => $cat['name'], 'slug' => $cat['slug']]);
        }

        // 3. Dự án thực tế từ Laragon
        $projectsData = [
            [
                'id' => 1, 'category_id' => 1, 'title' => 'Văn phòng Tân Minh Nhân', 'slug' => 'van-phong-tan-minh-nhan',
                'client_name' => 'Tân Minh Nhân', 'location' => 'Đà Nẵng', 'area_sqm' => '01 tầng hầm, 4 tầng cao, tổng diện tích 3.200m²',
                'structural_type' => 'Tổng thầu Thiết kế & Thi công', 'cover_image' => 'projects/van-phong-tan-minh-nhan/covers/anh-tmn.jpg',
                'body_content' => 'Là tòa nhà văn phòng với trang thiết bị hiện đại, đánh dấu bước phát triển của Tân Minh Nhân trong nhiều năm qua, tọa lạc tại số 246 - 250 Lê Văn Hiến – TP.Đà Nẵng.',
                'is_featured' => 1, 'status' => 'published'
            ],
            [
                'id' => 2, 'category_id' => 1, 'title' => 'Đại học Văn Lang', 'slug' => 'dai-hoc-van-lang',
                'client_name' => 'Trường Đại học Văn Lang', 'location' => 'TP Hồ Chí Minh', 'area_sqm' => '9 tầng, 10.000m²',
                'structural_type' => 'Tổng thầu Thiết kế & Thi công', 'cover_image' => 'projects/dai-hoc-van-lang/covers/anh-van-lang.jpg',
                'body_content' => 'Đại học Văn Lang tọa lạc trên một con đường nằm khiêm tốn giữa lòng Quận 1 sôi động.',
                'is_featured' => 0, 'status' => 'published'
            ],
            [
                'id' => 3, 'category_id' => 1, 'title' => 'Biệt thự nhà phố Euro Village Đà Nẵng', 'slug' => 'biet-thu-nha-pho-euro-village-da-nang',
                'client_name' => 'Biệt thự Euro 1234', 'location' => 'Đà Nẵng', 'area_sqm' => '01 tầng hầm, 4 tầng cao, tổng diện tích 3.200m²',
                'structural_type' => 'Tổng thầu Thiết kế & Thi công', 'cover_image' => 'projects/biet-thu-nha-pho-euro-village-da-nang/covers/euro-village.jpg',
                'body_content' => null, 'is_featured' => 0, 'status' => 'published'
            ],
            [
                'id' => 4, 'category_id' => 1, 'title' => 'Trường mầm non Tuệ Đức Đà Nẵng', 'slug' => 'truong-mam-non-tue-duc-da-nang',
                'client_name' => 'Nam Việt Á', 'location' => 'Đà Nẵng', 'area_sqm' => '03 tầng, tổng diện tích 5.000m²',
                'structural_type' => 'Tổng thầu Thiết kế & Thi công', 'cover_image' => 'projects/truong-mam-non-tue-duc-da-nang/covers/tueduc.jpg',
                'body_content' => null, 'is_featured' => 0, 'status' => 'published'
            ],
            [
                'id' => 5, 'category_id' => 2, 'title' => 'SUNSET TOWN PHÚ QUỐC', 'slug' => 'sunset-town-phu-quoc',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Phú Quốc', 'area_sqm' => 'Tổng diện tích 39,3ha',
                'structural_type' => 'Thi công hoàn thiện', 'cover_image' => 'projects/sunset-town-phu-quoc/covers/sunset-town-phu-quoc-01.jpg',
                'body_content' => null, 'is_featured' => 1, 'status' => 'published'
            ],
            [
                'id' => 6, 'category_id' => 2, 'title' => 'VUI-FEST BAZAAR PHÚ QUỐC', 'slug' => 'vui-fest-bazaar-phu-quoc',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Phú Quốc', 'area_sqm' => 'Tổng diện tích 1.115m2',
                'structural_type' => 'Thi công hoàn thiện', 'cover_image' => 'projects/vui-fest-bazaar-phu-quoc/covers/vui-fest-bazaar-phu-quoc-02.jpg',
                'body_content' => null, 'is_featured' => 0, 'status' => 'published'
            ],
            [
                'id' => 7, 'category_id' => 1, 'title' => 'LA FESTA PHÚ QUỐC – CURIO', 'slug' => 'la-festa-phu-quoc-curio',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Phú Quốc', 'area_sqm' => '200 phòng',
                'structural_type' => 'Thi công hoàn thiện', 'cover_image' => 'projects/la-festa-phu-quoc-curio/covers/la-festa-phu-quoc-curio.jpg',
                'body_content' => null, 'is_featured' => 1, 'status' => 'published'
            ],
            [
                'id' => 8, 'category_id' => 2, 'title' => 'SUN GRAND CITY HILLSIDE RESIDENCE PHÚ QUỐC', 'slug' => 'sun-grand-city-hillside-residence-phu-quoc',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Phú Quốc', 'area_sqm' => '8 tòa Parcel, 6 tòa cao 18 tầng',
                'structural_type' => 'Thi công hoàn thiện', 'cover_image' => 'projects/sun-grand-city-hillside-residence-phu-quoc/covers/sun-grand-city-hillside-residence-phu-quoc-01-v1.jpg',
                'body_content' => null, 'is_featured' => 1, 'status' => 'published'
            ],
            [
                'id' => 9, 'category_id' => 3, 'title' => 'Sân bay quốc tế Phú Quốc', 'slug' => 'san-bay-quoc-te-phu-quoc',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Phú Quốc', 'area_sqm' => 'Tổng diện tích 1.050 ha',
                'structural_type' => 'Thi công kết cấu', 'cover_image' => 'projects/san-bay-quoc-te-phu-quoc/covers/san-bay-phu-quoc-01.png',
                'body_content' => 'Là dự án trọng điểm phục vụ APEC 2027 tại Phú Quốc.', 'is_featured' => 0, 'status' => 'published'
            ],
            [
                'id' => 10, 'category_id' => 2, 'title' => 'New World Phú Quốc Resort', 'slug' => 'new-world-phu-quoc-resort',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Phú Quốc', 'area_sqm' => '375 căn biệt thự',
                'structural_type' => 'Thi công hoàn thiện', 'cover_image' => 'projects/new-world-phu-quoc-resort/covers/phu-quoc-resort-01.png',
                'body_content' => 'Khu nghỉ dưỡng New World Phú Quốc là khu nghỉ dưỡng đầu tiên của thương hiệu New World tại Việt Nam.',
                'is_featured' => 1, 'status' => 'published'
            ],
            [
                'id' => 11, 'category_id' => 2, 'title' => 'Bà Nà Hill', 'slug' => 'ba-na-hill',
                'client_name' => 'Tập đoàn Sun Group', 'location' => 'Đà Nẵng', 'area_sqm' => null,
                'structural_type' => 'Thi công hoàn thiện', 'cover_image' => 'projects/ba-na-hill/covers/ba-na-hill-01.jpg',
                'body_content' => 'Nằm ở độ cao 1.487m so với mực nước biển, Sun World Ba Na Hills được mệnh danh là “chốn bồng lai tiên cảnh”.',
                'is_featured' => 1, 'status' => 'published'
            ]
        ];

        foreach($projectsData as $p){
            $proj = Project::create($p);
            ProjectMedia::create([
                'project_id' => $proj->id,
                'file_path' => $p['cover_image'],
                'caption' => 'Project Media',
                'sort_order' => 1
            ]);
        }

        // 4. Danh mục bài viết & Bài viết thực tế
        $nc = [];
        $postCategories = [
            1 => ['name' => 'Tin Công Trình', 'slug' => 'tin-cong-trinh'],
            2 => ['name' => 'Tin công Ty', 'slug' => 'tin-cong-ty'],
        ];
        foreach($postCategories as $id => $cat){
            $nc[$id] = PostCategory::create(['name' => $cat['name'], 'slug' => $cat['slug']]);
        }

        $postsData = [
            [
                'category_id' => 2, 'title' => 'Tân Minh Nhân cùng các đối tác nội thất ký kết hợp tác chiến lược',
                'slug' => 'tan-minh-nhan-cung-cac-doi-tac-noi-that-ky-ket-hop-tac-chien-luoc',
                'excerpt' => 'Sáng ngày 21/08/2026, Công ty CP Xây dựng Kiến trúc Tân Minh Nhân đã tổ chức Lễ ký kết hợp tác chiến lược...',
                'content' => '<p>Sáng ngày 21/08/2026, Công ty CP Xây dựng Kiến trúc Tân Minh Nhân đã tổ chức Lễ ký kết hợp tác chiến lược...</p>',
                'thumbnail' => 'posts/thumbnails/tan-minh-nhan-cung-cac-doi-tac-noi-that-ky-ket-hop-tac-chien-luoc-02.png',
                'published_at' => '2026-08-21 09:43:17', 'is_featured' => 0, 'views' => 1
            ],
            [
                'category_id' => 2, 'title' => 'Tân Minh Nhân hoàn thành sàn hầm b2 tháp Cc04 – Dự án Charmora City – Nha Trang',
                'slug' => 'tan-minh-nhan-hoan-thanh-san-ham-b2-thap-cc04-du-an-charmora-city-nha-trang',
                'excerpt' => 'Chiều 15 đến sáng 16/08/2026, Tân Minh Nhân đã hoàn thành mẻ bê tông sàn hầm B2 tòa tháp CC04...',
                'content' => '<p>Chiều 15 đến sáng 16/08/2026, Tân Minh Nhân đã hoàn thành mẻ bê tông sàn hầm B2...</p>',
                'thumbnail' => 'posts/thumbnails/tan-minh-nhan-hoan-thanh-san-ham-b2-thap-cc04-du-an-charmora-city-nha-trang-02.jpg',
                'published_at' => '2026-08-16 09:54:10', 'is_featured' => 0, 'views' => 0
            ],
            [
                'category_id' => 2, 'title' => 'Tân Minh Nhân hoàn thành đóng nắp hầm và khởi công phần thân Sun Cora Tower Đà Nẵng',
                'slug' => 'tan-minh-nhan-hoan-thanh-dong-nap-ham-va-khoi-cong-phan-than-sun-cora-tower-da-nang',
                'excerpt' => 'Chiều ngày 07/08/2026, Công ty Cổ phần Xây dựng Kiến trúc Tân Minh Nhân cùng Chủ đầu tư Tập đoàn Sun Group...',
                'content' => '<p>Chiều ngày 07/08/2026, Công ty Cổ phần Xây dựng Kiến trúc Tân Minh Nhân tổ chức lễ khởi công...</p>',
                'thumbnail' => 'posts/thumbnails/tan-minh-nhan-le-khoi-cong-sun-cora-tower-09.jpg',
                'published_at' => '2026-08-07 09:57:33', 'is_featured' => 0, 'views' => 0
            ],
            [
                'category_id' => 2, 'title' => 'Tân Minh Nhân trao tặng 300 phần quà tri ân các gia đình chính sách nhân dịp 79 năm ngày thương binh - liệt sĩ',
                'slug' => 'tan-minh-nhan-trao-tang-300-phan-qua-tri-an-cac-gia-dinh-chinh-sach-nhan-dip-79-nam-ngay-thuong-binh-liet-si',
                'excerpt' => 'Chiều ngày 25/07/2026, Công ty CP Xây dựng Kiến trúc Tân Minh Nhân phối hợp cùng UBND phường Điện Bàn Đông...',
                'content' => '<p>Chiều ngày 25/07/2026, Công ty CP Xây dựng Kiến trúc Tân Minh Nhân phối hợp trao tặng quà...</p>',
                'thumbnail' => 'posts/thumbnails/tan-minh-nhan-tri-an-gia-dinh-chinh-sach-01.jpg',
                'published_at' => '2026-07-25 10:02:27', 'is_featured' => 0, 'views' => 0
            ]
        ];

        foreach($postsData as $pst){
            Post::create($pst);
        }

        // 5. Tuyển dụng thực tế
        $careersData = [
            ['job_title' => 'Nhân viên QS', 'department' => 'Kinh tế xây dựng', 'location' => 'Đà Nẵng', 'salary_range' => 'Thoả thuận', 'description' => 'Dựa vào bản vẽ thiết kế - tính toán, bóc tách khối lượng thi công các hạng mục công trình.'],
            ['job_title' => 'Nhân viên QA/QC', 'department' => 'Quản lý chất lượng', 'location' => 'Đà Nẵng', 'salary_range' => 'Thoả thuận', 'description' => 'Phối hợp với Ban chỉ huy công trường lập kế hoạch quản lý chất lượng công trình.'],
            ['job_title' => 'Giám sát kết cấu / Hoàn thiện', 'department' => 'Giám sát', 'location' => 'Đà Nẵng', 'salary_range' => 'Thoả thuận', 'description' => 'Giám sát triển khai thi công, chịu trách nhiệm về an toàn, tiến độ, chất lượng.'],
            ['job_title' => 'Shopdrawing kết cấu / Hoàn thiện', 'department' => 'Thiết kế', 'location' => 'Đà Nẵng', 'salary_range' => 'Thoả thuận', 'description' => 'Tham gia lên kế hoạch triển khai dự án, triển khai bản vẽ thiết kế thi công từng hạng mục.']
        ];
        foreach($careersData as $car){
            Career::create(array_merge($car, [
                'deadline' => now()->addMonths(2),
                'status' => 'open'
            ]));
        }

        // 6. Đối tác thực tế
        $partnersData = [
            ['name' => 'DONGTAM', 'logo' => 'partners/01M2F1VTVAD6AJCDSVM3H7RKDE.jpg'],
            ['name' => 'DUFAGO', 'logo' => 'partners/01M2F1W7QBWMWWVSXWZ2PR0CWA.png'],
            ['name' => 'JOTUN', 'logo' => 'partners/01M2F1WKY6KVM0YDEHJ650NKWG.png'],
            ['name' => 'KNAUF', 'logo' => 'partners/01M2F1WZHDNCW7XZZTEVH4ZTMH.png'],
            ['name' => 'SUNGROUP', 'logo' => 'partners/01M2F1XDWX485YAMTPBA26M6EX.png'],
            ['name' => 'VIETCERAMICS', 'logo' => 'partners/01M2F1Z7ZDKZFVGWNSESPCBYYG.png'],
        ];
        foreach($partnersData as $ptn){
            Partner::create($ptn);
        }
    }
}