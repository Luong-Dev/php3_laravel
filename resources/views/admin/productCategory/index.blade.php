@extends('admin.layouts.master')
@section('title', 'Danh sách danh mục')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH DANH MỤC</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/product-categories/create" class="btn mt-5 btn-primary">Thêm mới danh mục</a>
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
        @if (isset($productCategories))
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        {{-- <th scope="col">Mã Dm</th> --}}
                        <th scope="col">Tên danh mục</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Mô tả hình ảnh</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productCategories as $key => $productCategory)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($productCategory->id) ? $productCategory->id : '' }}</td> --}}
                            <td class="text-primary">{{ isset($productCategory->name) ? $productCategory->name : '' }}</td>
                            <td class="text-success">
                                @foreach ($products as $product)
                                    {{ $productCategory->id == $product->id ? $product->product_quantity : '' }}
                                @endforeach
                                {{-- {{ isset($products->product_quantity) ? $products->product_quantity : '0' }} --}}
                            </td>
                            <td>{{ isset($productCategory->description) ? $productCategory->description : '' }}</td>
                            <td>
                                <img src='{{ isset($productCategory->image_url) ? asset($productCategory->image_url) : '' }}'
                                    alt="Link hỏng" style="width: 70px; height: 50px;">
                            </td>
                            <td>{{ isset($productCategory->image_alt) ? $productCategory->image_alt : '' }}</td>
                            <td>
                                <a href="/admin/product-categories/edit/{{ isset($productCategory->id) ? $productCategory->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/product-categories/delete/{{ isset($productCategory->id) ? $productCategory->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $productCategories->links() }}
        @endif
        <div class="text-center">
            <a href="/admin/product-categories/deleted-list" class="btn mt-5 btn-primary">Xem danh sách đã xóa</a>
        </div>
    </div>
@endsection
