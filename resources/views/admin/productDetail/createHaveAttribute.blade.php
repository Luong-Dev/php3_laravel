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
        @isset($mixOptions)
            {{ var_dump($mixOptions) }}
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Option thuộc tính</th>
                        <th scope="col">Gía thường</th>
                        <th scope="col">Gía giảm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thao tác</th>
                        {{-- chi tiết có mô tả dài, thông giá ..... --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mixOptions as $key => $mixOption)
                        <br>
                        {{ var_dump($mixOption) }}


                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($mixOption->id) ? $mixOption->id : '' }}</td> --}}
                            <td class="text-primary">
                                @foreach ($mixOption as $value)
                                    @foreach ($productAttributes as $productAttribute)
                                        {{ $value == $productAttribute->id ? $productAttribute->name : '' }}
                                    @endforeach
                                @endforeach
                            </td>
                            <td class="text-success">
                                {{ isset($mixOption->mixOption_quantity) ? $mixOption->mixOption_quantity : 'Sửa sau' }}
                            </td>
                            <td class="text-success">
                                {{ isset($mixOption->mixOption_quantity) ? $mixOption->mixOption_quantity : 'Sửa sau' }}
                            </td>
                            <td class="text-success">
                                {{ isset($mixOption->mixOption_quantity) ? $mixOption->mixOption_quantity : 'Sửa sau' }}
                            </td>

                            <td>
                                <a href="/admin/product-details/detail/{{ isset($product->id) ? $product->id : '' }}"
                                    class="btn btn-primary btn-sm">Chi tiết</a>
                                <a href="/admin/products/edit/{{ isset($product->id) ? $product->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/products/delete/{{ isset($product->id) ? $product->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $mixOptions->links() }} --}}
        @endisset

    </div>
@endsection
