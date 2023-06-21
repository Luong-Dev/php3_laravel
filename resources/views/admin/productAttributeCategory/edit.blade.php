@extends('admin.layouts.master')
@section('title', 'Sửa Danh Mục Thuộc Tính Sản Phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-danger fs-2 fw-bold mt-2">Sửa Danh Mục Thuộc Tính Sản Phẩm</h2>
        @if (isset($productAttributeCategory))
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/product-attribute-categories/update/{{ $productAttributeCategory->id }}">
            @csrf
            <div class="mb-3">
                <label for="exampleName" class="form-label">Tên danh mục</label>
                <input name="name" type="text" class="form-control" id="exampleName" 
                    value="{{ old('name') ? old('name'): $productAttributeCategory->name }}">
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
                <textarea name="description" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('description') ? old('description'):  $productAttributeCategory->description }}</textarea>
                <p class="text-danger">
                    @error('description')
                        {{ $message }}
                    @enderror
                </p>
            </div>
           
            <button type="submit" class="btn btn-outline-primary" onclick="return Confirm('xác nhận lưu')">Lưu</button>
            <a class="btn btn-outline-danger" href="/admin/product-categories">Quay lại danh sách</a>
        </form>
            
        @endif
    </div>
@endsection
