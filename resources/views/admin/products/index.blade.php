@extends('admin.layouts.master')
@section('title')
    Danh mục sản phẩm
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh sách danh mục sản phẩm</h5>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Thêm mới sản phẩm</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                {{-- <th data-ordering="false">SR No.</th> --}}
                                <th data-ordering="false">ID</th>
                                <th>Hình ảnh</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Catalogue</th>
                                <th>Price Regular</th>
                                <th>Price Sale</th>
                                <th>View</th>
                                <th>Is Active</th>
                                <th>Is Hot Deal</th>
                                <th>Is Good Deal</th>
                                <th>Is New</th>
                                <th>Is Show Home</th>
                                <th>Tags</th>
                                <th>Created at</th>
                                <th>Update At</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    $t++;
                                    $url = $item->thumbnail;
                                    //Đi kiểm tra xem tồn tại đường http, thì do upload lên và => đẩy dữ liệu $url
                                    if (!Str::contains($url, 'http')) {
                                        $url = Storage::url($url);
                                    }
                                @endphp
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" name="checkAll"
                                                value="option1">
                                        </div>
                                    </th>
                                    <td>{{ $item->id }}</td>
                                    <td><img src="{{ $url }}" width="100px" alt=""></td>
                                    <td><a href="#!">{{ $item->name }}</a></td>
                                    <td>{{ $item->sku }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-primary">{{ $item->catalogue->name }}</span></td>
                                    <td>{{ $item->price_regular }}</td>
                                    <td>{{ $item->price_sale }}</td>
                                    <td>{{ $item->views }}</td>
                                    <td class="text-center">{!! $item->is_active == '1'
                                        ? '<span class="badge bg-warning">YES</span>'
                                        : '<span class="badge bg-danger">NO</span>' !!}</td>
                                    <td class="text-center">{!! $item->is_hot_deal == '1'
                                        ? '<span class="badge bg-warning">YES</span>'
                                        : '<span class="badge bg-danger">NO</span>' !!}</td>
                                    <td class="text-center">{!! $item->is_hot_good == '1'
                                        ? '<span class="badge bg-warning">YES</span>'
                                        : '<span class="badge bg-danger">NO</span>' !!}</td>

                                    <td class="text-center">{!! $item->is_new == '1'
                                        ? '<span class="badge bg-warning">YES</span>'
                                        : '<span class="badge bg-danger">NO</span>' !!}</td>
                                    <td class="text-center">{!! $item->is_show_home == '1'
                                        ? '<span class="badge bg-warning">YES</span>'
                                        : '<span class="badge bg-danger">NO</span>' !!}</td>
                                    <td class="text-center">
                                        @if ($item->tags->count() > 0)
                                            @foreach ($item->tags as $tag)
                                                <span class="badge bg-info">{{ $tag->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-info">No</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="#!" class="dropdown-item"><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>
                                                </li>
                                                <li><a href="{{ route("admin.products.edit", $item->id) }}" class="dropdown-item edit-item-btn"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route("admin.products.destroy", $item->id) }}" class="dropdown-item remove-item-btn">
                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/datatables.init.js') }}"></script>
@endsection
