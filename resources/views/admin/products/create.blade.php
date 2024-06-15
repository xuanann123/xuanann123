@extends('admin.layouts.master')
@section('title')
    Thêm mới sản phẩm
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
                <h4 class="mb-sm-0">Thêm mới sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Thêm mới sản phẩm</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
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
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>

                                    <div class="mt-3">
                                        <label for="sku" class="form-label">Mã sản phẩm</label>
                                        <input type="text" class="form-control" id="sku" name="sku"
                                            value="{{ $sku }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_regular" class="form-label">Giá thường</label>
                                        <input type="number" class="form-control" id="price_regular" name="price_regular">
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_sale" class="form-label">Giảm giá</label>
                                        <input type="number" class="form-control" id="price_sale" name="price_sale">
                                    </div>
                                    <div class="mt-3">
                                        <label for="choices-multiple-default" class="form-label">Danh mục cha</label>
                                        <select class="form-control h-5" id="choices-multiple-default" data-choices
                                            name="catalogue_id">
                                            <option value="" selected>Chọn danh mục sản phẩm</option>
                                            @foreach ($catalogues as $catalog)
                                                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
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
                                        <label for="thumbnail" class="form-label">Ảnh sản phẩm</label>
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                    </div>
                                    <div class="mt-3">
                                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="d-flex justify-content-between">
                                            @foreach ($list_is_view as $name => $color)
                                                <div class="form-check form-switch form-switch-{{ $color }}">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="is_active" id="{{ $name }}" checked>
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
                                            <textarea class="form-control" id="material" name="material" rows="3"></textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="material" class="form-label">Hướng dẫn sử dụng</label>
                                            <textarea class="form-control" id="material" name="material" rows="3"></textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="content" class="form-label">Nội dung sản phẩm</label>
                                            <textarea class="form-control tiny" id="content" name="content" rows="1"></textarea>
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
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="product_variants[{{ $sizeID . '-' . $colorID }}][quantity]">
                                                    </td>
                                                    <td>
                                                        <input type="file" class="form-control"
                                                            name="product_variants[{{ $sizeID . '-' . $colorID }}][image]">
                                                    </td>
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
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
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
                        <button class="btn btn-outline-success">Thêm sản phẩm</button>
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
