<?php
namespace App\Nova;
use App\Models\Post as Model;
use Laravel\Nova\Fields\{BelongsTo,DateTime,ID,Text,Textarea}; use Laravel\Nova\Resource;
class Post extends Resource { public static $model=Model::class; public static $title='title'; public static $group='Content'; public static $search=['id','title','slug','author_name']; public function fields($request){return [ID::make()->sortable(),BelongsTo::make('Category','category',PostCategory::class),Text::make('Title')->rules('required'),Text::make('Slug')->rules('required'),Textarea::make('Excerpt'),Textarea::make('Content')->alwaysShow()->rules('required'),Text::make('Thumbnail'),Text::make('Author Name','author_name'),Text::make('Author Role','author_role'),DateTime::make('Published At','published_at')];} }
