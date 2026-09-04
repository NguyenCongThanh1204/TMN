<?php
namespace App\Nova;
use App\Models\Project as ProjectModel;
use Laravel\Nova\Fields\{BelongsTo,Boolean,ID,Image,Number,Select,Text,Textarea,URL};
use Laravel\Nova\Resource;
class Project extends Resource {
 public static $model=ProjectModel::class; public static $title='title'; public static $search=['id','title','location','client_name']; public static $group='Content';
 public function fields($request){return [ID::make()->sortable(),Text::make('Title')->sortable()->rules('required','max:255'),Text::make('Slug')->rules('required','max:255'),BelongsTo::make('Category','category',ProjectCategory::class),Text::make('Client Name','client_name'),Text::make('Location'),Number::make('Area (m²)','area_sqm')->step(0.01),Number::make('Year'),Text::make('Structural Type','structural_type'),Text::make('Timeline'),URL::make('Cover Image','cover_image'),Textarea::make('Body Content','body_content')->alwaysShow(),Boolean::make('Featured','is_featured'),Select::make('Status')->options(['draft'=>'Draft','published'=>'Published'])->displayUsingLabels()->default('published'),];}
}
