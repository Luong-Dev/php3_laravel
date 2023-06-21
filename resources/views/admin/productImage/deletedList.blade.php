@extends('admin.layouts.master')
@section('title', 'Danh sách Ảnh Sản Phẩm Đã Xóa')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH ẢNH Sản Phẩm Đã Xóa</h1>
            </div>
        </div>
        @if (isset($productImages))
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Sản Phẩm</th>
                        <th scope="col">Ảnh Sản Phẩm</th>
                        <th scope="col">Mô Tả Ảnh</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productImages as $key => $productImage)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            @foreach ($products as $product)
                                @if ($product->id == $productImage->product_id)
                                    <td> {{ $product->name }}</td>
                                @endif
                            @endforeach
                            <td>
                                <img src='{{ isset($productImage->image_url) ? asset($productImage->image_url) : '' }}'
                                    alt="Link hỏng" style="width: 100px; height: 80px;">
                            </td>
                            <td>{{ isset($productImage->image_alt) ? $productImage->image_alt : '' }}</td>
                            <td>
                                <a href="/admin/product-images/deleted-restore/{{ isset($productImage->id) ? $productImage->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Khôi Phục</a>
                                <a href="/admin/product-images/deleted-force/{{ isset($productImage->id) ? $productImage->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa Vĩnh Viễn</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $productImages->links() }}
        @endif
        <div class="text-center">
            <a href="/admin/product-images" class="btn mt-5 btn-primary">Quay Lại Danh Sách Sản Phẩm</a>
        </div>
    </div>
@endsection
