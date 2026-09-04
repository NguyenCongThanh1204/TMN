<?php
namespace App\Http\Controllers;
use App\Models\Lead;
use Illuminate\Http\Request;
class ContactController extends Controller {
 public function index(){return view('contact.index');}
 public function store(Request $request)
{
    $validated = $request->validate([
        'full_name' => ['required', 'string', 'max:255'],

        'phone' => ['required', 'string', 'max:50'],

        'email' => ['required', 'email', 'max:255'],

        'project_type' => ['required', 'string', 'max:100'],

        'estimated_budget' => ['nullable', 'string', 'max:100'],

        'project_location' => ['nullable', 'string', 'max:255'],

        'timeline' => ['nullable', 'string', 'max:100'],

        'service_required' => ['nullable', 'string', 'max:100'],

        'attachment' => [
            'nullable',
            'file',
            'mimes:pdf,jpg,jpeg,png,doc,docx,dwg,zip',
            'max:10240',
        ],

        'message' => ['required', 'string', 'max:10000'],

        'privacy' => ['required'],
    ]);


    if ($request->hasFile('attachment')) {

        $validated['attachment'] = $request
            ->file('attachment')
            ->store('inquiries', 'public');

    }


    // Phần này sẽ lưu vào bảng leads của bạn.
    //
    // Ví dụ:
    //
    // Lead::create($validated);


    return back()->with(
        'success',
        'Thank you. Our team will contact you shortly.'
    );
}
}
