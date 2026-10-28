<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Contracts\View\View;

class PartnerController extends Controller
{
    /**
     * Hiển thị danh sách đối tác trên website
     */
    public function index(): View
    {
        $partners = Partner::whereNotNull('logo')
            ->latest()
            ->get(['id', 'name', 'logo']);

        return view('partners.index', ['partners' => $partners]);
    }

    /**
     * Lấy dữ liệu dạng JSON (nếu gọi từ Frontend React/Vue/AlpineJS)
     */
    public function apiList()
    {
        $partners = Partner::whereNotNull('logo')
            ->latest()
            ->get(['id', 'name', 'logo']);

        return response()->json([
            'success' => true,
            'data' => $partners,
        ]);
    }
}
