@extends('admin.layouts.master')
@section('title', 'Thêm mới chi tiết sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-2 fw-bold mt-2">
            {{ isset($product->product_name) ? 'Thêm chi tiết không có thuộc tính cho sản phẩm: ' . $product->product_name : 'Không tồn tại sản phẩm này!' }}
        </h2>
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
        @if (isset($product))
            <a href="/admin/product-details/create-option-have-attribute/{{ isset($product->product_id) ? $product->product_id : '' }}"
                class="mt-4 mb-4 btn btn-primary">Nhấn để thêm thuộc tính cho sản phẩm</a>
            <a href="/admin/product-images/create/{{ isset($product->product_id) ? $product->product_id : '' }}"
                class="btn btn-outline-primary">Thêm h/ả sp</a>
            <form class="form-control mt-5" method="POST" enctype="multipart/form-data"
                action="/admin/product-details/store-no-attribute/{{ $product->product_id }}">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label"></label>
                    <input name="name" type="text" class="form-control" id=""
                        value="{{ $product->product_id }}" disabled hidden>
                </div>
                <div class="mb-3">
                    <label for="exampleRegularPrice" class="form-label">Giá thường</label>
                    <input name="regular_price" type="number" class="form-control" id="exampleRegularPrice"
                        value="{{ old('regular_price') }}">
                    <p class="text-danger">
                        @error('regular_price')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleSalePrice" class="form-label">Giá giảm</label>
                    <input name="sale_price" type="number" class="form-control" id="exampleSalePrice"
                        value="{{ old('sale_price') }}">
                    <p class="text-danger">
                        @error('sale_price')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleQuantity" class="form-label">Số lượng</label>
                    <input name="quantity" type="number" class="form-control" id="exampleQuantity"
                        value="{{ old('quantity') }}">
                    <p class="text-danger">
                        @error('quantity')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <select name="status" class="form-select" aria-label="Default select example">
                        @isset($arrStatus)
                            @foreach ($arrStatus as $key => $status)
                                <option value="{{ $key }}"
                                    {{ old('product_category_id') == $key ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        @endisset
                    </select>
                    <p class="text-danger">
                        @error('status')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
                <a class="btn btn-outline-success"
                    href="/admin/product-details/detail/{{ isset($product->product_id) ? $product->product_id : '' }}">Chi
                    tiết sản phẩm</a>
                    <a class="btn btn-outline-danger"
                    href="/admin/product-details/detail/{{ isset($product->product_id) ? $product->product_id : '' }}">Quay
                    lại Sản Phẩm</a>
            </form>
        @endif
    </div>
@endsection
