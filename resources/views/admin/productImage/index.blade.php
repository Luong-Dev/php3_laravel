@extends('admin.layouts.master')
@section('title', 'Danh sách Ảnh Sản Phẩm')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH ẢNH Sản Phẩm</h1>
            </div>
            {{-- <div class="col-md-6 text-right">
                <a href="/admin/product-images/create/{{ isset($id) ? $id : '' }}" class="btn mt-5 btn-primary">Thêm mới ảnh
                    sản Phẩm</a>
            </div> --}}
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
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
                                <img style="width: 100px ; height:40px"
                                    src="/{{ isset($productImage->image_url) ? $productImage->image_url : '' }}"
                                    alt="Link hỏng">
                            </td>
                            <td>{{ isset($productImage->image_alt) ? $productImage->image_alt : '' }}</td>
                            <td>
                                <a href="/admin/product-images/edit/{{ isset($productImage->id) ? $productImage->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/product-images/delete/{{ isset($productImage->id) ? $productImage->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $productImages->links() }}
        @endif
        <div class="text-center">
            <a href="/admin/product-images/deleted-list" class="btn mt-5 btn-primary">Xem danh sách đã xóa</a>
        </div>
    </div>
@endsection
