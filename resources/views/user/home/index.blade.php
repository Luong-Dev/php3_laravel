{{-- @push('scripts')
    <script></script>
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('resources/css/user/cart.css') }}">
@endpush --}}
@extends('user.layouts.master')
@section('title', 'Trang chủ')
@section('content')
    <div class="container-fluid slide-show fix">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                @if (isset($banners) && $banners)
                    @foreach ($banners as $key => $banner)
                        @if ($banner->location == 0)
                            @if ($key == 0)
                                <button type="button" data-bs-target="#carouselExampleIndicators"
                                    data-bs-slide-to="{{ $key }}" class="active" aria-current="true"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                            @else
                                <button type="button" data-bs-target="#carouselExampleIndicators"
                                    data-bs-slide-to="{{ $key }}" aria-label="Slide {{ $key + 1 }}"></button>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="carousel-inner">
                @if (isset($banners) && $banners)
                    @foreach ($banners as $key => $banner)
                        @if ($banner->location == 0)
                            @if ($key == 0)
                                <div class="carousel-item active">
                                    <img src="{{ $banner->image_url }}" class="d-block w-100"
                                        alt="{{ $banner->image_alt }}">
                                </div>
                            @else
                                <div class="carousel-item ">
                                    <img src="{{ $banner->image_url }}" class="d-block w-100"
                                        alt="{{ $banner->image_alt }}">
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <main>
        <div class="container">
            <div class="information mt-5">
                <div class="information__wrap">
                    <div class="information__icon">
                        <img class="information__icon-img" src="{{ asset('/icons/information/ser_1.webp') }}"
                            alt="">
                    </div>
                    <div class="information__content-wrap">
                        <p class="information__content">Vận chuyển <span class="information__content-bold">MIỄN PHÍ</span>
                        </p>
                        <p class="information__content">Trong khu vực <span class="information__content-bold">TP.HÀ
                                NỘI</span></p>
                    </div>
                </div>
                <div class="information__wrap">
                    <div class="information__icon">
                        <img class="information__icon-img" src="{{ asset('/icons/information/ser_2.webp') }}"
                            alt="">
                    </div>
                    <div class="information__content-wrap">
                        <p class="information__content">Đổi trả <span class="information__content-bold">MIỄN PHÍ</span></p>
                        <p class="information__content">Trong vòng <span class="information__content-bold">30 NGÀY</span>
                        </p>
                    </div>
                </div>
                <div class="information__wrap">
                    <div class="information__icon">
                        <img class="information__icon-img" src="{{ asset('/icons/information/ser_3.webp') }}"
                            alt="">
                    </div>
                    <div class="information__content-wrap">
                        <p class="information__content">Tiến hành <span class="information__content-bold">THANH TOÁN</span>
                        </p>
                        <p class="information__content">Với nhiều <span class="information__content-bold">PHƯƠNG THỨC</span>
                        </p>
                    </div>
                </div>
                <div class="information__wrap">
                    <div class="information__icon">
                        <img class="information__icon-img" src="{{ asset('/icons/information/ser_4.webp') }}"
                            alt="">
                    </div>
                    <div class="information__content-wrap">
                        <p class="information__content"><span class="information__content-bold">100% HOÀN TIỀN</span></p>
                        <p class="information__content">Nếu sản phẩm lỗi <span class="information__content-bold"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="wrap__main mt-5 mb-5">
                <section class="wrap__main-left">
                    {{-- <div class="product-home">
                        <h2 class="text-center fw-bold"><a href="index.php?act=products&sort=number_sold&category=0"
                                class="fs-1 text-dark text-deco-none">#Top Bán Chạy</a>
                        </h2>
                        <div class="grid-col-4 mt-5">
                            <div class="card border-0 shadow rounded" style="width: 100%; ">
                                <a href="" class="text-deco-none card__wrap-image">
                                    <img src="https://bizweb.dktcdn.net/thumb/large/100/451/884/products/aocottondangsuongfreesizeinchu.jpg?v=1649173049000"
                                        class="card-img-top" alt="...">
                                    <i class="card__price-sale-image">- 20%</i>
                                </a>
                                <div class="card-body">
                                    <h3 class="card-title"><a href="" class="card__name text-deco-none">Áo Cotton
                                            Nữ cổ tròn
                                            dáng suôn chữ in theo trend</a></h3>
                                    <p class="card__price mt-3">
                                        <span class="card__price-sale">195.000<u>đ</u></span>
                                        <span class="card__price-regular text-deco-line-th">250.000<u>đ</u></span>
                                    </p>
                                    <div class="card__sold text-center">
                                        <span class="card__sold-sale-bar">
                                            <span class="card__sold-sale-bar-text">#1</span>
                                        </span>
                                        <span class="card__sold-text">Đã bán 236</span>
                                        <span class="card__sold-countdown" style="width: 40%;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <a href="index.php?act=products&sort=number_sold&category=0"
                                class=" product-home__view-more">Xem thêm</a>
                        </div>
                    </div> --}}
                    <div class="product-home mt-5">
                        <h2 class="text-center fw-bold"><a href="index.php?act=products&sort=view_number&category=0"
                                class="fs-1 text-dark text-deco-none">#Top Yêu Thích</a>
                        </h2>
                        <div class="grid-col-4 mt-5">
                            @if (isset($topProductLoves) && $topProductLoves)
                                @foreach ($topProductLoves as $key => $topProductLove)
                                    <div class="card border-0 shadow rounded p-2" style="width: 100%; ">
                                        <a href="/products/details/{{ $topProductLove->id }}"
                                            class="text-deco-none card__wrap-image">
                                            <img class="m-auto" style="width: 200px ; height:250px"
                                                src="./{{ $topProductLove->image_url }}" class="card-img-top"
                                                alt="./{{ $topProductLove->image_url }}">
                                        </a>
                                        <div class="card-body">
                                            <h3 class="card-title"><a href="/products/details/{{ $topProductLove->id }}"
                                                    class="card__name text-deco-none">{{ $topProductLove->name }}</a>
                                            </h3>
                                            <p class="card__price mt-3">
                                                @if (isset($topProductLove->min_sale_price) && $topProductLove->min_sale_price >= 0)
                                                    <span
                                                        class="card__price-sale"><?= number_format($topProductLove->min_sale_price, 0, ',', '.') ?><u>đ</u></span>
                                                    <span
                                                        class="card__price-regular text-deco-line-th"><?= isset($topProductLove->max_regular_price) && $topProductLove->max_regular_price >= 0 ? number_format($topProductLove->max_regular_price, 0, ',', '.') : '' ?><u>đ</u></span>
                                                @else
                                                    <span
                                                        class="card__price-sale"><?= isset($topProductLove->max_regular_price) && $topProductLove->max_regular_price >= 0 ? number_format($topProductLove->max_regular_price, 0, ',', '.') : '' ?><u>đ</u></span>
                                                @endif
                                            </p>
                                            <div class="card__sold text-center">
                                                <span class="card__sold-sale-bar">
                                                    <span class="card__sold-sale-bar-text">#<?= $key + 1 ?></span>
                                                </span>
                                                <span class="card__sold-text">Đã bán {{ rand(1, 15) }}

                                                    <span class="card__sold-countdown"
                                                        style="width:<?= isset($number_sold) && $number_sold && isset($quantity) && $quantity ? ($number_sold / $quantity) * 100 : '' ?>%; max-width: 100%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach;
                            @endif;
                        </div>
                        <div class="text-center mt-5">
                            <a href="index.php?act=products&sort=view_number&category=0"
                                class=" product-home__view-more">Xem thêm</a>
                        </div>
                    </div>
                </section>
                <aside class="wrap__main-right mt-5">
                    <div class="wrap-item list-group mt-5">
                        <span class="wrap-item__item-title list-group-item" aria-current="true">
                            Danh mục
                        </span>
                        @isset($productCategories)
                            @foreach ($productCategories as $productCategory)
                                <a href="index.php?act=products&category=<?= isset($id) && $id ? $id : '' ?>"
                                    class="wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                                    {{ isset($productCategory->name) ? $productCategory->name : '' }}
                                    <span
                                        class=" wrap-item__item-count badge  rounded-pill">{{ isset($productCategory->product_quantity) ? $productCategory->product_quantity : '' }}</span>
                                </a>
                            @endforeach
                        @endisset
                    </div>
                    <div class="wrap-item list-group mt-5">
                        <span class="wrap-item__item-title list-group-item" aria-current="true">
                            Sản Phẩm Mới
                        </span>
                        @isset($topProductLoves)
                            @foreach ($topProductLoves as $topProductNew)
                                <a href="/products/details/{{ isset($topProductNew->id) ? $topProductNew->id : '' }}"
                                    class="wrap-item__product wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                                    <div class="">
                                        <img class="wrap-item__product-img"
                                            src="./{{ isset($topProductNew->image_url) ? $topProductNew->image_url : '' }}"
                                            alt="{{ isset($topProductNew->id) ? $topProductNew->id : '' }}">
                                    </div>
                                    <div class="wrap-item__product-content">
                                        <h2 class="wrap-item__product-title">
                                            {{ isset($topProductNew->name) ? $topProductNew->name : '' }}
                                        </h2>
                                        {{-- <p class="wrap-item__product-price card__price ">
                                            @if (isset($sale_price) && $sale_price >= 0)
                                                <span
                                                    class="card__price-sale">{{ number_format($sale_price, 0, ',', '.') }}<u>đ</u></span>
                                                <span
                                                    class="card__price-regular text-deco-line-th">{{ isset($regular_price) && $regular_price >= 0 ? number_format($regular_price, 0, ',', '.') : '' }}<u>đ</u></span>
                                            @else
                                                <span
                                                    class="card__price-sale">{{ isset($regular_price) && $regular_price >= 0 ? number_format($regular_price, 0, ',', '.') : '' }}<u>đ</u></span>
                                            @endif
                                        </p> --}}
                                    </div>
                                </a>
                            @endforeach
                        @endisset
                        <!-- <a href="#" class="wrap-item__product wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                                                                                                                                                <div class="">
                                                                                                                                                    <img class="wrap-item__product-img" src="https://bizweb.dktcdn.net/thumb/large/100/451/884/products/chanvaydangacaplientabongthant.jpg?v=1649173050000" alt="">
                                                                                                                                                </div>
                                                                                                                                                <div class="wrap-item__product-content">
                                                                                                                                                    <h2 class="wrap-item__product-title">Áo nữ mùa hè mát mẻ</h2>
                                                                                                                                                    <p class="wrap-item__product-price card__price ">
                                                                                                                                                        <span class="card__price-sale">195.000<u>đ</u></span>
                                                                                                                                                        <span class="card__price-regular text-deco-line-th">250.000<u>đ</u></span>
                                                                                                                                                    </p>
                                                                                                                                                </div>
                                                                                                                                            </a> -->


                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
