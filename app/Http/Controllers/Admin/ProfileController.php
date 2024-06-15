<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ProfileController extends Controller
{
    const PATH_VIEW = "admin.profile.";
    public function index() {
        return view(self::PATH_VIEW . __FUNCTION__);
    }
    public function edit() {
        return view(self::PATH_VIEW . __FUNCTION__);
    }
    public function update(Request $request) {
        $user = Auth::user();
        $data = [
            "name" => $request->input("name"),
            "phone" => $request->input("phone"),
            "address" => $request->input("address"),
            "description" => $request->input("description"),
        ];
        if($request->hasFile('image')) {
            //Lưu trữ ảnh này vào storage
            $data['image'] = Storage::put("profile", $request->file('image'));
        }
        $currentImage = $user->image;
        $user->update($data);
        //xoá ảnh trong storage
        if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
            Storage::delete($currentImage);
        }
        return back();
       
    }
}
