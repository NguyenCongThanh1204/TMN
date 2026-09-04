<?php
namespace App\Nova;
use App\Models\ProjectCategory as Model;
use Laravel\Nova\Fields\{ID,Text}; use Laravel\Nova\Resource;
class ProjectCategory extends Resource { public static $model=Model::class; public static $title='name'; public static $group='Content'; public static $search=['id','name','slug']; public function fields($request){return [ID::make()->sortable(),Text::make('Name')->rules('required'),Text::make('Slug')->rules('required')];} }
