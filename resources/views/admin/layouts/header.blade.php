<div class="bg-info">
    <div class="container bg-info">
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dashboard">
                    <img src="{{ asset('images/logo/logo.png') }}" alt="logo" style="width: 50px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" aria-current="page" href="/admin">TRANG CHỦ</a>
                    </li>
                    <li class="nav-item js-nav-item">
                        <div class="btn-group">
                            <button type="button" class="border border-0 nav-link fw-bold dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                SẢN PHẨM
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/product-categories">DANH MỤC SP</a></li>
                                <li><a class="dropdown-item" href="/admin/products">SẢN PHẨM</a></li>
                                <li><a class="dropdown-item" href="/admin/product-attribute-categories">D.MỤC TT
                                        SP</a></li>
                                <li><a class="dropdown-item" href="/admin/product-attributes">THUỘC TÍNH SP</a></li>
                                <li><a class="dropdown-item" href="/admin/product-images">HÌNH ẢNH SP</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item js-nav-item">
                        <div class="btn-group">
                            <button type="button" class="nav-link border border-0 fw-bold dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                ĐƠN HÀNG
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/oders">DS ĐƠN HÀNG</a></li>
                                <li><a class="dropdown-item" href="/admin/oder-details">KT ĐƠN HÀNG</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item js-nav-item">
                        <div class="btn-group">
                            <button type="button" class="nav-link border border-0 fw-bold dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                TÀI KHOẢN
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/accounts">Danh sách tài khoản</a></li>
                                {{-- <li><a class="dropdown-item" href="#">Another action</a></li> --}}
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/profile">Tài khoản cá nhân</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item js-nav-item">
                        <div class="btn-group">
                            <button type="button" class="nav-link border border-0 fw-bold dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                VOUCHERS
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/vouchers">Danh sách Voucher</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item js-nav-item">
                        <div class="btn-group">
                            <button type="button" class="nav-link border border-0 fw-bold dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                CÀI ĐẶT WEB
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/banners">Banner</a></li>
                                {{-- <li><a class="dropdown-item" href="/admin/products">...</a></li> --}}
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="/">TRANG KHÁCH</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
