@extends('admin.layouts.master')
@section('title', 'Sửa Danh Mục')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-2 fw-bold mt-2 mb-5">
            {{ isset($productCategory->name) ? "Sửa Danh Mục: $productCategory->name" : 'Không tồn tại danh mục' }} </h2>
        @if (isset($productCategory))
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
            <form class="form-control" method="POST" enctype="multipart/form-data"
                action="/admin/product-categories/update/{{ isset($productCategory->id) ? $productCategory->id : '' }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleName" class="form-label">Tên danh mục</label>
                    <input name="name" type="text" class="form-control" id="exampleName"
                        value="{{ old('name') != '' ? old('name') : $productCategory->name }}">
                    <p class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleDescription" class="form-label">Mô tả</label>
                    {{-- <input name="description" type="text"
                    value="{{ old('description') }}"> --}}
                    <textarea name="description" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('description') != '' ? old('description') : $productCategory->description }}</textarea>
                    <p class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleImageUrl" class="form-label">Hình ảnh đại diện</label>
                    <input name="image_url" type="file" class="form-control" id="exampleImageUrl"
                        value="{{ old('image_url') }}">
                    <p class="text-danger">
                        @error('image_url')
                            {{ $message }}
                        @enderror
                    </p>
                    @if ($productCategory->image_url != '')
                        <img class="mt-3" style="width: 100px" src="{{ asset($productCategory->image_url) }}">
                    @endif
                </div>
                <div class="mb-3">
                    <label for="exampleImageaAlt" class="form-label">Mô tả hình ảnh</label>
                    {{-- <input name="" type="text" value="{{ old('image_alt') }}"> --}}
                    <textarea name="image_alt" class="form-control" id="exampleImageAlt" cols="30" rows="1">{{ old('image_alt') != '' ? old('image_alt') : $productCategory->image_alt }}</textarea>
                    <p class="text-danger">
                        @error('image_alt')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Xác nhận CẬP NHẬT!')">Cập
                    nhật</button>
            </form>
        @endif
        <a class="btn btn-outline-danger mt-3" href="/admin/product-categories">Quay lại danh sách</a>
    </div>
@endsection
