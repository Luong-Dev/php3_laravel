@extends('admin.layouts.master')
@section('title', 'Thêm mới Ảnh Sản Phẩm')
@section('content')
    <div class="container mt-5">
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/product-images/store">
            @csrf
            @if ($product == null || !isset($product))
                <h1>Không Tìm Thấy Sản Phẩm Để Thêm</h1>
            @else
                <div class="mb-3" hidden>
                    <label for="exampleName" class="form-label">Id Sản Phẩm</label>
                    <input readonly name="productId" type="text" class="form-control" id="exampleName"
                        value="{{ isset($id) ? $id : 1 }}">
                    <p class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleName" class="form-label ">Ảnh Cho Sản Phẩm :
                        <b>{{ isset($product) ? $product->name : '' }}</b></label>
                </div>
                <div class="mb-3">
                    <label for="exampleImageUrl" class="form-label">Hình ảnh Sản Phẩm</label>
                    <input name="image_url[]" type="file" class="form-control" multiple id="exampleImageUrl"
                        value="{{ old('image_url') }}">
                    <p class="text-danger">
                        @error('image_url')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleDescription" class="form-label">Image Alt</label>
                    {{-- <input name="description" type="text"
                    value="{{ old('description') }}"> --}}
                    <textarea name="image_alt" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('image_alt') }}</textarea>
                    <p class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
                <a class="btn btn-outline-danger"
                    href="/admin/product-details/detail/{{ isset($product->id) ? $product->id : '' }}">Quay
                    lại Sản Phẩm</a>
            @endif
        </form>
    </div>
@endsection
