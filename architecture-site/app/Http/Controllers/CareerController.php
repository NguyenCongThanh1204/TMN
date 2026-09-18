<?php

namespace App\Http\Controllers;

use App\Models\{Career, Lead};
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        return view('careers.index', [
            'careers' => Career::open()->latest()->get()
        ]);
    }

    public function show(Career $career)
    {
        // Kiểm tra xem tin có đang đóng hoặc đã qua ngày hết hạn (tính đến hết ngày 23:59:59)
        $isClosed = ($career->status !== 'open') || ($career->deadline && $career->deadline->endOfDay()->isPast());

        if ($isClosed) {
            abort(404);
        }

        return view('careers.show', compact('career'));
    }

    public function apply(Request $request)
    {
        $data = $request->validate([
            'career_id' => 'nullable|exists:careers,id',
            'full_name' => 'required|string|max:120',
            'email'     => 'required|email|max:160',
            'phone'     => 'required|string|max:40',
            'position'  => 'required|string|max:160',
            'cv'        => 'required|file|mimes:pdf,doc,docx|max:10240',
            'message'   => 'nullable|string|max:5000',
            'privacy'   => 'accepted'
        ]);

        // Nếu form gửi kèm career_id, kiểm tra xem tin còn nhận hồ sơ không
        if (!empty($data['career_id'])) {
            $career = Career::find($data['career_id']);
            if ($career && ($career->status !== 'open' || ($career->deadline && $career->deadline->endOfDay()->isPast()))) {
                return back()->withErrors(['career' => 'Vị trí tuyển dụng này đã hết hạn nhận hồ sơ.'])->withInput();
            }
        }

        $data['attachment_path'] = $request->file('cv')->store('applications', 'public');

        Lead::create([
            'type'            => 'career',
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'position'        => $data['position'],
            'attachment_path' => $data['attachment_path'],
            'message'         => $data['message'] ?? null
        ]);

        return back()->with('success', 'Hồ sơ ứng tuyển đã được gửi thành công. Chúng tôi sẽ liên hệ sớm nhất!');
    }
}