<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category');
        $searchTerm = $request->query('search');

        // Query cơ sở: Sử dụng scopePublished() đã định nghĩa trong Model
        $query = Post::query()
            ->with('category')
            ->published();

        // Lọc theo từ khóa tìm kiếm
        if ($searchTerm) {
            $query->where('title', 'like', '%' . trim($searchTerm) . '%');
        }

        // Lọc theo danh mục
        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        // 1. Bài viết tiêu điểm: Bài mới nhất theo bộ lọc
        $featuredPost = (clone $query)->latest('published_at')->first();

        // 2. Loại trừ bài viết tiêu điểm ra khỏi danh sách phân trang bên dưới để không bị trùng lặp
        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
        }

        // 3. Top 6 bài xem nhiều nhất: Lấy toàn hệ thống
        $topViewedPosts = Post::query()
            ->with('category')
            ->published()
            ->orderByDesc('views')
            ->take(6)
            ->get();

        // 4. Danh sách bài viết phân trang (9 bài/trang, bắt đầu từ bài thứ 2)
        $posts = $query->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        // 5. Danh sách danh mục để làm tab lọc
        $categories = PostCategory::all();

        return view('news.index', compact(
            'posts',
            'featuredPost',
            'topViewedPosts',
            'categories',
            'selectedCategory',
            'searchTerm'
        ));
    }

    public function show(Post $post)
    {
        // Kiểm tra nếu bài viết chưa đến ngày xuất bản thì chặn xem
        if (!$post->published_at || $post->published_at > now()) {
            abort(404);
        }

        // Tự động tăng lượt xem
        $post->increment('views');

        $post->load('category');

        // Lấy 3 bài viết liên quan cùng chuyên mục
        $relatedPosts = Post::query()
            ->with('category')
            ->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact(
            'post',
            'relatedPosts'
        ));
    }
}