@extends('admin.layouts.master')
@section('title', 'Chi tiết sản phẩm')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-1 fw-bold">Chi tiết cho sản phẩm:
            {{ isset($product->name) ? $product->name : 'Không tồn tại sản phẩm' }}</h2>
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
        <div class="mb-3">
            <label for="" class="form-label">Mô tả ngắn</label>
            <textarea disabled name="" class="form-control" id="exampleShortDescription" cols="30" rows="1">{{ isset($product->short_description) ? $product->short_description : '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mô tả dài</label>
            <textarea disabled name="" class="form-control" id="exampleLongDescription" cols="30" rows="2">{{ isset($product->long_description) ? $product->long_description : '' }}</textarea>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="" class="form-label">Số lượt xem</label>
                <input disabled type="text"
                    value="{{ isset($product->views) ? $product->views : '' }}"class="form-control">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Danh mục</label>
                <input disabled type="text"
                    value="{{ isset($product->product_category_name) ? $product->product_category_name : '' }}"class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <a href="/admin/products/edit/{{ isset($product->id) ? $product->id : '' }}" class="btn btn-outline-success">Sửa
                thông tin chung sản phẩm</a>
            <a href="#productImage" class="btn btn-info">Hình ảnh sản phẩm</a>
        </div>
        <p class="text-warning mt-2 mb-3">Bạn phải cập nhật những thông tin có màu đỏ để hiển thị ra người dùng!
        </p>

        @isset($productDetails)
            <table class="mt-3 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Option thuộc tính</th>
                        <th scope="col">Gía thường</th>
                        <th scope="col">Gía giảm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productDetails as $key => $productDetail)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
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
                                <td class="text-success">{{ number_format($productDetail->regular_price, 2, ',', '.') }} Vnđ
                                </td>
                            @else
                                <td class="text-danger">Hãy cập nhật!</td>
                            @endif
                            @if (isset($productDetail->sale_price) && $productDetail->sale_price >= 0)
                                <td class="text-success">{{ $productDetail->sale_price }}</td>
                            @else
                                @if (isset($productDetail->sale_price) && $productDetail->sale_price < 0)
                                    <td class="text-danger">Hãy cập nhật!</td>
                                @else
                                    <td class="text-dark">Không có!</td>
                                @endif
                            @endif
                            @if (isset($productDetail->quantity) && $productDetail->quantity >= 0)
                                <td class="text-success">{{ $productDetail->quantity }}</td>
                            @else
                                <td class="text-danger">Hãy cập nhật!</td>
                            @endif
                            @isset($arrStatus)
                                <td class="text-dark">
                                    @foreach ($arrStatus as $key => $status)
                                        {{ $productDetail->status == $key ? $status : '' }}
                                    @endforeach
                                </td>
                            @endisset
                            <td>
                                <a href="/admin/product-details/edit/{{ isset($product->id) ? $product->id : '' }}/{{ isset($productDetail->id) ? $productDetail->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/product-details/delete-one/{{ isset($product->id) ? $product->id : '' }}/{{ isset($productDetail->id) ? $productDetail->id : '' }}"
                                    onclick="return confirm('Việc xóa là không khôi phục lại được, Bạn có thể chuyển trạng thái sp sang hết hàng thay vì xóa, Bạn chắc là xóa chứ?')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="/admin/product-details/create-no-attribute/{{ isset($product->id) ? $product->id : '' }}"
                class="btn btn-outline-primary">Thêm mới chi tiết</a>
            <a href="/admin/product-details/delete-all/{{ isset($product->id) ? $product->id : '' }}"
                onclick="return confirm('Việc build lại sẽ xóa hết tất cả các options đang có, Bạn cân nhắc kỹ rồi chứ?')"
                class="btn btn-outline-danger">Thiết lập lại chi tiết</a>
            <a href="/admin/products" class="btn btn-outline-dark">Danh sách sản phẩm</a>
            {{-- {{ $productDetails->links() }} --}}
        @endisset

        <div class="images">
            <div class="row">
                <div class="col-md-6">
                    <h2 id="productImage" class="text-success mt-5 fs-2 fw-bold">Ảnh sản phẩm</h2>
                </div>
            </div>
            @if (isset($productImages))
                <table class="mt-5 table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ảnh Sản Phẩm</th>
                            <th scope="col">Vị trí</th>
                            <th scope="col">Mô Tả dự phòng</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productImages as $key => $productImage)
                            <tr>
                                <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}
                                </th>
                                <td>
                                    <img style="width: 100px ; height:60px"
                                        src="/{{ isset($productImage->image_url) ? $productImage->image_url : '' }}"
                                        alt="Link hỏng">
                                </td>
                                @isset($productImage->level)
                                    <td>{{ $productImage->level == 0 ? 'Ảnh chính' : 'Ảnh phụ' }}</td>
                                @endisset
                                <td>{{ isset($productImage->image_alt) ? $productImage->image_alt : 'Không có' }}</td>
                                <td>
                                    <a href="/admin/product-images/edit/{{ isset($productImage->id) ? $productImage->id : '' }}"
                                        class="btn btn-outline-success btn-sm">Sửa vị trí</a>
                                    <a href="/admin/product-images/delete/{{ isset($productImage->id) ? $productImage->id : '' }}"
                                        onclick="return confirm('Bạn có muốn xóa không')"
                                        class="btn btn-outline-danger btn-sm">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <a href="/admin/product-images/create/{{ isset($product->id) ? $product->id : '' }}"
                class="btn btn-outline-primary">Thêm h/ả sp</a>
        </div>
    </div>
@endsection
