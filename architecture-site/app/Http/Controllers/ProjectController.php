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

        $projects = Project::query()
            ->with('category')
            ->where('status', 'published');

        /*
        |--------------------------------------------------------------------------
        | Lọc danh mục
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {
            $projects->where('category_id', $request->category);
        }

        /*
        |--------------------------------------------------------------------------
        | Lọc năm
        |--------------------------------------------------------------------------
        */
        if ($request->filled('year')) {
            $projects->where('year', $request->year);
        }

        /*
        |--------------------------------------------------------------------------
        | Tìm kiếm
        |--------------------------------------------------------------------------
        */
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
            ->paginate(9)
            ->withQueryString();

        // Đã sửa: thay published() thành where('status', 'published')
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
            'years'
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

        $project->load([
            'category',
            'media',
        ]);

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