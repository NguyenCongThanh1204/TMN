<?php
namespace App\Nova;
use App\Models\ProjectMedia as Model;
use Laravel\Nova\Fields\{BelongsTo,ID,Number,Select,Text}; use Laravel\Nova\Resource;
class ProjectMedia extends Resource { public static $model=Model::class; public static $title='path'; public static $group='Content'; public function fields($request){return [ID::make()->sortable(),BelongsTo::make('Project'),Text::make('Path')->rules('required'),Select::make('Type')->options(['image'=>'Image','video'=>'Video','plan'=>'Plan','model'=>'3D Model'])->displayUsingLabels(),Text::make('Title'),Text::make('Alt Text','alt_text'),Number::make('Sort Order','sort_order')];} }
