@extends('admin.layouts.master')
@section('title')
    Sửa danh mục sản phẩm
@endsection
{{-- Có những trường dữ liệu như: tên danh mục. hình ảnh danh mục, is_active và cuối cùng parent_id --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Sửa danh mục sản phẩm</h4>

                </div><!-- end card header -->
                <div class="card-body">

                    <div class="live-preview">
                        <form action="{{ route('admin.products.catalogues.update', $catalogue->id) }}"
                            enctype="multipart/form-data" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="">
                                        <div>
                                            <label for="name" class="form-label text-uppercase">Tên danh mục sản
                                                phẩm</label>
                                            <input type="text" class="form-control rounded-pill" name="name"
                                                id="name" placeholder="Nhập tên danh mục sản phẩm"
                                                value="{{ $catalogue->name }}">
                                        </div>
                                        @error('name')
                                            <span class="text-danger m-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div>
                                                    <label for="formFile" class="form-label text-uppercase">Chọn ảnh danh
                                                        mục sản
                                                        phẩm</label>
                                                    <input class="form-control" name="thumbnail" type="file"
                                                        id="formFile">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-uppercase">Ảnh cũ</label>
                                                @php
                                                    $url = Storage::url($catalogue->thumbnail);
                                                @endphp
                                                <img src="{{ $url }}" width="100%" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="choices-multiple-default" class="form-label text-uppercase">Danh mục có tồn
                                        tại không</label>
                                    <div class="form-check form-check-dark">
                                        <input {{ $catalogue->is_active == 1 ? 'checked' : '' }} class="form-check-input"
                                            type="checkbox" name="is_active" value="1" id="formCheck12">
                                        <label class="form-check-label" for="formCheck12">
                                            Is Active
                                        </label>
                                    </div>
                                    {{-- Cách đê quy và lấy ra level của một danh mục
                                    Bước 1: Tạo một child bên model => đi đệ quy nó qua thằng child
                                    ==> Qua mỗi lần duyệt của một danh mục thì lại kiểm tra xem nó có thằng con nào không
                                    ==> Từ lúc này đi tạo ra một cái submenu => đẩy những dữ liệu như đối tượng con của menu cần duyệt và level thì tăng lên
                                    ==> Qua phần view bên đó copy phần đệ quy này và tuỳ chỉnh tham số và ++level lên là được
                                    --}}
                                    <div class="mt-5">
                                        <div class="mb-3">
                                            <label for="choices-multiple-default" class="form-label text-uppercase">Chọn
                                                danh mục cha</label>
                                            <select class="form-control" id="choices-multiple-default" data-choices
                                                name="parent_id">
                                                <option value="" selected>Chọn danh mục sản phẩm</option>
                                                @foreach ($catalogues as $catalog)
                                                    <option value="{{ $catalog->id }}"
                                                        {{ $catalogue->parent_id == $catalog->id ? 'selected' : '' }}>
                                                        {{ $catalog->name }}</option>
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
                                    </div>
                                </div>
                                <button class="btn btn-primary">Sửa danh mục</button>
                            </div>
                        </form>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection
