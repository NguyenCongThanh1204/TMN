<?php
namespace App\Http\Controllers;
use App\Models\{Career,Lead};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CareerController extends Controller {
 public function index(){return view('careers.index',['careers'=>Career::open()->latest()->get()]);}
 public function apply(Request $request){$data=$request->validate(['full_name'=>'required|string|max:120','email'=>'required|email|max:160','phone'=>'required|string|max:40','position'=>'required|string|max:160','cv'=>'required|file|mimes:pdf,doc,docx|max:10240','message'=>'nullable|string|max:5000','privacy'=>'accepted']); $data['attachment_path']=$request->file('cv')->store('applications','public'); Lead::create(['type'=>'career','full_name'=>$data['full_name'],'email'=>$data['email'],'phone'=>$data['phone'],'position'=>$data['position'],'attachment_path'=>$data['attachment_path'],'message'=>$data['message']??null]); return back()->with('success','Application received. Our team will review your profile.');}
}
