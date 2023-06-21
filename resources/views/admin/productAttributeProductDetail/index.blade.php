@extends('admin.layouts.master')
@section('title', 'Thêm mới chi tiết sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-1 fw-bold">Cập nhật chi tiết cho sản phẩm:
            {{ isset($product->name) ? $product->name : 'Không tồn tại sản phẩm' }}</h2>
        <p class="text-warning mt-2">Những chỗ nào màu đỏ phải cập nhật thì mới hiển thị được cho người dùng!</p>
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
        @isset($productDetails)
            {{-- {{ var_dump($productDetails) }} --}}
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Option thuộc tính</th>
                        <th scope="col">Gía thường</th>
                        <th scope="col">Gía giảm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thao tác</th>
                        {{-- chi tiết có mô tả dài, thông giá ..... --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productDetails as $key => $productDetail)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($productDetail->id) ? $productDetail->id : '' }}</td> --}}

                            @if (count($mixOptions[$productDetail->id]) > 0)
                                <td class="text-primary">
                                    @foreach ($mixOptions[$productDetail->id] as $item)
                                        {{ $item->product_attribute_category_name }} : {{ $item->product_attribute_name }}
                                    @endforeach
                                </td>
                            @else
                                <td class="text-danger">
                                    Không có thuộc tính nào!
                                </td>
                            @endif
                            @if (isset($productDetail->regular_price) && $productDetail->regular_price >= 0)
                                <td class="text-success">{{ $productDetail->regular_price }} Vnđ</td>
                            @else
                                <td class="text-danger">Hãy cập nhật!</td>
                            @endif
                            @if (isset($productDetail->sale_price) && $productDetail->sale_price >= 0)
                                <td class="text-success">{{ $productDetail->sale_price }} Vnđ</td>
                            @else
                                <td class="text-warning">Nên cập nhật!</td>
                            @endif
                            @if (isset($productDetail->quantity) && $productDetail->quantity >= 0)
                                <td class="text-success">{{ $productDetail->quantity }} Vnđ</td>
                            @else
                                <td class="text-danger">Hãy cập nhật!</td>
                            @endif
                            @isset($arrStatus)
                                <td class="text-danger">
                                    @foreach ($arrStatus as $key => $status)
                                        {{ $productDetail->status == $key ? $status : '' }}
                                    @endforeach
                                    {{-- {{ $productDetail->status }} --}}
                                </td>
                            @endisset
                            <td>
                                <a href="/admin/product-details/edit/{{ isset($product->id) ? $product->id : '' }}/{{ isset($productDetail->id) ? $productDetail->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/product-details/delete/{{ isset($product->id) ? $product->id : '' }}/{{ isset($productDetail->id) ? $productDetail->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $productDetails->links() }} --}}
        @endisset

    </div>
@endsection
