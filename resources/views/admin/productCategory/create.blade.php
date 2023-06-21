@extends('admin.layouts.master')
@section('title', 'Thêm mới danh mục')
@section('content')
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/product-categories/store">
            @csrf
            <div class="mb-3">
                <label for="exampleName" class="form-label">Tên danh mục</label>
                <input name="name" type="text" class="form-control" id="exampleName" value="{{ old('name') }}">
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
            <div class="mb-3">
                <label for="exampleImageUrl" class="form-label">Hình ảnh đại diện</label>
                <input name="image_url" type="file" class="form-control" id="exampleImageUrl"
                    value="{{ old('image_url') }}">

                <p class="text-danger">
                    @error('image_url')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3">
                <label for="exampleImageaAlt" class="form-label">Mô tả hình ảnh</label>
                {{-- <input name="" type="text" value="{{ old('image_alt') }}"> --}}
                <textarea name="image_alt" class="form-control" id="exampleImageAlt" cols="30" rows="1">{{ old('image_alt') }}</textarea>
                <p class="text-danger">
                    @error('image_alt')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
            <a class="btn btn-outline-danger" href="/admin/product-categories">Quay lại danh sách</a>
        </form>
    </div>
@endsection
