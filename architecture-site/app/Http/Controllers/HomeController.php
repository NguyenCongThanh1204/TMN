<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\ProjectCategory;

class HomeController extends Controller
{
    public function __invoke()
    {
        /*
        |--------------------------------------------------------------------------
        | FEATURED PROJECTS
        |--------------------------------------------------------------------------
        */

       $featuredProjects = Project::query()
        ->with('category')
        ->where('status', 'published')
        ->latest('created_at') // Hoặc ->orderByDesc('year')->latest('created_at')
        ->take(6)              // Lấy 6 dự án mới nhất
        ->get();


        /*
        |--------------------------------------------------------------------------
        | PROJECT CATEGORIES
        |--------------------------------------------------------------------------
        */

        $projectCategories = ProjectCategory::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | LATEST NEWS
        |--------------------------------------------------------------------------
        */

        $latestPosts = Post::query()
            ->with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | NEWS CATEGORIES
        |--------------------------------------------------------------------------
        */

        $newsCategories = PostCategory::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | HOME VIEW
        |--------------------------------------------------------------------------
        */

        return view('home.index', compact(
            'featuredProjects',
            'projectCategories',
            'latestPosts',
            'newsCategories'
        ));
    }
}