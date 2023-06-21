@extends('admin.layouts.master')
@section('title', 'Danh sách sản phẩm đã xóa')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH ĐÃ XÓA</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/products/create" class="btn mt-5 btn-primary">Thêm mới sản phẩm</a>
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
                            <td class="text-primary">{{ isset($product->name) ? $product->name : '' }}</td>
                            <td class="text-success">
                                {{ isset($product->product_quantity) ? $product->product_quantity : 'Sửa sau' }}
                            </td>
                            <td>
                                @isset($productCategories)
                                    @foreach ($productCategories as $productCategory)
                                        @if ($productCategory->id == $product->product_category_id)
                                            {{ $productCategory->name }}
                                        @endif
                                    @endforeach
                                @endisset
                            </td>
                            <td>{{ isset($product->short_description) ? $product->short_description : '' }}</td>
                            <td>{{ isset($product->views) ? $product->views : '0' }}</td>
                            <td>
                                <a href="/admin/products/deleted-restore/{{ isset($product->id) ? $product->id : '' }}"
                                    onclick="return confirm('Bạn có muốn khôi phục không')"
                                    class="btn btn-outline-success btn-sm">Khôi phục</a>
                                <a href="/admin/products/deleted-force/{{ isset($product->id) ? $product->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa vĩnh viễn</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        @endif
        <div class="text-center">
            <a href="/admin/products" class="btn mt-5 btn-primary">Quay lại danh sách</a>
        </div>
    </div>
@endsection
