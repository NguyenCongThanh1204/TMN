<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leader; // Nhớ use Model Leader

class LeaderController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ danh sách lãnh đạo từ CSDL
        $leaders = Leader::orderBy('level_id')->orderBy('id')->get();

        return view('about.index', compact('leaders'));
    }
}