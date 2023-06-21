@push('scripts')
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
            {{-- @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close bg-danger" style="padding: 13px 40px;" data-bs-dismiss="alert"
                        aria-label="Close">Đóng</button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close bg-danger" style="padding: 13px 40px;" data-bs-dismiss="alert"
                        aria-label="Close">Đóng</button>
                </div>
            @endif --}}
            <div class="product wrap__main mt-5 mb-5">
                <section class="product-detail wrap__main-left">
                    @isset($carts)
                        <form action="/carts/checkout" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-bordered table-hover my-4">
                                        <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Sản phẩm</th>
                                                <th scope="col">Phân loại</th>
                                                <th scope="col">Số lượng</th>
                                                <th scope="col">Giá (1)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $key => $cart)
                                                <tr>
                                                    <td scope="row">{{ $key + 1 }}</td>
                                                    <td>{{ $cart->name }}</td>
                                                    <td>'chưa xử lý hiển thị'</td>
                                                    <td>
                                                        <div class="input-group">
                                                            {{ $cart->cart_quantity }}
                                                        </div>
                                                        <p class="text-success mt-2">Còn: {{ $cart->product_detail_quantity }}
                                                        </p>
                                                        @if ($cart->cart_quantity > $cart->product_detail_quantity)
                                                            <span class="text-danger mt-2">
                                                                Hãy cập nhật lại số lượng nhỏ hơn
                                                                {{ $cart->product_detail_quantity + 1 }}!
                                                            </span>
                                                        @endif
                                                    </td>
                                                    @if (isset($cart->sale_price))
                                                        <td>{{ number_format($cart->sale_price, 0, ',', '.') }}<u>đ</u></td>
                                                    @else
                                                        <td>{{ number_format($cart->regular_price, 0, ',', '.') }}<u>đ</u></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="10" class="text-success">
                                                    Tổng tiền: {{ number_format($allPrice, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    {{-- hiển thị input chọn counpount --}}
                                    {{-- thông tin địa chỉ thanh toán --}}
                                    {{-- hình thức thanh toán --}}
                                </div>
                            </div>

                            {{-- <button type="submit" class="btn btn-primary bg-primary">Thanh toán</button> --}}
                            <a href="/cards/payment" class="btn btn-primary bg-primary">Đặt hàng</a>
                        </form>
                    @endisset
                </section>

                <aside class="product-detail wrap__main-right">

                    <div class="product-coupon">
                        <h3 class="product-coupon__title">
                            <i class="product-coupon__title-icon ti-gift"></i> Mã giảm giá
                        </h3>
                        <div class="product-coupon__wrap-item">
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
                        </div>
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
    {{-- <script>
        var minusButton = document.getElementById("minus-btn");
        var plusButton = document.getElementById("plus-btn");
        var quantity = document.getElementById("quantity");

        // Xử lý sự kiện khi người dùng nhấp vào nút tăng giảm số lượng
        minusButton.addEventListener("click", function() {
            if (quantity.value > 1) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        });

        plusButton.addEventListener("click", function() {
            quantity.value = parseInt(quantity.value) + 1;
        });
    </script> --}}
@endsection
