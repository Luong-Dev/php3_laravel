@push('scripts')
    {{-- <script>
    var cartQuantity = {{ isset($carts) ? sizeOf($carts) : 0 }}
</script> --}}
    <script src="{{ asset('js/user/product-detail.js') }}"></script>
@endpush
@extends('user.layouts.master')
@section('title', 'Chi tiết sản phẩm')
@section('content')
    <main>
        @isset($product)
            <div class="breadcrumb-css__background">
                <div class="container">
                    <nav aria-label="breadcrumb-css breadcrumb ">
                        <ol class=" breadcrumb-css__wrap breadcrumb">
                            <li class="breadcrumb-css__item breadcrumb-item"><a href="index.php?act="
                                    class="breadcrumb-css__item-link">Trang
                                    chủ</a></li>
                            <li class="breadcrumb-css__item breadcrumb-item"><a href="index.php?act=products"
                                    class="breadcrumb-css__item-link">Sản
                                    phẩm</a></li>
                            <li class="breadcrumb-css__item breadcrumb-css__item--active breadcrumb-item active"
                                aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container">
                <button class="js-call-api">CALL API</button>

                <div class="product wrap__main mt-5 mb-5">
                    <section class="product-detail wrap__main-left">
                        <div class="product-detail__wrap-top">
                            <div class="product-detail__image-top">
                                <img src="{{ isset($productImageMain->image_url) ? asset($productImageMain->image_url) : '' }}"
                                    alt="{{ isset($productImageMain->image_alt) ? $productImageMain->image_alt : '' }}"
                                    class="image-top__main">
                                <div class="product-detail__image-wrap-extra">
                                    @isset($productImages)
                                        @foreach ($productImages as $productImage)
                                            <img src="{{ isset($productImage->image_url) ? asset($productImage->image_url) : '' }}"
                                                alt="{{ isset($productImageMain->image_alt) ? $productImageMain->image_alt : '' }}"
                                                class="image-top__extra">
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                            <form action="/carts" method="POST" class="product-detail__content-top">
                                @csrf
                                <input type="text" value="{{ isset($product->id) ? $product->id : '' }}" name="productId"
                                    hidden>
                                <h1 class="content-top__title">
                                    {{ isset($product->name) ? $product->name : '' }}
                                    <span class="fs-4 fw-bold">- Lượt xem:
                                        {{ isset($product->views) ? $product->views : '' }}</span>
                                </h1>
                                {{-- <div class="content-top__color-wrap">
                                <p class="content-top__color-title">Màu sắc: <span class="content-top__color">Trắng</span>
                                </p>
                                <div class="content-top__description">
                                    <span
                                        class="content-top__description-color content-top__description-color-active"></span>
                                    <span class="content-top__description-color"></span>
                                    <span class="content-top__description-color"></span>
                                </div>
                            </div>
                            <div class="content-top__size-wrap">
                                <p class="content-top__size-title">Kích thước: <span class="content-top__size">M</span></p>
                                <div class="content-top__description">
                                    <span
                                        class="content-top__description-size content-top__description-size-active">S</span>
                                    <span class="content-top__description-size">M</span>
                                    <span class="content-top__description-size">L</span>
                                </div>
                            </div> --}}
                                {{-- productAttributes --}}
                                {{-- @if ($productAttributeCategories['0'])
                                
                            @endif --}}
                                {{-- @php
                                var_dump($productAttributeCategories['0']->quantity_product_attribute_category);
                            @endphp --}}
                                @isset($productAttributeCategories, $productAttributes)
                                    {{-- xét trường hợp có tồn tại và có thuộc tính sản phẩm --}}
                                    @if ($productAttributeCategories['0']->quantity_product_attribute_category > 0)
                                        <p class="content-top__code-wrap">Mã: <span
                                                class="content-top__code">{{ isset($product->productCode) ? $product->productCode : 'Chưa có' }}</span>
                                        </p>
                                        <span class="content-top__trademark-wrap">Thương hiệu: <span
                                                class="content-top__trademark">{{ isset($product->trademark) ? $product->trademark : 'Cú đêm shop' }}</span>
                                        </span>
                                        <span class="content-top__status-wrap">Trạng thái: <span class="content-top__status">
                                                <?php if (isset($arrStatus) && $arrStatus) : ?>
                                                <?php foreach ($arrStatus as $key => $item) : ?>
                                                <?= isset($product['status']) && $product['status'] && $product['status'] == $key + 1 ? $item : '' ?>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </span>
                                        </span>
                                        <p class="content-top__price-wrap">
                                            <?php if (isset($product['sale_price']) && $product['sale_price'] >= 0) : ?>
                                            <span><?= number_format($product['sale_price'], 0, ',', '.') ?><u>đ</u></span>
                                            <span
                                                class="content-top__regular-price"><?= isset($product['regular_price']) && $product['regular_price'] >= 0 ? number_format($product['regular_price'], 0, ',', '.') : '' ?><u>đ</u></span>
                                            <?php else : ?>
                                            <span><?= isset($product['regular_price']) && $product['regular_price'] >= 0 ? number_format($product['regular_price'], 0, ',', '.') : '' ?><u>đ</u></span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="content-top__description-short">
                                            {{ isset($product->short_description) ? $product->short_description : '' }}
                                        </p>
                                        @foreach ($productAttributeCategories as $productAttributeCategory)
                                            <input type="text" name="attributes[]" value="{{ $productAttributeCategory->id }}"
                                                hidden>
                                            @if ($productAttributeCategory->id == 6)
                                                <div class="content-top__color-wrap">
                                                    <p class="content-top__color-title">{{ $productAttributeCategory->name }}:
                                                    </p>
                                                    <div class="content-top__description">
                                                        @foreach ($productAttributes as $key => $productAttribute)
                                                            @if ($productAttribute->product_attribute_category_id == $productAttributeCategory->id)
                                                                <input class="me-1 js-color" {{ $key == 0 ? 'checked' : '' }}
                                                                    name="attributes_{{ $productAttributeCategory->id }}"
                                                                    type="radio" value="{{ $productAttribute->id }}"
                                                                    id="attributes_{{ $productAttribute->id }}"
                                                                    {{ old("attributes_$productAttributeCategory->id") == $productAttribute->id ? 'checked' : '' }}>
                                                                <label class="content-top__description-color me-4"
                                                                    style="background-color: {{ $productAttribute->description_value }}"
                                                                    for="attributes_{{ $productAttribute->id }}">{{ $productAttribute->name }}</label>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <p class="text-danger mt-2">
                                                        @error("attributes_$productAttributeCategory->id")
                                                            {{ $message }}
                                                        @enderror
                                                    </p>
                                                </div>
                                            @else
                                                <div class="content-top__size-wrap">
                                                    <p class="content-top__size-title">{{ $productAttributeCategory->name }}:
                                                    </p>
                                                    <div class="content-top__description">
                                                        @foreach ($productAttributes as $index => $productAttribute)
                                                            @if ($productAttribute->product_attribute_category_id == $productAttributeCategory->id)
                                                                <input class="me-1 js-memory" {{ $index == 0 ? 'checked' : '' }}
                                                                    name="attributes_{{ $productAttributeCategory->id }}"
                                                                    type="radio" value="{{ $productAttribute->id }}"
                                                                    id="attributes_{{ $productAttribute->id }}"
                                                                    {{ old("attributes_$productAttributeCategory->id") == $productAttribute->id ? 'checked' : '' }}>
                                                                <label class="content-top__description-size me-4"
                                                                    for="attributes_{{ $productAttribute->id }}">{{ $productAttribute->name }}</label>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <p class="text-danger mt-2">
                                                        @error("attributes_$productAttributeCategory->id")
                                                            {{ $message }}
                                                        @enderror
                                                    </p>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- xét trường hợp có tồn tại và không có thuộc tính sản phẩm thì $productAttributeCategories['0']->quantity_product_attribute_category sẽ bằng 0 --}}
                                        @isset($productNoAttribute)
                                            <input type="text" name="product_detail_id" value="{{ $productNoAttribute->id }}"
                                                hidden>
                                            <p class="content-top__code-wrap">Mã: <span
                                                    class="content-top__code">{{ isset($product->productCode) ? $product->productCode : 'Chưa có' }}</span>
                                            </p>
                                            <span class="content-top__trademark-wrap">Thương hiệu: <span
                                                    class="content-top__trademark">{{ isset($productNoAttribute->trademark) ? $productNoAttribute->trademark : 'Cú đêm shop' }}</span>
                                            </span>
                                            <span class="content-top__status-wrap">Trạng thái:
                                                <span class="content-top__status">
                                                    @foreach ($productStatus as $key => $status)
                                                        @if ($productNoAttribute->status == $key)
                                                            {{ $status }}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </span>
                                            <p class="content-top__price-wrap">
                                                @if (!empty($productNoAttribute->sale_price))
                                                    <span>{{ number_format($productNoAttribute->sale_price, 0, ',', '.') }}<u>đ</u></span>
                                                    <span
                                                        class="content-top__regular-price">{{ number_format($productNoAttribute->regular_price, 0, ',', '.') }}<u>đ</u></span>
                                                @else
                                                    <span>{{ number_format($productNoAttribute->regular_price, 0, ',', '.') }}<u>đ</u></span>
                                                @endif
                                            </p>
                                            <p class="content-top__description-short">
                                                {{ isset($product->short_description) ? $product->short_description : '' }}
                                            </p>
                                        @endisset
                                    @endif
                                    <div class="content-top__form">
                                        <div class="content-top__form-wrap">
                                            <button class="content-top__form-minus"><i class="ti-minus"></i></button>
                                            <input name="quantity" class="content-top__form-quantity" type="number"
                                                value="{{ old('quantity') != '' ? old('quantity') : 1 }}">
                                            <button class="content-top__form-plus"><i class="ti-plus"></i></button>
                                            <input class="content-top__form-submit bg-success btn" type="submit"
                                                value="THÊM VÀO GIỎ HÀNG">
                                            <span class="content-top__form-heart">
                                                <i class="content-top__form-heart-icon ti-heart"></i>
                                            </span>
                                        </div>
                                        <p class="text-danger mt-2">
                                            @error('quantity')
                                                {{ $message }}
                                            @enderror
                                        </p>
                                    </div>
                                    @if (session('error'))
                                        <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close bg-danger" style="padding: 13px 40px;"
                                                data-bs-dismiss="alert" aria-label="Close">Đóng</button>
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close bg-danger" style="padding: 13px 40px;"
                                                data-bs-dismiss="alert" aria-label="Close">Đóng</button>
                                        </div>
                                    @endif
                                @else
                                    {{-- trường hợp sản phẩm chưa cài đặt giá thì không hiển thị gì cho khách thao tác được --}}
                                    {{-- hiện tại đang đẩy về trang sản phẩm và báo sả phẩm không tồn tại hoặc đang không có hàng để bán --}}
                                @endisset
                            </form>
                        </div>
                        <div class="content-top__description-long">
                            <h3 class="description-long__title">Mô tả sản phẩm</h3>
                            <p class="description-long__content">
                                {{ isset($product->long_description) ? $product->long_description : 'Không có mô tả!' }}
                            </p>
                        </div>
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
        @endisset
    </main>
@endsection
