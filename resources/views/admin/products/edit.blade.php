@extends('admin.layouts.master')
@section('title')
    Sủa sản phẩm
@endsection
{{-- Thông tin sản phẩm
Gallery
Biến thể
Tag --}}
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Sửa sản phẩm</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-4">
                                    <div>
                                        <label for="name" class="form-label">Tên danh mục</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $product->name }}">
                                    </div>

                                    <div class="mt-3">
                                        <label for="sku" class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" id="sku" name="sku"
                                            value="{{ $product->sku }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_regular" class="form-label">Giá thường</label>
                                        <input type="number" class="form-control" id="price_regular" name="price_regular"
                                            value="{{ $product->price_regular }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_sale" class="form-label">Giảm giá</label>
                                        <input type="number" class="form-control" id="price_sale" name="price_sale"
                                            value="{{ $product->price_sale }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="choices-multiple-default" class="form-label">Danh mục cha</label>
                                        <select class="form-control h-5" id="choices-multiple-default" data-choices
                                            name="catalogue_id">
                                            <option value="" selected>Chọn danh mục sản phẩm</option>
                                            @foreach ($catalogues as $catalog)
                                                <option {{ $product->catalogue->id == $catalog->id ? 'selected' : '' }}
                                                    value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                                {{-- Kiểm tra xem nó có thằng parent_id nào trùng với id của danh mục đó không --}}
                                                {{-- Đi đệ quy thằng danh mục con đó => truy xuất đến thằng con cuối cùng để lấy ra --}}
                                                @if (count($catalog->childrenRecursive) > 0)
                                                    @include('admin.layouts.submenu', [
                                                        'subcatalogues' => $catalog->childrenRecursive,
                                                        'level' => '--',
                                                    ]);
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="thumbnail" class="form-label">Ảnh sản phẩm</label>
                                                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                            </div>
                                            <div class="col-md-6">
                                                @php
                                                    $url = Storage::url($product->thumbnail);
                                                @endphp
                                                <img src="{{ $url }}" width="100%" alt="">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="mt-3">
                                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="d-flex justify-content-between">
                                            @foreach ($list_is_view as $name => $color)
                                                <div class="form-check form-switch form-switch-{{ $color }}">
                                                    <input {{ $product->$name == 1 ? 'checked' : '' }}
                                                        class="form-check-input" type="checkbox" role="switch"
                                                        name="is_active" id="{{ $name }}">
                                                    <label class="form-check-label" for="is_active"
                                                        style="text-transform: uppercase;font-weight: 600;">{{ $name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- Cách trường is_active --}}
                                    <div class="row">
                                        <!-- Example Textarea -->
                                        <div class="mt-3">
                                            <label for="material" class="form-label">Nguyên liệu</label>
                                            <textarea class="form-control" id="material" name="material" rows="3">{{ $product->material }}</textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="user_manual" class="form-label">Hướng dẫn sử dụng</label>
                                            <textarea class="form-control" id="user_manual" name="user_manual" rows="3">{{ $product->user_manual }}</textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="content" class="form-label">Nội dung sản phẩm</label>
                                            <textarea class="form-control tiny" id="content" name="content" rows="1">{{ $product->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Biến thể</h4>
                    </div><!-- end card header -->
                    <div class="card-body" style="height: 300px; overflow: scroll;">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <table class="w-100">
                                        <tr>
                                            <th>Kích cỡ</th>
                                            <th>Màu sắc</th>
                                            <th>Số lượng sản phẩm</th>
                                            <th>Hình ảnh chi tiết sản phẩm</th>
                                        </tr>
                                        {{-- Hai vòng for lòng nhau để ren được ra tất cả các biến thể  --}}
                                        {{-- Cách đổ thằng biến thể là như sau kiểm tra product_id product_size_id và product_color_id xem trùng không => trùng thì đổ ra --}}
                                        @foreach ($sizes as $sizeID => $sizeName)
                                            @foreach ($colors as $colorID => $colorName)
                                                <tr class="text-center">
                                                    <td>{{ $sizeName }}</td>
                                                    <td>
                                                        <div
                                                            style="width: 50px; height: 50px; background: {{ $colorName }};">
                                                        </div>
                                                    </td>
                                                    {{-- Tiện lợi có dữ liệu => lấy toàn bộ dữ liệu biển thể về một mảng --}}
                                                    @foreach ($product->variants as $variant)
                                                        @if (
                                                            $variant->product_size_id == $sizeID &&
                                                                $variant->product_color_id == $colorID &&
                                                                $variant->product_id == $product->id)
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="product_variants[{{ $sizeID . '-' . $colorID }}][quantity]"
                                                                    value="{{ $variant['quantity'] }}">
                                                            </td>
                                                            <td class="w-50">
                                                                @php
                                                                    $url_variant = Storage::url($variant->image);
                                                                    //Check xem storage có thằng hình ảnh này chưa
                                                                @endphp
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <input type="file" class="form-control"
                                                                            name="product_variants[{{ $sizeID . '-' . $colorID }}][image]">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <img src="{{ $url_variant }}" width="100%"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </div>

                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Hình ảnh chi tiết</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label for="gallery" class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control" multiple name="product_galleries[]"
                                        id="gallery">
                                </div>
                                <div>
                                    @foreach ($product->galleries as $gallery)
                                        @php
                                            $url_gallery = Storage::url($gallery->image);
                                        @endphp
                                        <img src="{{ $url_gallery }}" width="100px" alt="">
                                    @endforeach

                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Tags</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label for="tags" class="form-label">Tags</label>
                                    <select class="form-control" name="tags[]" id="tags" multiple>
                                        @foreach ($tags as $tag)
                                            <option {{ in_array($tag->id, $tagsSelected) ? 'selected' : '' }}
                                                value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <button class="btn btn-outline-success">Sửa sản phẩm</button>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection
@section('style-libs')
    <script src="https://cdn.tiny.cloud/1/yrczlu8vtw371hex5ans6vy683h0hi4o6uj09y13o0kcx3ri/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tiny',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endsection
