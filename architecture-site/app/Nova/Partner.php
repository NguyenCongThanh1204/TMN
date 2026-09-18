<?php

namespace App\Nova;

use App\Models\Partner as Model;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Partner extends Resource
{
    public static $model = Model::class;

    public static $title = 'name';

    public static $group = 'Content';

    public static $search = [
        'id', 'name',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Tên đối tác', 'name')
                ->rules('required', 'max:255')
                ->sortable(),

            Image::make('Logo', 'logo')
                ->disk('public')
                ->path('partners')
                ->prunable()
                ->rules('required'),

            Text::make('Website đối tác', 'website_url')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Thứ tự ưu tiên', 'sort_order')
                ->default(0)
                ->sortable(),

            Boolean::make('Hiển thị', 'is_active')
                ->default(true)
                ->sortable(),
        ];
    }
}