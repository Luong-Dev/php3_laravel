@extends('admin.layouts.master')
@section('title', 'Danh Mục Thuộc Tính Sản Phẩm')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-9">
                <h1 class="text-success  fs-2 fw-bold">DANH SÁCH DANH MỤC THUỘC TÍNH SẢN PHẨM</h1>
            </div>
            {{-- <div class=" col-3 text-right">
                <a href="/admin/product-attribute-categories/create" class="btn btn-outline-primary">Thêm mới danh mục</a>
            </div> --}}
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
        @if (isset($productAttributeCategories))
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        {{-- <th scope="col">Mã Dm</th> --}}
                        <th scope="col">Tên danh mục</th>
                        <th scope="col" style="width: 50%">Mô tả</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productAttributeCategories as $key => $productAttributeCategory)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($productAttributeCategory->id) ? $productAttributeCategory->id : '' }}</td> --}}
                            <td class="text-primary">
                                {{ isset($productAttributeCategory->name) ? $productAttributeCategory->name : '' }}
                            </td>
                            <td>
                                {{ isset($productAttributeCategory->description) ? $productAttributeCategory->description : '' }}
                            </td>
                            <td>
                                <a href="/admin/product-attribute-categories/edit/{{ isset($productAttributeCategory->id) ? $productAttributeCategory->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                {{-- <a href="/admin/product-attribute-categories/delete/{{ isset($productAttributeCategory->id) ? $productAttributeCategory->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $productAttributeCategories->links() }}
        @endif
        {{-- <div class=" mt-5">
            <a href="/admin/product-attribute-categories/deleted-list" class="btn btn-primary">Xem danh sách đã
                xóa</a>
        </div> --}}
    </div>
@endsection
