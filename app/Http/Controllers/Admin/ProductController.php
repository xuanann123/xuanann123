<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
    function index()
    {
        $data = Product::query()->with('catalogue', 'tags')->latest("id")->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }
    //Thêm mới
    public function create()
    {
        $sku = strtoupper(Str::random(8));
        $catalogues = Catalogue::with('childrenRecursive')->whereNull('parent_id')->get();
        $colors = ProductColor::query()->pluck("name", "id")->all();
        $sizes = ProductSize::query()->pluck("name", "id")->all();
        $tags = Tag::query()->get();
        $list_is_view = [
            'is_active' => 'success',
            'is_hot_deal' => 'danger',
            'is_good_deal' => 'warning',
            'is_new' => 'secondary',
            'is_show_home' => 'dark',

        ];
        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogues', 'sku', 'colors', 'sizes', 'tags', 'list_is_view'));
    }
    function store(Request $request, Exception $exception)
    {
        //Đi validate nhưng để sau khi làm xong cả danh mục này heheh
        //Bóc tách data
        $dataProduct = $request->except('product_variants', 'tags', 'product_galleries');
        //Xử lý các trường is_
        $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_hot_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_good_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_new'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_show_home'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['views'] = 0;

        //Xử lý dữ liệu  slug
        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];
        //Xử lý hình ảnh product thumbnail
        if ($request->hasFile('thumbnail')) {
            $dataProduct['thumbnail'] = Storage::put('products', $dataProduct['thumbnail']);
        }
        //Dữ liệu tamp
        $dataProductVariantsTmp = $request->product_variants;
        //Dữ liệu lưu vào cơ sở dữ liệu
        $dataProductVariants = [];
        //Xử lý dữ liệu biến thể sản phẩm
        foreach ($dataProductVariantsTmp as $key => $value) {
            $tmp = explode('-', $key);
            $dataProductVariants[] = [
                'product_color_id' => $tmp['1'],
                'product_size_id' => $tmp['0'],
                'quantity' => $value['quantity'],
                'image' => $value['image'] ?? null,
            ];
        }
        $dataProductTags = $request->tags;
        //Nếu k chọn thì sẽ để rỗng thôi
        $dataProductGalleries = $request->product_galleries ?: [];
        //Làm việc với transition => toàn vẹn về mặt dữ liệu, tính nhất quán => transition => dữ liệu không bị sai sót (1 câu truy vấn sai => rollback )= > như chưa một câu truy vấn nào xảy ra
        try {
            //Lưu vào cơ sở dữ liệu
            DB::beginTransaction();
            //Thêm dữ liệu bảng products
            // dd($dataProduct);
            $product = Product::query()->create($dataProduct);


            //Thêm dữ liệu bảng productvariant
            foreach ($dataProductVariants as $dataProductVariant) {
                //Lấy cái id của product như sau
                $dataProductVariant['product_id'] = $product->id;
                if ($dataProductVariant['image']) {
                    $dataProductVariant['image'] = Storage::put('products', $dataProductVariant['image']);
                }
                ProductVariant::query()->create($dataProductVariant);
            }
            //Thêm dữ liệu vào bảng chung gian
            $product->tags()->sync($dataProductTags);
            //Thêm dữ liệu vào bảng gallery như sau
            foreach ($dataProductGalleries as $image) {
                ProductGallery::query()->create([
                    'product_id' => $product->id,
                    //upload luôn hình ảnh nè
                    'image' => Storage::put('products', $image),
                ]);
            }
            DB::commit();
            return redirect()->route("admin.products.index");
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($exception->getMessage());
            return back();
        }
    }
    public function edit(Product $product)
    {
        // dd($product->variants->toArray);
        $catalogues = Catalogue::with('childrenRecursive')->whereNull('parent_id')->get();
        $colors = ProductColor::query()->pluck("name", "id")->all();
        $sizes = ProductSize::query()->pluck("name", "id")->all();
        $tags = Tag::query()->get();
        //Lấy danh sách những tag mà products đó chọn
        $tagsSelected = $product->tags()->pluck('id')->toArray();
        $list_is_view = [
            'is_active' => 'success',
            'is_hot_deal' => 'danger',
            'is_good_deal' => 'warning',
            'is_new' => 'secondary',
            'is_show_home' => 'dark',

        ];
        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogues', 'product', 'colors', 'sizes', 'tags', 'list_is_view', 'tagsSelected'));

    }
    function update(Product $product, Request $request)
    {
        //Đi validate nhưng để sau khi làm xong cả danh mục này heheh
        //Bóc tách data
        $dataProduct = $request->except('product_variants', 'tags', 'product_galleries');
        //Xử lý các trường is_
        $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_hot_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_good_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_new'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_show_home'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['views'] = 0;

        //Xử lý dữ liệu  slug
        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];
        //Xử lý hình ảnh product thumbnail
        if ($request->hasFile('thumbnail')) {
            $dataProduct['thumbnail'] = Storage::put('products', $dataProduct['thumbnail']);
        }
        //Xong thằng bảng product, tiếp đến thằng
        //Dữ liệu tamp
        $dataProductVariantsTmp = $request->product_variants;
        //Dữ liệu lưu vào cơ sở dữ liệu
        $dataProductVariants = [];
        //Xử lý dữ liệu biến thể sản phẩm
        foreach ($dataProductVariantsTmp as $key => $value) {
            $tmp = explode('-', $key);
            $dataProductVariants[] = [
                'product_color_id' => $tmp['1'],
                'product_size_id' => $tmp['0'],
                'quantity' => $value['quantity'],
                'image' => $value['image'] ?? null,
            ];
        }
        //Đến dữ liệu
        $dataProductTags = $request->tags;
        //Nếu k chọn thì sẽ để rỗng thôi
        $dataProductGalleries = $request->product_galleries ?: [];
        //Làm việc với transition => toàn vẹn về mặt dữ liệu, tính nhất quán => transition => dữ liệu không bị sai sót (1 câu truy vấn sai => rollback )= > như chưa một câu truy vấn nào xảy ra

    }
    public function destroy(Product $product, Exception $exception)
    {

        //Sử dụng transaction
        try {
            DB::transaction(function () use ($product) {

                //Xoá bảng mối quan hệ nhiều nhiều với tags                //Xoá với bảng trung gian
                $product->tags()->sync([]);
                //Đi xoá trong thằng storage trước rồi đi xoá những phần liên quan
                //Xoá những phần ảnh liên quan thì có điều kiện
                if (count($product->galleries) > 0) {
                    foreach ($product->galleries as $gallery) {
                        if (Storage::exists($gallery->image)) {
                            Storage::delete($gallery->image);
                        }
                    }
                }
                foreach ($product->galleries as $item) {
                    $item->delete();
                    if($item->image && Storage::exists($item->image)) {
                        Storage::delete($item->image);
                    } 
                }
                

                //Không xoá được khi mắc ảnh 
                // foreach ($product->variants as $variant) {
                //     if (Storage::exists($variant->image)) {
                //         Storage::delete($variant->image);
                //     }
                // }

                $product->variants()->delete();

                $product->delete();
                if (Storage::exists($product->thumbnail) && $product->thumbnail) {
                    Storage::delete($product->thumbnail);
                }
                //Xoá hình ảnh của sản phẩm đó


                //Xoá gallery

            }, 1);
            return redirect()->route("admin.products.index");

            //Có tham số thứ 2 của hàm transaction => số lượt thực hiện câu truy vấn
        } catch (\Throwable $th) {
            dd($exception->getMessage());

            return redirect()->route("admin.products.index");
        }
    }
}
