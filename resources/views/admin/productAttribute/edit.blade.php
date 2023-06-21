@extends('admin.layouts.master')
@section('title', 'Sửa Thuộc Tính Sản Phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-danger fs-2 fw-bold mt-2">Sửa Thuộc Tính Sản Phẩm</h2>
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (isset($productAttribute))
            <form class="form-control" method="POST" enctype="multipart/form-data"
                action="/admin/product-attributes/update/{{ $productAttribute->id }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleName" class="form-label">Tên thuộc tính sản phẩm</label>
                    <input name="name" type="text" class="form-control" id="exampleName" aria-describedby="emailHelp"
                        value="{{ old('name') != '' ? old('name') : $productAttribute->name }}">
                    <p class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div>
                    <select class="form-select" name="productAttributeCategory_id" id="">
                        <option>Loại Thuộc Tính Sản Phẩm</option>
                        @foreach ($productAttributeCategory as $productAttCategory)
                            <option
                                {{ $productAttribute->product_attribute_category_id == $productAttCategory->id ? 'selected' : '' }}
                                value="{{ $productAttCategory->id }}">{{ $productAttCategory->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger">
                        @error('productAttributeCategory_id')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleDescription" class="form-label">Mô tả Giá Trị</label>
                    {{-- <input name="description" type="text"
                    value="{{ old('description') }}"> --}}
                    <textarea name="description_value" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('description_value') != '' ? old('description_value') : $productAttribute->description_value }}</textarea>
                    <p class="text-danger">
                        @error('description_value')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <button type="submit" class="btn btn-outline-primary" onclick="return Confirm('xác nhận lưu')">Lưu</button>
                <a class="btn btn-outline-danger" href="/admin/product-attributes">Quay lại danh sách</a>
            </form>

        @endif
    </div>
@endsection
