@extends('admin.layouts.master')
@section('title', 'Chi tiết sản phẩm')
@section('content')
    <div class="container mt-5">
        @if (isset($product))
            <h2 class="text-success fs-2 fw-bold mt-2 mb-3">Thêm chi tiết cho sản phẩm:
                {{ isset($product->name) ? $product->name : '' }}
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
            {{-- <div class="mb-3">
                <label for="exampleName" class="form-label">Tên sản phẩm</label>
                <input name="name" type="text" class="form-control" id="exampleName" value="{{ $product->name }}" disabled>
            </div>
            <div class="mb-3">
                <label for="exampleShortDescription" class="form-label">Mô tả ngắn</label>
                <textarea disabled name="short_description" class="form-control" id="exampleShortDescription" cols="30"
                    rows="1">{{ $product->short_description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="exampleLongDescription" class="form-label">Mô tả dài</label>
                <textarea disabled name="long_description" class="form-control" id="exampleLongDescription" cols="30"
                    rows="2">{{ $product->long_description }}</textarea>
            </div> --}}
            <form class="form-control mt-5" method="POST" enctype="multipart/form-data"
                action="/admin/product-details/update/{{ $productId }}/{{ $productDetailId }}">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label"></label>
                    <input name="name" type="text" class="form-control" id=""
                        value="{{ $product->product_id }}" disabled hidden>
                </div>
                <div class="mb-3">
                    <label for="exampleRegularPrice" class="form-label">Giá thường</label>
                    <input name="regular_price" type="number" class="form-control" id="exampleRegularPrice"
                        value="{{ old('regular_price') != '' ? old('regular_price') : $productDetail->regular_price }}">
                    <p class="text-danger">
                        @error('regular_price')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleSalePrice" class="form-label">Giá giảm</label>
                    <input name="sale_price" type="number" class="form-control" id="exampleSalePrice"
                        value="{{ old('sale_price') != '' ? old('sale_price') : $productDetail->sale_price }}">
                    <p class="text-danger">
                        @error('sale_price')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleQuantity" class="form-label">Số lượng</label>
                    <input name="quantity" type="number" class="form-control" id="exampleQuantity"
                        value="{{ old('quantity') != '' ? old('quantity') : $productDetail->quantity }}">
                    <p class="text-danger">
                        @error('quantity')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <select name="status" class="form-select" aria-label="Default select example">
                        @isset($arrStatus)
                            @if (old('status'))
                                @foreach ($arrStatus as $key => $status)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            @else
                                @foreach ($arrStatus as $key => $status)
                                    <option value="{{ $key }}"
                                        {{ $productDetail->status == $key ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            @endif
                        @endisset
                    </select>
                    <p class="text-danger">
                        @error('status')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <button type="submit" class="btn btn-outline-primary">Cập nhật</button>
                <a class="btn btn-outline-danger" href="/admin/product-details/detail/{{ $productId }}">Quay lại danh
                    sách</a>
            </form>
        @endif
    </div>
@endsection
