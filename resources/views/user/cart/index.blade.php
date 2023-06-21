@push('scripts')
    <script>
        var cartQuantity = {{ isset($carts) ? sizeOf($carts) : 0 }}
    </script>
    <script src="{{ asset('js/user/view-cart.js') }}"></script>
@endpush
{{-- @push('styles')
    <link rel="stylesheet" href="{{ asset('resources/css/user/cart.css') }}">
@endpush --}}
@extends('user.layouts.master')
@section('title', 'Giỏ hàng')
@section('content')
    <main>
        <div class="breadcrumb-css__background">
            <div class="container">
                <nav aria-label="breadcrumb-css breadcrumb ">
                    <ol class=" breadcrumb-css__wrap breadcrumb">
                        <li class="breadcrumb-css__item breadcrumb-item"><a href="index.php?act="
                                class="breadcrumb-css__item-link">Trang
                                chủ</a></li>
                        <li class="breadcrumb-css__item breadcrumb-css__item--active breadcrumb-item active"
                            aria-current="page">Giỏ hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="product wrap__main mt-5 mb-5">
                <section class="product-detail wrap__main-left">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close bg-danger" style="padding: 13px 40px;"
                                data-bs-dismiss="alert" aria-label="Close">Đóng</button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close bg-danger" style="padding: 13px 40px;"
                                data-bs-dismiss="alert" aria-label="Close">Đóng</button>
                        </div>
                    @endif
                    <h2 class="text-center mt-3 mb-3 text-success fs-1 fw-bold">GIỎ HÀNG CỦA BẠN</h2>
                    @isset($carts)
                        <form action="/vouchers/checkout" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input name="code" type="text" class="form-control fs-4" id="exampleCode"
                                            placeholder="Nhập mã voucher"
                                            value="{{ isset($voucherCode) && !empty($voucherCode) && old('code') == '' ? $voucherCode->code : (old('code') != '' ? old('code') : '') }}">
                                        <p class="text-danger">
                                            @error('code')
                                                {{ $message }}
                                            @enderror
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-lg btn-primary bg-primary">Áp mã</button>
                                </div>
                            </div>
                        </form>
                        <form action="/orders/store" method="post">
                            @csrf
                            <div class="" hidden>
                                <input type="text" name="voucher_code"
                                    value="{{ isset($voucherCode) && !empty($voucherCode) && old('voucher_code') == '' ? $voucherCode->code : (old('voucher_code') != '' ? old('voucher_code') : '') }}">
                                <p class="text-danger">
                                    @error('voucher_code')
                                        {{ $message }}
                                    @enderror
                                </p>
                            </div>
                            <table class="table table-bordered table-hover my-4">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Phân loại</th>
                                        <th scope="col">Số lượng mua</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Tổng</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $key => $cart)
                                        <tr>
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td>{{ $cart->name }}</td>
                                            <td>
                                                @if ($cartAttributes["$key"] != '')
                                                    @foreach ($cartAttributes["$key"] as $cartAttribute)
                                                        {{ $cartAttribute->name }},
                                                    @endforeach
                                                @else
                                                    Không có phân loại
                                                @endif
                                            </td>
                                            <td style="max-width: 200px">
                                                <div class="input-group">
                                                    <button class="btn btn-outline-secondary bg-secondary" type="button"
                                                        id="minus-btn-{{ $key }}">-</button>
                                                    <input style="width: 20px;" type="number" class="form-control text-center"
                                                        id="quantity-{{ $key }}" name="quantity_{{ $key }}"
                                                        value="{{ $cart->cart_quantity }}">
                                                    <button class="btn btn-outline-secondary bg-secondary" type="button"
                                                        id="plus-btn-{{ $key }}">+</button>
                                                </div>
                                                <p
                                                    class="{{ $cart->cart_quantity > $cart->product_detail_quantity ? 'text-danger' : 'text-success' }} mt-2">
                                                    Mua tối đa:
                                                    {{ $cart->product_detail_quantity }} Sp</p>
                                                @if ($cart->status != 1)
                                                    <span class="text-danger mt-2">
                                                        Sản phẩm hiện không có sẵn để bán, hãy xóa và cập nhật lại giỏ!
                                                    </span>
                                                @endif
                                            </td>
                                            @if (isset($cart->sale_price))
                                                <td>{{ number_format($cart->sale_price, 0, ',', '.') }}<u>đ</u></td>
                                                <td id="js-all-pricce">
                                                    {{ number_format($cart->cart_quantity * $cart->sale_price, 0, ',', '.') }}<u>đ</u>
                                                </td>
                                            @else
                                                <td>{{ number_format($cart->regular_price, 0, ',', '.') }}<u>đ</u></td>
                                                <td id="js-all-pricce">
                                                    {{ number_format($cart->cart_quantity * $cart->regular_price, 0, ',', '.') }}<u>đ</u>
                                                </td>
                                            @endif
                                            <td>
                                                {{-- <a href="/carts/edit/{{ $cart->product_detail_id }}/{{  }}"
                                                    class="btn btn-danger bg-success btn-sm" id="js-update-one-cart">Cập nhật</a> --}}
                                                <input hidden type="text" id="js-product-detail-id-{{ $key }}"
                                                    value="{{ $cart->product_detail_id }}">
                                                <a href="" class="btn btn-danger bg-success btn-sm"
                                                    id="js-update-one-cart-{{ $key }}">Cập nhật</a>
                                                <a href="/carts/delete/{{ $cart->product_detail_id }}"
                                                    onclick="return confirm('Bạn có muốn xóa không')"
                                                    class="btn btn-danger bg-danger btn-sm">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="10" class="">
                                            @if (isset($voucherCode) && !empty($voucherCode))
                                                <span>Tổng: {{ number_format($allPrice, 0, ',', '.') }} <u>đ</u>|
                                                    <span class="text-success fw-bold">Chỉ còn
                                                        {{ number_format($paymentPrice, 0, ',', '.') }}<u>đ</u></span> |
                                                    <span class="text-danger">Đã giảm:
                                                        {{ number_format($saleEd, 0, ',', '.') }}<u>đ</u> </span></span>
                                            @else
                                                <span class="text-success fw-bold"> Tổng tiền:
                                                    {{ number_format($allPrice, 0, ',', '.') }}<u>đ</u>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="infor-user">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="exampleName" class="form-label">Họ và tên</label>
                                            <input name="name" type="text" class="form-control" id="exampleName"
                                                value="{{ old('name') != '' ? old('name') : (isset(auth()->user()->last_name) && isset(auth()->user()->first_name) ? auth()->user()->last_name . ' ' . auth()->user()->first_name : '') }}">
                                            <p class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </p>
                                            {{-- {{ auth()->user()->last_name . ' ' . auth()->user()->first_name }} --}}
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleaddress" class="form-label">Địa chỉ</label>
                                            <textarea name="address"id=""class="form-control" cols="30" rows="1"id="exampleaddress">{{ old('address') != '' ? old('address') : (isset(auth()->user()->address) ? auth()->user()->address : '') }}</textarea>
                                            <p class="text-danger">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="examplephone_number" class="form-label">Số điện thoại</label>
                                            <input name="phone_number" type="text" class="form-control"
                                                id="examplephone_number"
                                                value="{{ old('phone_number') != '' ? old('phone_number') : (isset(auth()->user()->phone_number) ? auth()->user()->phone_number : '') }}">
                                            <p class="text-danger">
                                                @error('phone_number')
                                                    {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="examplenote" class="form-label">Ghi chú</label>
                                            <textarea name="note"id=""class="form-control" cols="30" rows="1"id="examplenote">{{ old('note') }}</textarea>
                                            <p class="text-danger">
                                                @error('note')
                                                    {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary bg-primary">MUA HÀNG</button>
                        </form>

                        {{-- <a href="/carts/checkout" class="btn btn-primary bg-primary mt-4">MUA HÀNG</a> --}}
                    @else
                        <div class="text-center">
                            <h2 class="text-danger fs-1 fw-bold mt-5 mb-5">Không có sản phẩm nào trong giỏ hàng</h2>
                            <a href="/products" class="fs-3 text-primary">Quay lại trang sản phẩm</a>
                        </div>
                    @endisset
                </section>
                <aside class="product-detail wrap__main-right">

                    <div class="product-coupon">
                        <h3 class="product-coupon__title">
                            <i class="product-coupon__title-icon ti-gift"></i> Mã giảm giá
                        </h3>
                        @isset($vouchers)
                            @foreach ($vouchers as $voucher)
                                <div class="product-coupon__wrap-item">
                                    <div class="product-coupon__wrap-coupon">
                                        <p class="product-coupon__item-code">{{ $voucher->name }}</p>
                                        <img src="https://bizweb.dktcdn.net/100/451/884/themes/857425/assets/coupon1_value_img.png?1678454103962"
                                            alt="" class="product-coupon__item-img">
                                    </div>
                                    <p class="product-coupon__item-description">{{ $voucher->description }}</p>
                                    <form class="product-coupon__item-form" action="">
                                        <input class="product-coupon__item-input" type="text"
                                            value="{{ $voucher->code }}" disabled>
                                        <input class="product-coupon__item-submit btn btn-primary bg-primary" type="submit"
                                            value="Copy">
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <div class="product-coupon__wrap-item">
                                <div class="product-coupon__wrap-coupon">
                                    Không có voucher nào dành cho bạn
                                </div>
                            </div>
                        @endisset



                        {{-- <div class="product-coupon__wrap-item">
                            <div class="product-coupon__wrap-coupon">
                                <p class="product-coupon__item-code">10% OFf</p>
                                <img src="https://bizweb.dktcdn.net/100/451/884/themes/857425/assets/coupon1_value_img.png?1678454103962"
                                    alt="" class="product-coupon__item-img">
                            </div>
                            <p class="product-coupon__item-description">Giảm 10% cho đơn hàng từ 500k</p>
                            <form class="product-coupon__item-form" action="">
                                <input class="product-coupon__item-input" type="text" value="BFAS10">
                                <input class="product-coupon__item-submit" type="submit" value="Copy">
                            </form>
                        </div>
                        <div class="product-coupon__wrap-item">
                            <div class="product-coupon__wrap-coupon">
                                <p class="product-coupon__item-code">15% OFf</p>
                                <img src="https://bizweb.dktcdn.net/100/451/884/themes/857425/assets/coupon2_value_img.png?1678454103962"
                                    alt="" class="product-coupon__item-img">
                            </div>
                            <p class="product-coupon__item-description">Giảm 10% cho đơn hàng từ 999k</p>
                            <form class="product-coupon__item-form" action="">
                                <input class="product-coupon__item-input" type="text" value="BFAS10">
                                <input class="product-coupon__item-submit" type="submit" value="Copy">
                            </form>
                        </div>
                        <div class="product-coupon__wrap-item">
                            <div class="product-coupon__wrap-coupon">
                                <p class="product-coupon__item-code">Free ship</p>
                                <img src="https://bizweb.dktcdn.net/100/451/884/themes/857425/assets/coupon3_value_img.png?1678454103962"
                                    alt="" class="product-coupon__item-img">
                            </div>
                            <p class="product-coupon__item-description">Free ship cho đơn hàng nội thành</p>
                            <form class="product-coupon__item-form" action="">
                                <input class="product-coupon__item-input" type="text" value="BFAS10">
                                <input class="product-coupon__item-submit" type="submit" value="Copy">
                            </form>
                        </div> --}}
                    </div>

                    <div class="wrap-item list-group mt-5">
                        <span class="wrap-item__item-title list-group-item" aria-current="true">
                            Danh mục
                        </span>
                        <?php
                    if (isset($categories)) :
                        foreach ($categories as $category) :
                            extract($category);
                    ?>
                        <a href="index.php?act=products&category=<?= isset($id) && $id ? $id : '' ?>"
                            class="wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            <?= isset($name) && $name ? $name : '' ?>
                            <span
                                class=" wrap-item__item-count badge  rounded-pill"><?= isset($quantity_product) && $quantity_product >= 0 ? $quantity_product : '' ?></span>
                        </a>
                        <?php endforeach;
                    endif;
                    ?>
                    </div>

                    <div class="wrap-item list-group mt-5">
                        <span class="wrap-item__item-title list-group-item" aria-current="true">
                            Có thể bạn thích
                        </span>

                        <?php
                    if (isset($top10RelatedProducts)) :
                        foreach ($top10RelatedProducts as $top10RelatedProduct) :
                            extract($top10RelatedProduct);
                            $url_product = "index.php?act=products_detail&id=" . $id;
                    ?>
                        <a href="<?= isset($url_product) && $url_product ? $url_product : '' ?>"
                            class="wrap-item__product wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            <div class="">
                                <img class="wrap-item__product-img"
                                    src="<?= isset($image_url) && $image_url ? $image_url : '' ?>"
                                    alt="<?= isset($image_alt) && $image_alt ? $image_alt : '' ?>">
                            </div>
                            <div class="wrap-item__product-content">
                                <h2 class="wrap-item__product-title"><?= isset($name) && $name ? $name : 'Chưa có tên' ?>
                                </h2>
                                <p class="wrap-item__product-price card__price ">
                                    <?php if (isset($sale_price) && $sale_price >= 0) : ?>
                                    <span
                                        class="card__price-sale"><?= number_format($sale_price, 0, ',', '.') ?><u>đ</u></span>
                                    <span
                                        class="card__price-regular text-deco-line-th"><?= isset($regular_price) && $regular_price >= 0 ? number_format($regular_price, 0, ',', '.') : '' ?><u>đ</u></span>
                                    <?php else : ?>
                                    <span
                                        class="card__price-sale"><?= isset($regular_price) && $regular_price >= 0 ? number_format($regular_price, 0, ',', '.') : '' ?><u>đ</u></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </a>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
