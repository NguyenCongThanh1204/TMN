<?php
namespace App\Nova;
use App\Models\PostCategory as Model;
use Laravel\Nova\Fields\{ID,Text}; use Laravel\Nova\Resource;
class PostCategory extends Resource { public static $model=Model::class; public static $title='name'; public static $group='Content'; public function fields($request){return [ID::make()->sortable(),Text::make('Name')->rules('required'),Text::make('Slug')->rules('required')];} }
