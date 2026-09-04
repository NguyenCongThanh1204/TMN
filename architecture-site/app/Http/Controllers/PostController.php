<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()
            ->with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');

        $query = Post::query()
    ->with('category')
    ->published()
    ->latest('published_at');

        $featuredPost = Post::query()
            ->with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->first();

        $posts = $query
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact(
            'posts',
            'featuredPost'
        ));
    }


    public function show(Post $post)
    {
        $post->load('category');

        $relatedPosts = Post::query()
            ->with('category')
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact(
            'post',
            'relatedPosts'
        ));
    }
}