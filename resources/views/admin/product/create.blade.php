@extends('admin.layouts.master')
@section('title', 'Thêm mới sản phẩm')
@section('content')
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/products/store">
            @csrf
            <div class="mb-3">
                <label for="exampleName" class="form-label">Tên sản phẩm</label>
                <input name="name" type="text" class="form-control" id="exampleName" value="{{ old('name') }}">
                <p class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3">
                <label for="exampleShortDescription" class="form-label">Mô tả ngắn</label>
                <textarea name="short_description" class="form-control" id="exampleShortDescription" cols="30" rows="2">{{ old('short_description') }}</textarea>
                <p class="text-danger">
                    @error('short_description')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3">
                <label for="exampleLongDescription" class="form-label">Mô tả dài</label>
                <textarea name="long_description" class="form-control" id="exampleLongDescription" cols="30" rows="5">{{ old('long_description') }}</textarea>
                <p class="text-danger">
                    @error('long_description')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3">
                <select name="product_category_id" class="form-select" aria-label="Default select example">
                    <option selected>Mở chọn danh mục sản phẩm</option>
                    @isset($productCategories)
                        @foreach ($productCategories as $productCategory)
                            <option value="{{ $productCategory->id }}"
                                {{ old('product_category_id') == $productCategory->id ? 'selected' : '' }}>
                                {{ $productCategory->name }}</option>
                        @endforeach
                    @endisset
                </select>
                <p class="text-danger">
                    @error('product_category_id')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
            <a class="btn btn-outline-danger" href="/admin/products">Quay lại danh sách</a>
        </form>
    </div>
@endsection
