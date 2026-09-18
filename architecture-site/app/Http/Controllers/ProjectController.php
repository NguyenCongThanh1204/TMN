<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Danh sách dự án
     */
    public function index(Request $request)
    {
        $categories = ProjectCategory::query()
            ->orderBy('name')
            ->get();

        // 1. Lấy cố định các dự án tiêu biểu cho Hero Vòng xoay 3D (ví dụ lấy tối đa 7 dự án)
        $wheelProjects = Project::query()
            ->with('category')
            ->where('status', 'published')
            ->where('is_featured', 1)
            ->latest()
            ->limit(7)
            ->get();

        // Nếu không có đủ dự án featured nào, lấy tạm các dự án mới nhất để vòng xoay không bị trống
        if ($wheelProjects->isEmpty()) {
            $wheelProjects = Project::query()
                ->with('category')
                ->where('status', 'published')
                ->latest()
                ->limit(7)
                ->get();
        }

        // 2. Truy vấn danh sách dự án cho phần lưới bên dưới (có phân trang 10 dự án và lọc theo yêu cầu)
        $projects = Project::query()
            ->with('category')
            ->where('status', 'published');

        if ($request->filled('category')) {
            $categorySlugOrId = $request->category;
            $projects->where(function ($query) use ($categorySlugOrId) {
                $query->where('category_id', $categorySlugOrId)
                      ->orWhereHas('category', function ($q) use ($categorySlugOrId) {
                          $q->where('slug', $categorySlugOrId)
                            ->orWhere('id', $categorySlugOrId);
                      });
            });
        }

        if ($request->filled('year')) {
            $projects->where('year', $request->year);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $projects->where(function ($query) use ($search) {
                $query
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $projects = $projects
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $years = Project::query()
            ->where('status', 'published')
            ->whereNotNull('year')
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('projects.index', compact(
            'projects',
            'categories',
            'years',
            'wheelProjects' // Truyền biến này ra view
        ));
    }

    /**
     * Chi tiết dự án
     */
    public function show(Project $project)
    {
        // Chặn nếu dự án chưa publish (trả về 404)
        if ($project->status !== 'published') {
            abort(404);
        }

        // ĐÃ SỬA: Bỏ 'media' của Curator, chỉ nạp 'category'
        $project->load(['category']);

        $relatedProjects = Project::query()
            ->with('category')
            ->where('status', 'published')
            ->where('id', '!=', $project->id)
            ->when(
                $project->category_id,
                fn ($query) =>
                    $query->where('category_id', $project->category_id)
            )
            ->latest()
            ->limit(3)
            ->get();

        return view('projects.show', compact(
            'project',
            'relatedProjects'
        ));
    }
}