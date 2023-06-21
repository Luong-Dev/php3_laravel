<h2 class="text-center mt-3 mb-3 text-success fs-1 fw-bold">ĐƠN HÀNG CỦA BẠN</h2>
@isset($carts)
    <table class="table table-bordered table-hover my-4">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Sản phẩm</th>
                <th scope="col">Phân loại</th>
                <th scope="col">Số lượng mua</th>
                <th scope="col">Giá</th>
                <th scope="col">Tổng</th>
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
                        {{ $cart->cart_quantity }}
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
                </tr>
            @endforeach
            <tr>
                <td colspan="10" class="">
                    @if (isset($voucherId) && !empty($voucherId))
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
@endisset
