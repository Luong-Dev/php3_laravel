@extends('admin.layouts.master')
@section('title', 'Thêm mới danh mục')
@section('content')
    <div class="container mt-5">
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/product-attribute-categories/store">
            @csrf
            <div class="mb-3">
                <label for="exampleName" class="form-label">Tên danh mục thuộc tính sản phẩm</label>
                <input name="name" type="text" class="form-control" id="exampleName" aria-describedby="emailHelp"
                    value="{{ old('name') }}">
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
                <textarea name="description" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('description') }}</textarea>
                <p class="text-danger">
                    @error('description')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
            <a class="btn btn-outline-danger" href="/admin/product-attribute-categories">Quay lại danh sách</a>
        </form>
    </div>
@endsection
