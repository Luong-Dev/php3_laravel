@extends('user.layouts.master')
@section('title', 'Sản phẩm')
@section('content')
    <main>
        <div class="breadcrumb-css__background">
            <div class="container">
                <nav aria-label="breadcrumb-css breadcrumb ">
                    <ol class=" breadcrumb-css__wrap breadcrumb">
                        <li class="breadcrumb-css__item breadcrumb-item"><a href="index.php?act="
                                class="breadcrumb-css__item-link">Trang
                                chủ</a></li>
                        <!-- <li class="breadcrumb-css__item breadcrumb-item"><a href="#">Tất cả sản phẩm</a></li> -->
                        <li class="breadcrumb-css__item breadcrumb-css__item--active breadcrumb-item active"
                            aria-current="page">Tất cả sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="product wrap__main mt-5 mb-5">
                <section class="product wrap__main-left">
                    <div class="product-home">
                        <div class="product-main__wrap-top">
                            <p class="product-main__title">TẤT CẢ SẢN PHẨM</p>
                            <div class="product-main__dropdown dropdown">
                                <button class="product-main__dropdown-btn btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sắp xếp sản phẩm
                                </button>
                                <ul class="product-main__dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="product-main__dropdown-item dropdown-item" href="#">A -> Z</a></li>
                                    <li><a class="product-main__dropdown-item dropdown-item" href="#">Z -> A</a></li>
                                    <li><a class="product-main__dropdown-item dropdown-item" href="#">Giá tăng dần</a>
                                    </li>
                                    <li><a class="product-main__dropdown-item dropdown-item" href="#">Giá giảm dần</a>
                                    </li>
                                    <li><a class="product-main__dropdown-item dropdown-item" href="#">Hàng mới
                                            nhất</a></li>
                                    <li><a class="product-main__dropdown-item dropdown-item" href="#">Hàng cũ nhất</a>
                                    </li>

                                </ul>
                            </div>
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
                        <div class="grid-col-4 mt-5">
                            @isset($products)
                                @foreach ($products as $key => $product)
                                    <div class="card border-0 shadow rounded" style="width: 100%; ">
                                        <a href="/products/details/{{ isset($product->id) ? $product->id : '' }}"
                                            class="text-deco-none card__wrap-image">
                                            <img src="{{ asset($product->image_url) }}" class="card-img-top"
                                                alt="{{ isset($product->image_alt) ? $product->image_alt : '' }}">
                                            <i class="card__price-sale-image">- 20%</i>
                                        </a>
                                        <div class="card-body">
                                            <h3 class="card-title"><a
                                                    href="/products/details/{{ isset($product->id) ? $product->id : '' }}"
                                                    class="card__name text-deco-none">{{ isset($product->name) ? $product->name : '' }}</a>
                                            </h3>
                                            <p class="card__price mt-3">
                                                {{-- <span class="card__price-sale">195.000<u>đ</u>{{ number_format($product->regular_price, 2, ',', '.') }}</span>
                                                <span class="card__price-regular text-deco-line-th">250.000<u>đ</u></span> --}}

                                                @isset($product->min_sale_price)
                                                    <span
                                                        class="card__price-sale">{{ number_format($product->min_sale_price, 0, ',', '.') }}<u>đ</u></span>
                                                @else
                                                    <span
                                                        class="card__price-sale">{{ number_format($product->min_regular_price, 0, ',', '.') }}<u>đ</u></span>
                                                @endisset
                                            </p>
                                            <p class="views mt-2 mb-2 fs-5">Lượt xem: {{ $product->views }}</p>
                                            <div class="card__sold text-center">
                                                <span class="card__sold-sale-bar">
                                                    <span
                                                        class="card__sold-sale-bar-text">#{{ isset($numberPage) ? ($numberPage - 1) * 8 + $key + 1 : $key + 1 }}</span>
                                                </span>
                                                <span class="card__sold-text">Đã bán 236</span>
                                                <span class="card__sold-countdown" style="width: 40%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mt-5">
                                    {{ $products->links() }}
                                </div>
                            @endisset
                        </div>
                    </div>
                </section>
                <aside class="product wrap__main-right">
                    <div class="wrap-item list-group">
                        <span class="wrap-item__item-title list-group-item" aria-current="true">
                            Danh mục
                        </span>
                        <a href="#"
                            class="wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            Quần
                            <span class=" wrap-item__item-count badge  rounded-pill">14</span>
                        </a>
                        <a href="#"
                            class="wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            Mũ
                            <span class="wrap-item__item-count badge rounded-pill">14</span>
                        </a>
                        <a href="#"
                            class="wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            Áo
                            <span class="wrap-item__item-count badge rounded-pill">1</span>
                        </a>
                    </div>

                    <div class="filter-pro__wrap mt-5 rounded">
                        <div class="filter-pro__wrap-item">
                            <h3 class="filter-pro__title">CHỌN MỨC GIÁ</h3>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500">
                                <label class="filter-pro__label form-check-label" for="flexCheck500">
                                    Dưới 500k
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500-1000">
                                <label class="filter-pro__label form-check-label" for="flexCheck500-1000">
                                    Từ 500k - 1 triệu
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck1000-2000">
                                <label class="filter-pro__label form-check-label" for="flexCheck1000-2000">
                                    Từ 1 triệu - 2 triệu
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck2000-5000">
                                <label class="filter-pro__label form-check-label" for="flexCheck2000-5000">
                                    Từ 2 triệu - 5 triệu
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck5000Min">
                                <label class="filter-pro__label form-check-label" for="flexCheck5000Min">
                                    Trên 5 triệu
                                </label>
                            </div>
                        </div>
                        <div class="filter-pro__wrap-item">
                            <h3 class="filter-pro__title">LOẠI SẢN PHẨM</h3>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500">
                                <label class="filter-pro__label form-check-label" for="flexCheck500">
                                    Áo cotton
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500-1000">
                                <label class="filter-pro__label form-check-label" for="flexCheck500-1000">
                                    Áo phông
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck1000-2000">
                                <label class="filter-pro__label form-check-label" for="flexCheck1000-2000">
                                    Áo polo
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck2000-5000">
                                <label class="filter-pro__label form-check-label" for="flexCheck2000-5000">
                                    Áo tắm
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck5000Min">
                                <label class="filter-pro__label form-check-label" for="flexCheck5000Min">
                                    Váy body
                                </label>
                            </div>
                        </div>
                        <div class="filter-pro__wrap-item">
                            <h3 class="filter-pro__title">Thương hiệu</h3>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500">
                                <label class="filter-pro__label form-check-label" for="flexCheck500">
                                    LuongShop
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500-1000">
                                <label class="filter-pro__label form-check-label" for="flexCheck500-1000">
                                    Gucci
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck1000-2000">
                                <label class="filter-pro__label form-check-label" for="flexCheck1000-2000">
                                    Adidas
                                </label>
                            </div>
                        </div>

                        <div class="filter-pro__wrap-item">
                            <h3 class="filter-pro__title">Màu phổ biến</h3>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500">
                                <label class="filter-pro__label form-check-label" for="flexCheck500">
                                    Trắng
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500-1000">
                                <label class="filter-pro__label form-check-label" for="flexCheck500-1000">
                                    Đen
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck1000-2000">
                                <label class="filter-pro__label form-check-label" for="flexCheck1000-2000">
                                    Hồng
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck2000-5000">
                                <label class="filter-pro__label form-check-label" for="flexCheck2000-5000">
                                    Xanh
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck5000Min">
                                <label class="filter-pro__label form-check-label" for="flexCheck5000Min">
                                    Cam
                                </label>
                            </div>
                        </div>

                        <div class="filter-pro__wrap-item">
                            <h3 class="filter-pro__title">Kiểu vải</h3>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500">
                                <label class="filter-pro__label form-check-label" for="flexCheck500">
                                    Vải cotton
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck500-1000">
                                <label class="filter-pro__label form-check-label" for="flexCheck500-1000">
                                    Vải kaki
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck1000-2000">
                                <label class="filter-pro__label form-check-label" for="flexCheck1000-2000">
                                    Vải jeans
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck2000-5000">
                                <label class="filter-pro__label form-check-label" for="flexCheck2000-5000">
                                    Vải len
                                </label>
                            </div>
                            <div class="filter-pro__item form-check">
                                <input class="filter-pro__check form-check-input" type="checkbox" value=""
                                    id="flexCheck5000Min">
                                <label class="filter-pro__label form-check-label" for="flexCheck5000Min">
                                    Vải kate
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="wrap-item list-group mt-5">
                        <span class="wrap-item__item-title list-group-item" aria-current="true">
                            Sản Phẩm Mới
                        </span>
                        <a href="#"
                            class="wrap-item__product wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            <div class="">
                                <img class="wrap-item__product-img"
                                    src="https://bizweb.dktcdn.net/thumb/large/100/451/884/products/chanvaydangacaplientabongthant.jpg?v=1649173050000"
                                    alt="">
                            </div>
                            <div class="wrap-item__product-content">
                                <h2 class="wrap-item__product-title">Áo nữ mùa hè mát mẻ</h2>
                                <p class="wrap-item__product-price card__price ">
                                    <span class="card__price-sale">195.000<u>đ</u></span>
                                    <span class="card__price-regular text-deco-line-th">250.000<u>đ</u></span>
                                </p>
                            </div>
                        </a>
                        <a href="#"
                            class="wrap-item__product wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            <div class="">
                                <img class="wrap-item__product-img"
                                    src="https://bizweb.dktcdn.net/thumb/large/100/451/884/products/chanvaydangacaplientabongthant.jpg?v=1649173050000"
                                    alt="">
                            </div>
                            <div class="wrap-item__product-content">
                                <h2 class="wrap-item__product-title">Áo nữ mùa hè mát mẻ</h2>
                                <p class="wrap-item__product-price card__price ">
                                    <span class="card__price-sale">195.000<u>đ</u></span>
                                    <span class="card__price-regular text-deco-line-th">250.000<u>đ</u></span>
                                </p>
                            </div>
                        </a>
                        <a href="#"
                            class="wrap-item__product wrap-item__item-link list-group-item d-flex justify-content-between align-items-start">
                            <div class="">
                                <img class="wrap-item__product-img"
                                    src="https://bizweb.dktcdn.net/thumb/large/100/451/884/products/chanvaydangacaplientabongthant.jpg?v=1649173050000"
                                    alt="">
                            </div>
                            <div class="wrap-item__product-content">
                                <h2 class="wrap-item__product-title">Áo nữ mùa hè mát mẻ</h2>
                                <p class="wrap-item__product-price card__price ">
                                    <span class="card__price-sale">195.000<u>đ</u></span>
                                    <span class="card__price-regular text-deco-line-th">250.000<u>đ</u></span>
                                </p>
                            </div>
                        </a>

                    </div>
                </aside>

            </div>

        </div>

    </main>

@endsection
