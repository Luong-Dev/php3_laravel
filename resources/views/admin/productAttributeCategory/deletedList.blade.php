@extends('admin.layouts.master')
@section('title', 'Danh sách danh mục thuộc tính sản phẩm')
@section('content')
    <div class="container">
        @if (isset($productAttributeCategories))
            <div class="row">
                <div class="col-md-9">
                    <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH DANH MỤC THUỘC TÍNH SẢN PHẨM ĐÃ XÓA</h1>
                </div>
                <div class="col-md-3 text-right">
                    <a href="/admin/product-attribute-categories/create" class="btn mt-5 btn-primary">Thêm mới danh mục thuộc
                        tính sản phẩm</a>
                </div>
            </div>
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
                                {{ isset($productAttributeCategory->name) ? $productAttributeCategory->name : '' }}</td>
                            <td>{{ isset($productAttributeCategory->description) ? $productAttributeCategory->description : '' }}
                            </td>
                            <td>
                                <a href="/admin/product-attribute-categories/deleted-restore/{{ isset($productAttributeCategory->id) ? $productAttributeCategory->id : '' }}"
                                    onclick="return confirm('Bạn có muốn khôi phục không')"
                                    class="btn btn-outline-success btn-sm">Khôi phục</a>
                                <a href="/admin/product-attribute-categories/deleted-force/{{ isset($productAttributeCategory->id) ? $productAttributeCategory->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa vĩnh viễn</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                <a href="/admin/product-attribute-categories" class="btn mt-5 btn-primary">Quay lại danh sách</a>
            </div>
            {{ $productAttributeCategories->links() }}
        @endif
    </div>
@endsection
