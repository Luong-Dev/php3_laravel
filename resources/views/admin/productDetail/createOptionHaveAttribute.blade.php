@extends('admin.layouts.master')
@section('title', 'Thêm mới chi tiết sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-2 fw-bold mt-2 mb-3">Chọn thuộc tính cho sản phẩm:
            {{ isset($product->product_name) ? $product->product_name : '' }}
        </h2>
        <a href="/admin/product-images/create/{{ isset($product->product_id) ? $product->product_id : '' }}"
            class="btn btn-outline-primary mb-3">Thêm h/ả sp</a>
        @if (isset($product))
            <div class="mb-3">
                <label for="exampleName" class="form-label">Tên sản phẩm</label>
                <input name="name" type="text" class="form-control" id="exampleName" value="{{ $product->product_name }}"
                    disabled>
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
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Danh mục sản phẩm</label>
                <input disabled type="text" value="{{ $product->product_category_name }}"class="form-control">
            </div>


            <form class="form-control mt-5" method="POST" enctype="multipart/form-data"
                action="/admin/product-details/store-option-have-attribute/{{ $product->product_id }}">
                {{-- action="/admin/product-attribute-product-detail/create/{{ $product->product_id }}"> --}}
                @csrf
                <div class="mb-3">
                    @isset($productAttributeCategories)
                        @foreach ($productAttributeCategories as $key => $productAttributeCategory)
                            <div class="mb-3">
                                <label for="">
                                    {{ $productAttributeCategory->name }}:
                                    {{-- {{ $productAttributeCategory->id }} --}}
                                </label>
                                @isset($productAttributes)
                                    @foreach ($productAttributes as $index => $productAttribute)
                                        @if ($productAttribute->product_attribute_category_id == $productAttributeCategory->id)
                                            <input class="ms-3" name="attributes_{{ $productAttributeCategory->id }}[]"
                                                type="checkbox" value="{{ $productAttribute->id }}">
                                            {{ $productAttribute->name }}
                                        @endif
                                    @endforeach
                                @endisset
                            </div>
                        @endforeach
                    @endisset
                </div>
                <button type="submit" class="btn btn-outline-primary">Chọn option</button>
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
