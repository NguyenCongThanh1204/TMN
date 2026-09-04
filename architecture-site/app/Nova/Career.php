<?php
namespace App\Nova;
use App\Models\Career as Model;
use Laravel\Nova\Fields\{Date,ID,Select,Text,Textarea}; use Laravel\Nova\Resource;
class Career extends Resource { public static $model=Model::class; public static $title='job_title'; public static $group='People'; public static $search=['id','job_title','department','location']; public function fields($request){return [ID::make()->sortable(),Text::make('Job Title','job_title')->rules('required'),Text::make('Department'),Text::make('Location'),Text::make('Salary Range','salary_range'),Textarea::make('Description')->rules('required'),Date::make('Deadline'),Select::make('Status')->options(['open'=>'Open','closed'=>'Closed'])->displayUsingLabels()];} }
