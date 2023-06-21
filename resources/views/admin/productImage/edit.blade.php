@extends('admin.layouts.master')
@section('title', 'Sửa Ảnh Sản Phẩm')
@section('content')
    <div class="container mt-5">
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
        @if (isset($productImage))
            <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/product-images/update">
                @csrf


                <div class="mb-3" hidden>
                    <label for="exampleName" class="form-label">Id Ảnh Sản Phẩm</label>
                    <input readonly name="productImageId" type="text" class="form-control" id="exampleName"
                        value="{{ isset($productImage->id) ? $productImage->id : 1 }}">
                    <p class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="mb-3">
                    <label for="exampleName" class="form-label ">Ảnh Trước đó: </b></label>
                    <img style="width:70px ; height:70px" src="/{{ isset($productImage) ? $productImage->image_url : '' }}">
                </div>


                <div class="mb-3">
                    <label for="exampleImageUrl" class="form-label">Hình ảnh Sản Phẩm</label>
                    <input name="image_url" type="file" class="form-control" id="exampleImageUrl"
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
                    <textarea name="image_alt" class="form-control" id="exampleDescription" cols="30" rows="2">{{ isset($productImage->image_alt) ? $productImage->image_alt : ' ' }}</textarea>
                    <p class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <button type="submit" class="btn btn-outline-primary">Lưu Ảnh</button>

            </form>
        @else
            <p></p>
        @endif
        <a class="btn btn-outline-danger"
            href="/admin/product-details/detail/{{ isset($productImage->product_id) ? $productImage->product_id : '' }}">Quay
            lại Sản Phẩm</a>
    </div>
@endsection
