<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\{ProjectCategory, Project, ProjectMedia, PostCategory, Post, Career, User, Partner, Leader};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Vô hiệu hóa kiểm tra khóa ngoại để tiến hành truncate và seed an toàn
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Xóa dữ liệu cũ của các bảng chính để có thể chạy php artisan db:seed nhiều lần không bị trùng lặp ID
        $tables = [
            'project_media',
            'projects',
            'project_categories',
            'post_media',
            'posts',
            'post_categories',
            'leaders',
            'partners',
            'careers',
            'users',
        ];

        foreach ($tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        // 1. Tạo tài khoản đăng nhập admin cố định
        User::firstOrCreate(
            ['email' => 'nct120404@gmail.com'],
            [
                'name' => 'Nguyễn Công Thành',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed bảng Users gốc (nếu có ID dự phòng từ SQL)
        

        // 3. Danh mục dự án (Project Categories)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `project_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Tổng thầu thi công', 'tong-thau-thi-cong', '2026-09-13 21:15:59', '2026-09-13 21:15:59'),
	(2, 'Thi công hoàn thiện', 'thi-cong-hoan-thien', '2026-09-13 21:16:45', '2026-09-13 21:16:45'),
	(3, 'Thi công kết cấu', 'thi-cong-ket-cau', '2026-09-13 21:17:11', '2026-09-13 21:17:11');
SQL
        );

        // 4. Dự án thực tế (Projects)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `projects` (`id`, `category_id`, `title`, `slug`, `client_name`, `location`, `area_sqm`, `year`, `structural_type`, `timeline`, `cover_image`, `body_content`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Văn phòng Tân Minh Nhân', 'van-phong-tan-minh-nhan', 'Tân Minh Nhân', 'Đà Nẵng', '01 tầng hầm, 4 tầng cao, tổng diện tích 3.200m²', NULL, 'Tổng thầu Thiết kế & Thi công', NULL, 'projects/van-phong-tan-minh-nhan/covers/anh-tmn.jpg', 'Là tòa nhà văn phòng với trang thiết bị hiện đại, đánh dấu bước phát triển của Tân Minh Nhân trong nhiều năm qua, tọa lạc tại số 246 - 250 Lê Văn Hiến – TP.Đà Nẵng.\nBằng kiến thức, kinh nghiệm và năng lực mạnh mẽ trong lĩnh vực thi công cùng hệ thống quản lý chất lượng hiệu quả cao, thương hiệu Tân Minh Nhân khẳng định vị thế là Tổng thầu thi công các dự án quy mô lớn.\nVới vai trò Tổng thầu thi công, chúng tôi đảm nhận toàn bộ công tác móng, kết cấu phần hầm, kết cấu phần thân cho đến hoàn thiện nội thất, MEP, nhôm kính, phòng cháy chữa cháy và hạ tầng cảnh quan. Chúng tôi đặc biệt coi trọng nhiệm vụ tư vấn, mang tới Chủ đầu tư những ý kiến chuyên sâu và toàn diện, đồng thời đề xuất các biện pháp kỹ thuật, giải pháp thi công, vật liệu tối ưu. Với mô hình quản lý Tinh – Gọn, Tân Minh Nhân linh hoạt đáp ứng những yêu cầu khắt khe nhất từ Chủ đầu tư song song với tuân thủ nghiêm ngặt mọi quy định về an toàn lao động.', 1, 'published', '2026-09-14 20:18:20', '2026-09-17 02:22:26'),
	(2, 1, 'Đại học Văn Lang', 'dai-hoc-van-lang', 'Trường Đại học Văn Lang', 'TP Hồ Chí Minh', '9 tầng, 10.000m²', NULL, 'Tổng thầu Thiết kế & Thi công', NULL, 'projects/dai-hoc-van-lang/covers/anh-van-lang.jpg', 'Đại học Văn Lang tọa lạc trên một con đường nằm khiêm tốn giữa lòng Quận 1 sôi động, mang tên nhà chí sĩ yêu nước Nguyễn Khắc Nhu.\nTrong 18 năm, đây là nơi làm việc của văn phòng Hiệu bộ và nơi học tập của sinh viên trong các khoa: Môi trường & Công nghệ Sinh học, Kiến trúc, Xây dựng, Ngoại ngữ, Kỹ thuật, Công nghệ Thông tin.', 0, 'published', '2026-09-14 20:19:23', '2026-09-17 00:38:23'),
	(3, 1, 'Biệt thự nhà phố Euro Village Đà Nẵng', 'biet-thu-nha-pho-euro-village-da-nang', 'Biệt thự Euro 1234', 'Đà Nẵng', '01 tầng hầm, 4 tầng cao, tổng diện tích 3.200m²', NULL, 'Tổng thầu Thiết kế & Thi công', NULL, 'projects/biet-thu-nha-pho-euro-village-da-nang/covers/euro-village.jpg', NULL, 0, 'published', '2026-09-14 20:21:34', '2026-09-17 00:38:22'),
	(4, 1, 'Trường mầm non Tuệ Đức Đà Nẵng', 'truong-mam-non-tue-duc-da-nang', 'Công Ty Cổ phần Đầu tư Xây dựng & Phát triển Hạ tầng Nam Việt Á', 'Đà Nẵng', '03 tầng, tổng diện tích 5.000m²', NULL, 'Tổng thầu Thiết kế & Thi công', NULL, 'projects/truong-mam-non-tue-duc-da-nang/covers/tueduc.jpg', NULL, 0, 'published', '2026-09-14 20:22:42', '2026-09-17 00:38:24'),
	(5, 2, 'SUNSET TOWN PHÚ QUỐC', 'sunset-town-phu-quoc', 'Tập đoàn Sun Group', 'Phú Quốc', 'Tổng diện tích 39,3ha', NULL, 'Thi công hoàn thiện', NULL, 'projects/sunset-town-phu-quoc/covers/sunset-town-phu-quoc-01.jpg', NULL, 1, 'published', '2026-09-14 23:29:31', '2026-09-17 00:38:19'),
	(6, 2, 'VUI-FEST BAZAAR PHÚ QUỐC', 'vui-fest-bazaar-phu-quoc', 'Tập đoàn Sun Group', 'Phú Quốc', 'Tổng diện tích 1.115m2', NULL, 'Thi công hoàn thiện', NULL, 'projects/vui-fest-bazaar-phu-quoc/covers/vui-fest-bazaar-phu-quoc-02.jpg', NULL, 0, 'published', '2026-09-14 23:32:53', '2026-09-17 01:30:32'),
	(7, 1, 'LA FESTA PHÚ QUỐC – CURIO', 'la-festa-phu-quoc-curio', 'Tập đoàn Sun Group', 'Phú Quốc', '200 phòng', NULL, 'Thi công hoàn thiện', 'Hoàn thành', 'projects/la-festa-phu-quoc-curio/covers/la-festa-phu-quoc-curio.jpg', NULL, 1, 'published', '2026-09-14 23:44:07', '2026-09-17 02:22:12'),
	(8, 2, 'SUN GRAND CITY HILLSIDE RESIDENCE PHÚ QUỐC', 'sun-grand-city-hillside-residence-phu-quoc', 'Tập đoàn Sun Group', 'Phú Quốc', '8 tòa Parcel, 6 tòa cao 18 tầng, 2 tòa cao 15 tầng', 0, 'Thi công hoàn thiện', NULL, 'projects/sun-grand-city-hillside-residence-phu-quoc/covers/sun-grand-city-hillside-residence-phu-quoc-01-v1.jpg', NULL, 1, 'published', '2026-09-14 23:45:52', '2026-09-17 02:22:11'),
	(9, 3, 'Sân bay quốc tế Phú Quốc', 'san-bay-quoc-te-phu-quoc', 'Tập đoàn Sun Group', 'Phú Quốc', 'có tổng diện tích 1.050 ha', NULL, 'Thi công kết cấu', NULL, 'projects/san-bay-quoc-te-phu-quoc/covers/san-bay-phu-quoc-01.png', 'Là dự án trọng điểm phục vụ APEC 2027 tại phú quốc, dự án đầu tư mở rộng cảng hàng không quốc tế phú quốc do tập đoàn sun group là nhà đầu tư đang được triển khai với tiến độ thần tốc.', 0, 'published', '2026-09-17 00:54:09', '2026-09-17 02:22:09'),
	(10, 2, 'New World Phú Quốc Resort', 'new-world-phu-quoc-resort', 'Tập đoàn Sun Group', 'Phú Quốc', '375 căn biệt thự', NULL, 'Thi công hoàn thiện', NULL, 'projects/new-world-phu-quoc-resort/covers/phu-quoc-resort-01.png', 'Khu nghỉ dưỡng New World Phú Quốc là khu nghỉ dưỡng đầu tiên của thương hiệu New World tại Việt Nam.', 1, 'published', '2026-09-17 01:27:32', '2026-09-17 01:33:33'),
	(11, 2, 'Bà Nà Hill', 'ba-na-hill', 'Tập đoàn Sun Group', 'Đà Nẵng', NULL, NULL, 'Thi công hoàn thiện', NULL, 'projects/ba-na-hill/covers/ba-na-hill-01.jpg', 'Nằm ở độ cao 1.487m so với mực nước biển, Sun World Ba Na Hills được mệnh danh là “chốn bồng lai tiên cảnh”.', 1, 'published', '2026-09-17 01:29:33', '2026-09-17 01:32:57');
SQL
        );

        // 5. Thư viện hình ảnh dự án (Project Media)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `project_media` (`id`, `project_id`, `file_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 5, 'projects/sunset-town-phu-quoc/gallery/sunset-town-phu-quoc-02-v1.jpg', NULL, 0, '2026-09-14 23:31:07', '2026-09-14 23:36:01'),
	(2, 6, 'projects/vui-fest-bazaar-phu-quoc/gallery/vui-fest-bazaar-phu-quoc-01-v1.jpg', NULL, 0, '2026-09-14 23:33:16', '2026-09-14 23:36:41'),
	(3, 7, 'projects/la-festa-phu-quoc-curio/gallery/la-festa-phu-quoc-curio-02.png', NULL, 0, '2026-09-14 23:44:27', '2026-09-14 23:44:27'),
	(4, 8, 'projects/sun-grand-city-hillside-residence-phu-quoc/gallery/sun-grand-city-hillside-residence-phu-quoc-02-v1.jpg', NULL, 0, '2026-09-14 23:46:34', '2026-09-14 23:46:34'),
	(5, 9, 'projects/san-bay-quoc-te-phu-quoc/gallery/san-bay-phu-quoc-02.png', NULL, 0, '2026-09-17 00:54:35', '2026-09-17 00:54:35'),
	(6, 10, 'projects/new-world-phu-quoc-resort/gallery/phu-quoc-resort-02-v1.jpg', NULL, 0, '2026-09-17 01:28:21', '2026-09-17 01:28:21'),
	(7, 11, 'projects/ba-na-hill/gallery/ba-na-hill-02-v1.jpg', NULL, 0, '2026-09-17 01:30:07', '2026-09-17 01:30:07');
SQL
        );

        // 6. Danh mục bài viết (Post Categories)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `post_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Tin Công Trình', 'tin-cong-trinh', '2026-09-12 02:44:40', '2026-09-12 02:44:40'),
	(2, 'Tin công Ty', 'tin-cong-ty', '2026-09-12 02:44:57', '2026-09-12 02:44:57');
SQL
        );

        // 7. Bài viết (Posts)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `posts` (`id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `thumbnail`, `thumbnail_caption`, `thumbnail_alt`, `gallery`, `author_name`, `author_role`, `published_at`, `created_at`, `updated_at`, `views`, `is_featured`) VALUES
	(5, 2, 'Tân Minh Nhân cùng các đối tác nội thất ký kết hợp tác chiến lược', 'tan-minh-nhan-cung-cac-doi-tac-noi-that-ky-ket-hop-tac-chien-luoc', 'Sáng ngày 21/08/2026, Công ty CP Xây dựng Kiến trúc Tân Minh Nhân đã tổ chức Lễ ký kết hợp tác chiến lược với các đối tác trong lĩnh vực sản xuất và thi công nội thất.', '<p>Sáng ngày 21/08/2026, Công ty CP Xây dựng Kiến trúc Tân Minh Nhân đã tổ chức Lễ ký kết hợp tác chiến lược với các đối tác trong lĩnh vực sản xuất và thi công nội thất.</p>', 'posts/thumbnails/tan-minh-nhan-cung-cac-doi-tac-noi-that-ky-ket-hop-tac-chien-luoc-02.png', NULL, NULL, NULL, NULL, NULL, '2026-08-21 09:43:17', '2026-09-12 02:46:12', '2026-09-12 02:46:12', 1, 0);
SQL
        );

        // 8. Ban lãnh đạo (Leaders)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `leaders` (`id`, `level_id`, `name`, `title`, `image`, `bio`, `email`, `position_order`, `created_at`, `updated_at`) VALUES
	(1, 1, 'NHAN VĂN CHIẾN', 'Chủ tịch HĐQT', 'leaders/01M2F0K9YEZ49V47KMNJNKG67D.jpg', 'Ông là người mạnh mẽ, quyết đoán và có tầm nhìn rộng, đặc biệt luôn coi trọng chữ tín trong kinh doanh.', NULL, 0, '2026-09-13 20:50:28', '2026-09-13 20:50:28'),
	(2, 2, 'TRẦN HỮU PHÚC', 'Tổng Giám đốc', 'leaders/01M2F0KYPTEJFBT5XP9S0T8QQ2.png', NULL, NULL, 0, '2026-09-13 20:50:49', '2026-09-13 20:50:49'),
	(3, 2, 'NGUYỄN VĂN CHÂU', 'Phó Tổng Giám đốc', 'leaders/01M2F0MTAZJK37B56T15ME15KS.jpg', 'Ông là người có kinh nghiệm sâu rộng trong ngành xây dựng.', NULL, 0, '2026-09-13 20:51:17', '2026-09-13 20:51:17'),
	(4, 2, 'PHAN THANH ĐỨC', 'Phó Tổng Giám đốc', 'leaders/01M2F0R7V0FZ4NG8B3XR1GHTP4.jpg', 'Ông là người rất nghiêm khắc với bản thân.', NULL, 0, '2026-09-13 20:53:09', '2026-09-13 20:53:09'),
	(5, 2, 'LÊ VĂN HẢI', 'Phó Tổng Giám đốc', 'leaders/01M2F0S34Z0EB9ZDHHZ74KX0AC.jpg', 'Công việc bộ phận ông đang đảm nhiệm yêu cầu thực hiện theo các nguyên tắc.', NULL, 0, '2026-09-13 20:53:37', '2026-09-13 20:53:37'),
	(6, 2, 'LÊ MINH NGHỊ', 'Phó Tổng Giám đốc', 'leaders/01M2F0STCH40NSANY2C1GV5KWT.png', NULL, NULL, 0, '2026-09-13 20:54:01', '2026-09-13 20:54:01'),
	(7, 2, 'HỒ THỊ MỸ PHƯỢNG', 'Phó Tổng Giám đốc', 'leaders/01M2F0TB4ATKXV50EQD2K8PZ0J.jpg', 'Bà là người năng nổ, nhiệt huyết, hết mình vì công việc.', NULL, 0, '2026-09-13 20:54:18', '2026-09-13 20:54:18'),
	(8, 3, 'PHẠM MINH ĐỨC', 'Trợ lý Chủ tịch HĐQT', 'leaders/01M2F0VAAFQRG4A7YWWPKNARX2.jpg', 'Là một người tận tụy, hết lòng vì công việc.', NULL, 0, '2026-09-13 20:54:50', '2026-09-13 20:54:50'),
	(9, 3, 'MẠC NHƯ MINH', 'Trợ lý Chủ tịch HĐQT', 'leaders/01M2F0W52PJQ1D9392HKYYBFY2.jpg', 'Ông là người có kinh nghiệm trong ngành công nghệ thông tin.', NULL, 0, '2026-09-13 20:55:17', '2026-09-13 20:55:17'),
	(10, 3, 'PHẠM THỊ LIỄU', 'Giám đốc khối Tài chính - Kế toán', 'leaders/01M2F0WZF85CNJ1CQDR4P1A6EK.jpg', 'Tham gia vào Tân Minh Nhân từ những ngày đầu tiên.', NULL, 0, '2026-09-13 20:55:45', '2026-09-13 20:55:45'),
	(11, 3, 'LÊ VIẾT THÁI', 'Giám đốc Khối Kinh tế - Kế hoạch', 'leaders/01M2F0XQBTD2V5A3KPW3VN834K.jpg', 'Luôn đặt kế hoạch và mục tiêu rõ ràng.', NULL, 0, '2026-09-13 20:56:06', '2026-09-13 20:56:06');
SQL
        );

        // 9. Đối tác (Partners)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `partners` (`id`, `created_at`, `updated_at`, `name`, `logo`) VALUES
	(1, '2026-09-13 21:12:36', '2026-09-13 21:12:36', 'DONGTAM', 'partners/01M2F1VTVAD6AJCDSVM3H7RKDE.jpg'),
	(2, '2026-09-13 21:12:49', '2026-09-13 21:12:49', 'DUFAGO', 'partners/01M2F1W7QBWMWWVSXWZ2PR0CWA.png'),
	(3, '2026-09-13 21:13:01', '2026-09-13 21:13:01', 'JOTUN', 'partners/01M2F1WKY6KVM0YDEHJ650NKWG.png'),
	(4, '2026-09-13 21:13:13', '2026-09-13 21:13:13', 'KNAUF', 'partners/01M2F1WZHDNCW7XZZTEVH4ZTMH.png'),
	(5, '2026-09-13 21:13:28', '2026-09-13 21:13:28', 'SUNGROUP', 'partners/01M2F1XDWX485YAMTPBA26M6EX.png'),
	(6, '2026-09-13 21:13:41', '2026-09-14 21:14:27', 'VIETCERAMICS', 'partners/01M2F1Z7ZDKZFVGWNSESPCBYYG.png');
SQL
        );

        // 10. Tuyển dụng (Careers)
        DB::unprepared(
            <<<'SQL'
INSERT INTO `careers` (`id`, `job_title`, `department`, `location`, `salary_range`, `description`, `deadline`, `status`, `created_at`, `updated_at`, `cover_image`) VALUES
	(1, 'Nhân viên QS', 'Kinh tế xây dựng', 'Đà Nẵng', 'Thoả thuận', 'Dựa vào bản vẽ thiết kế - tính toán, bóc tách khối lượng thi công các hạng mục công trình.', '2026-11-18 00:00:00', 'open', '2026-09-13 21:20:00', '2026-09-13 21:20:00', NULL);
SQL
        );

        // Bật lại kiểm tra khóa ngoại sau khi seed xong
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
