<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $latestPosts = Post::query()
            ->leftJoin('post_categories as categories', 'categories.id', '=', 'posts.category_id')
            ->select([
                'posts.id',
                'posts.category_id',
                'posts.title',
                'posts.slug',
                'posts.thumbnail',
                'posts.published_at',
                'categories.name as category_name',
            ])
            ->published()
            ->latest('published_at')
            ->limit(8)
            ->get();

        $partners = Partner::query()
            ->select(['id', 'name', 'logo'])
            ->whereNotNull('logo')
            ->latest()
            ->get();

        $displayProjects = Project::query()
            ->leftJoin('project_categories as categories', 'categories.id', '=', 'projects.category_id')
            ->select([
                'projects.id',
                'projects.category_id',
                'projects.title',
                'projects.slug',
                'projects.location',
                'projects.year',
                'projects.area_sqm',
                'projects.cover_image',
                'projects.status',
                'projects.is_featured',
                'projects.updated_at',
                'projects.created_at',
                'categories.name as category_name',
            ])
            ->published()
            ->featured()
            ->latest('projects.updated_at')
            ->limit(5)
            ->get();

        if ($displayProjects->isEmpty()) {
            $displayProjects = Project::query()
                ->leftJoin('project_categories as categories', 'categories.id', '=', 'projects.category_id')
                ->select([
                    'projects.id',
                    'projects.category_id',
                    'projects.title',
                    'projects.slug',
                    'projects.location',
                    'projects.year',
                    'projects.area_sqm',
                    'projects.cover_image',
                    'projects.status',
                    'projects.is_featured',
                    'projects.updated_at',
                    'projects.created_at',
                    'categories.name as category_name',
                ])
                ->published()
                ->latest('projects.created_at')
                ->limit(5)
                ->get();
        }

        return view('home.index', compact('displayProjects', 'latestPosts', 'partners'));
    }
}
