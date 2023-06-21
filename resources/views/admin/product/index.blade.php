@extends('admin.layouts.master')
@section('title', 'DANH SÁCH SẢN PHẨM')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH SẢN PHẨM</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/products/create" class="btn mt-5 btn-primary">Thêm mới sản phẩm</a>
            </div>
        </div>
        {{-- <div class="row mt-3 mb-3">
            <div class="col-3"></div>
            <div class="col-6">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div> --}}
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

        @if (isset($products))
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        {{-- <th scope="col">Mã SP</th> --}}
                        <th scope="col">Tên SP</th>
                        <th scope="col">Tổng sản phẩm</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col" style="width: 30%;">Mô tả ngắn</th>
                        <th scope="col">Lượt xem</th>
                        <th scope="col">Thao tác</th>
                        {{-- chi tiết có mô tả dài, thông giá ..... --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($product->id) ? $product->id : '' }}</td> --}}
                            <td class="text-primary">
                                {{ isset($product->product_name) ? $product->product_name : 'Không có thông tin' }}</td>
                            <td class="text-success">
                                {{ isset($product->product_quantity) ? $product->product_quantity : 'Không có' }}
                            </td>
                            <td>
                                {{ isset($product->product_category_name) ? $product->product_category_name : 'Không có thông tin' }}
                            </td>
                            <td>{{ isset($product->short_description) ? $product->short_description : '' }}</td>
                            <td>{{ isset($product->views) ? $product->views : '0' }}</td>
                            <td>
                                <a href="/admin/product-details/detail/{{ isset($product->product_id) ? $product->product_id : '' }}"
                                    class="btn btn-primary btn-sm">Chi tiết</a>
                                {{-- <a href="/admin/product-images/create/{{ isset($product->product_id) ? $product->product_id : '' }}"
                                class="btn btn-outline-primary btn-sm">Thêm h/ả sp</a> --}}
                                {{-- <a href="/admin/products/edit/{{ isset($product->product_id) ? $product->product_id : '' }}"
                                class="btn btn-outline-success btn-sm">Sửa</a> --}}
                                <a href="/admin/products/delete/{{ isset($product->product_id) ? $product->product_id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        @endif
        <div class="text-center">
            <a href="/admin/products/deleted-list" class="btn mt-5 btn-primary">Xem danh sách đã xóa</a>
        </div>
    </div>
@endsection
