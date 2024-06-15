<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    const PATH_VIEW = "admin.products.catalogues.";
    const PATH_UPDATE = "catalogues";

    function index(Request $request)
    {
        $status = $request->input('status');
        if ($status == "active") {
            $data = Catalogue::query()->where("is_active", 1)->latest("id")->get();
        } else if ($status == "lisenced") {
            $data = Catalogue::query()->where("is_active", 0)->latest("id")->get();
        }else if ($status == "trashed") {
            $data = Catalogue::onlyTrashed()->latest("id")->get();
        }  else {
            $data = Catalogue::query()->latest("id")->get();
        }
        $count_all_catalogue = Catalogue::query()->get()->count();
        $count_active = Catalogue::query()->where("is_active", 1)->get()->count();
        $count_lisenced = Catalogue::query()->where("is_active", 0)->get()->count();
        $count_trashed = Catalogue::onlyTrashed()->get()->count();
        $count = [$count_all_catalogue, $count_active, $count_lisenced, $count_trashed];
        return view(self::PATH_VIEW . __FUNCTION__, compact('data','count'));
    }
    
    function create()
    {
        //Lấy dữ liệu nhưng danh mục chả vào đây
        $catalogues = Catalogue::with('childrenRecursive')->whereNull('parent_id')->get();
        // dd($catalogues->toArray());
        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogues'));
    }
    function store(Request $request)
    {
        //Đi validate dữ liệu
        $request->validate([
            'name' => 'required|unique:catalogues,name',
        ], [
            'required' => ":attribute không được để trống",
            'unique' => ":attribute không được trùng tên danh mục trước"
        ], [
            'name' => "Tên danh mục"
        ]);

        //Thường không đưa dữ liệu ảnh vào
        $data = $request->except(['thumbnail', 'parent_id']);
        //Đi check thằng is_active nếu không tồn tại danh mục
        $data['is_active'] ??= 0;
        if ($request->hasFile('thumbnail')) {
            //Cách đi upload 1 ảnh vào trong storeage
            $data['thumbnail'] = Storage::put(self::PATH_UPDATE, $request->file('thumbnail'));
        }
        if ($request->input('parent_id')) {
            //Cách đi upload 1 ảnh vào trong storeage
            $data['parent_id'] = $request->input('parent_id');
        }
        //Thông qua fillable để trống lại dữ liệu người dùng chuyền lên
        Catalogue::create($data);
        return redirect()->route('admin.products.catalogues.index');
    }
    function show(Catalogue $catalogue)
    {
        $catalogues = Catalogue::with('childrenRecursive')->whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact("catalogue", 'catalogues'));
    }
    function edit(Catalogue $catalogue)
    {
        //Danh mục có cha nó là thằng nào
        $catalogues = Catalogue::with('childrenRecursive')->whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact("catalogue", 'catalogues'));
    }
    function update(Request $request, Catalogue $catalogue)
    {
        $request->validate([
            'name' => 'required|unique:catalogues,name,' . $catalogue->id,
        ], [
            'required' => ":attribute không được để trống",
            'unique' => ":attribute không được trùng tên danh mục trước"
        ], [
            'name' => "Tên danh mục"
        ]);
        //Thường không đưa dữ liệu ảnh vào
        $data = $request->except(['thumbnail', 'parent_id']);
        //Đi check thằng is_active nếu không tồn tại danh mục
        $data['is_active'] ??= 0;
        if ($request->hasFile('thumbnail')) {
            //Cách đi upload 1 ảnh vào trong storeage
            $data['thumbnail'] = Storage::put(self::PATH_UPDATE, $request->file('thumbnail'));
        }
        if ($request->input('parent_id')) {
            //Cách đi upload 1 ảnh vào trong storeage
            $data['parent_id'] = $request->input('parent_id');
        }
        //Thông qua fillable để trống lại dữ liệu người dùng chuyền lên
        //Lấy hình trực tiếp trước khi update
        $currentThumbnail = $catalogue->thumbnail;
        //update không thành công mà xoá đi là sai
        $catalogue->update($data);
        //Khi mà ảnh bị ghi đè thì phải xoá đi thôi, xoá đi sau khi mà update sản phẩm đó
        if ($request->hasFile('thumbnail') && $currentThumbnail && Storage::exists($currentThumbnail)) {
            Storage::delete($currentThumbnail);
        }
        return redirect()->route('admin.products.catalogues.index');

    }
    function delete(Catalogue $catalogue)
    {
        //Không hề mất dữ liệu đi khi xoá nên có thể -> chạy tiếp dòng lệnh if
        $catalogue->delete();
        //Đi xoá ảnh trong storage
        if ($catalogue->thumbnail && Storage::exists($catalogue->thumbnail)) {
            Storage::delete($catalogue->thumbnail);
        }
        return back()->with('status', 'Xoá sản phẩm thành công');
    }
    function restore($id)
    {
        Catalogue::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.products.catalogues.index');
    }
}
