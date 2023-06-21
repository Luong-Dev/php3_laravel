@extends('admin.layouts.master')
@section('title', 'Thuộc Tính Sản Phẩm')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-9">
                <h1 class="text-success  fs-2 fw-bold">DANH SÁCH THUỘC TÍNH SẢN PHẨM</h1>
            </div>
            <div class=" col-3 text-right">
                <a href="/admin/product-attributes/create" class="btn btn-outline-primary">Thêm mới thuộc tính</a>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger mt-3" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success mt-3" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (isset($productAttributes))
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        {{-- <th scope="col">Mã Thuộc Tính</th> --}}
                        <th scope="col">Tên Thuộc Tính Sản Phẩm</th>
                        <th scope="col">Tên danh mục Thuộc Tính Sản Phẩm</th>
                        <th scope="col" style="width: 40%">Mô tả Giá Trị</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productAttributes as $key => $productAttribute)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($productAttribute->id) ? $productAttribute->id : '' }}</td> --}}
                            <td class="text-primary">
                                {{ isset($productAttribute->product_attribute_name) ? $productAttribute->product_attribute_name : '' }}
                            </td>
                            <td class="text-primary">
                                {{ isset($productAttribute->product_attribute_category_name) ? $productAttribute->product_attribute_category_name : '' }}
                            </td>
                            <td>
                                {{ isset($productAttribute->description_value) ? $productAttribute->description_value : '' }}
                            </td>
                            <td>
                                <a href="/admin/product-attributes/edit/{{ isset($productAttribute->id) ? $productAttribute->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/product-attributes/delete/{{ isset($productAttribute->id) ? $productAttribute->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $productAttributes->links() }}
        @endif
        <div class="mt-3">
            <a href="/admin/product-attributes/deleted-list" class="btn btn-primary">Xem danh sách đã
                xóa</a>
        </div>
    </div>
@endsection
