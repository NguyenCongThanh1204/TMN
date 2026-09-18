<?php

namespace App\Nova;

use App\Models\Post as Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;

class Post extends Resource
{
    public static $model = Model::class;

    public static $title = 'title';

    public static $group = 'Content';

    public static $search = [
        'id', 'title', 'slug', 'author_name',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Category', 'category', PostCategory::class)
                ->sortable()
                ->rules('required'),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),

            // Tự động tạo slug theo Title
            Slug::make('Slug')
                ->from('Title')
                ->rules('required', 'max:255')
                ->creationRules('unique:posts,slug')
                ->updateRules('unique:posts,slug,{{resourceId}}'),

            // =========================================================
            // 🎯 ẢNH ĐẠI DIỆN CHÍNH (Kèm Caption & Alt SEO)
            // =========================================================
            Image::make('Thumbnail')
                ->disk('public')
                ->path('posts')
                ->prunable(),

            Text::make('Thumbnail Caption', 'thumbnail_caption')
                ->help('Ghi chú chữ nhỏ in nghiêng hiển thị ngay dưới ảnh chính')
                ->nullable()
                ->hideFromIndex(),

            Text::make('Thumbnail Alt', 'thumbnail_alt')
                ->help('Mô tả hình ảnh phục vụ SEO Google')
                ->nullable()
                ->hideFromIndex(),

            // Cột lượt xem: Chỉ xem và sort trên bảng, không cho chỉnh sửa tay
            Number::make('Views', 'views')
                ->sortable()
                ->exceptOnForms()
                ->displayUsing(fn ($value) => number_format($value ?? 0)),

            Textarea::make('Excerpt')
                ->rows(3)
                ->nullable()
                ->hideFromIndex(),

            // Trình soạn thảo định dạng bài viết
            Trix::make('Content')
                ->alwaysShow()
                ->rules('required'),

            // =========================================================
            // 🎯 BỘ SƯU TẬP ẢNH (GALLERY)
            // =========================================================
            Code::make('Gallery (JSON)', 'gallery')
                ->json()
                ->nullable()
                ->hideFromIndex()
                ->help('Danh sách ảnh bổ sung. Ví dụ: [{"image":"posts/anh-1.jpg","caption":"Mặt tiền toà nhà","alt":"Phối cảnh"}]'),

            // =========================================================
            // THÔNG TIN TÁC GIẢ & NGÀY XUẤT BẢN
            // =========================================================
            Text::make('Author Name', 'author_name')
                ->nullable()
                ->hideFromIndex(),

            Text::make('Author Role', 'author_role')
                ->nullable()
                ->hideFromIndex(),

            DateTime::make('Published At', 'published_at')
                ->sortable()
                ->nullable(),
        ];
    }
}