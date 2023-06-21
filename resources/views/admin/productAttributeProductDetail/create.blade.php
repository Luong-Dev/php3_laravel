@extends('admin.layouts.master')
@section('title', 'Thêm mới chi tiết sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-1 fw-bold">Cập nhật chi tiết cho sản phẩm:
            {{ isset($product->name) ? $product->name : 'Không tồn tại sản phẩm' }}</h2>
        {{-- {{ var_dump($product->name) }}
        <br>
        {{ var_dump($productId) }}
        <br> --}}
        {{-- có bn options có bấy nhiêu form cập nhật --}}
        {{-- mỗi form cập nhật cần có giá, sale, số lượng, trạng thái --}}
        @isset($mixOptions)
            {{ var_dump($mixOptions) }}
            <form class="form-control" method="POST" enctype="multipart/form-data"
                action="/admin/product-attribute-product-detail/store/{{ $product->id }}">
                @csrf
                <input type="text" value="{{ count($mixOptions) }}" disabled name="optionQuantity">
                <br>
                @foreach ($mixOptions as $key => $mixOption)
                    <td class="text-primary">Option:
                        @foreach ($mixOption as $value)
                            @foreach ($productAttributes as $productAttribute)
                                {{ $value == $productAttribute->id ? $productAttribute->name : '' }}
                            @endforeach
                        @endforeach
                    </td>
                    <div class="mb-3">
                        <label for="exampleName" class="form-label">Gía {{ $key + 1 }}</label>
                        <input name="price{{ $key + 1 }}" type="number" class="form-control" id="exampleName">
                    </div>
                @endforeach
                <button type="submit" class="btn btn-outline-primary">Cập nhật</button>
            </form>
        @endisset
    </div>
@endsection
