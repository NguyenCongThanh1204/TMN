<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Hiển thị danh sách đối tác trên website
     */
    public function index()
    {
        $partners = Partner::whereNotNull('logo')
            ->latest()
            ->get();

        return view('partners.index', compact('partners'));
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
            'data'    => $partners,
        ]);
    }
}