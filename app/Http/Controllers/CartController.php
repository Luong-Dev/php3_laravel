<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttributeProductDetail;
use App\Models\ProductDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function userCart(Request $request)
    {
        // phải xét trường hợp sp ko có thuộc tính và sp có thuộc tính, chỗ này nên bắn request 1 biến để biết sp có thuộc tính hay ko

        // check có thuộc tính
        // dd($request->input('attributes'));
        $productId = $request->productId;
        if (!empty($request->input('attributes'))) {
            foreach ($request->input('attributes') as $productAttributeCategoryId) {
                $request->validate([
                    "attributes_$productAttributeCategoryId" => ['required', 'integer'],
                    'quantity' => ['required', 'integer', 'min:1']
                ]);
            }
            $optionUseRequest = [];
            foreach ($request->input('attributes') as $productAttributeCategoryId) {
                if ($productAttributeCategoryId == 6) {
                    $optionUseRequest['6'] = $request->attributes_6;
                }
                if ($productAttributeCategoryId == 8) {
                    $optionUseRequest['8'] = $request->attributes_8;
                }
            }
            $productDetails = ProductDetail::where('product_id', '=', $productId)
                ->get();
            $productOptionDetails = [];
            foreach ($productDetails as $productDetail) {
                $productAttributeProductDetails = ProductAttributeProductDetail::where('product_detail_id', '=', $productDetail->id)->get();
                foreach ($productAttributeProductDetails as $productAttributeProductDetail) {
                    $productOptionDetails["$productDetail->id"][] = $productAttributeProductDetail->product_attribute_id;
                }
            }
            foreach ($productOptionDetails as $proDetailId => $productOptionDetail) {
                if (!array_diff($optionUseRequest, $productOptionDetail)) {
                    echo $proDetailId;
                    // trả về được id option rồi
                    //cần check các điều kiện thỏa mãn: số lượng, trạng thái để cho vào giỏ hàng
                    // khi thanh toán cần check lại số lượng, trạng thái, mới tiếp tục thanh toán, và xóa sp trong giỏ hàng đi

                    // kiểm tra xem giỏ hàng đã có sp này hay chưa
                    $productDetail = ProductDetail::where('id', $proDetailId)->first();
                    if ($productDetail->status != 1) {
                        $status = [
                            '2' => 'Đang về',
                            '3' => 'Tạm hết',
                            '4' => 'Ngưng bán',
                        ];
                        foreach ($status as $key => $value) {
                            if ($productDetail->status == $key) {
                                $status = $value;
                            }
                        }

                        return redirect('/products/details/' . $productId)->with('error', "Loại này hiện $status, mời chọn option khác");
                    }
                    $user = $request->user();
                    $cart = Cart::where('product_detail_id', $proDetailId)
                        ->where('user_id', $user->id);
                    if ($cart->exists()) {
                        // $cart = $cart->first();
                        $quantity = $cart->first()->quantity + $request->quantity;
                        if ($quantity > $productDetail->quantity) {

                            return redirect('/products/details/' . $productId)->with('error', "Sản phẩm hiện đã có trong giỏ hàng của bạn, và tổng số lượng đang nhiều hơn số lượng mà shop đang có!");
                        }
                        $cart->update([
                            'quantity' => $quantity
                        ]);

                        return redirect('/products/details/' . $productId)->with('success', "Đã thêm $request->quantity sản phẩm và có $quantity sản phẩm vào giỏ hàng");
                    } else {
                        if ($request->quantity > $productDetail->quantity) {

                            return redirect('/products/details/' . $productId)->with('error', "Số lượng bạn thêm nhiều hơn số lượng mà shop đang có!");
                        }
                        $cart = Cart::create([
                            'product_detail_id' => $proDetailId,
                            'user_id' => $user->id,
                            'quantity' => $request->quantity
                        ]);

                        return redirect('/products/details/' . $productId)->with('success', "Đã thêm $request->quantity sản phẩm vào giỏ hàng");
                    }
                    // cách 2
                    // $cart = Cart::updateOrInsert(
                    //     ['product_detail_id' => $proDetailId, 'user_id' => $user->id],
                    //     ['quantity' => Cart::raw("quantity + $request->quantity"),
                    //     'created_at' =>now(),
                    //     'updated_at' =>now()
                    //     ]
                    //     // dùng thằng này thì ngắn hơn nhưng không tự động thêm ngày chỉnh sửa, cần chỉnh sửa ngày thêm
                    // );
                    // dd($proDetailId, $user->id);

                    return redirect('/products/details/' . $productId)->with('success', "Đã thêm $request->quantity sản phẩm vào giỏ hàng");
                }
            }
        } else {
            // phải check trường hợp ko có option nào có vào đây hay không
            // dd('không có thuọc tính');
            // dd($request->product_detail_id);
            $proDetailId = $request->product_detail_id;
            $request->validate([
                'quantity' => ['required', 'integer', 'min:1']
            ]);
            $productDetail = ProductDetail::where('id', $proDetailId)->first();
            if ($productDetail->status != 1) {
                $status = [
                    '2' => 'Đang về',
                    '3' => 'Tạm hết',
                    '4' => 'Ngưng bán',
                ];
                foreach ($status as $key => $value) {
                    if ($productDetail->status == $key) {
                        $status = $value;
                    }
                }

                return redirect('/products/details/' . $productId)->with('error', "Sản phẩm này hiện $status, mời chọn sản phẩm khác");
            }
            $user = $request->user();
            $cart = Cart::where('product_detail_id', $proDetailId)
                ->where('user_id', $user->id);
            if ($cart->exists()) {
                // $cart = $cart->first();
                $quantity = $cart->first()->quantity + $request->quantity;
                if ($quantity > $productDetail->quantity) {

                    return redirect('/products/details/' . $productId)->with('error', "Sản phẩm hiện đã có trong giỏ hàng của bạn, và tổng số lượng đang nhiều hơn số lượng mà shop đang có!");
                }
                $cart->update([
                    'quantity' => $quantity
                ]);

                return redirect('/products/details/' . $productId)->with('success', "Đã thêm $request->quantity sản phẩm và có $quantity sản phẩm vào giỏ hàng");
            } else {
                if ($request->quantity > $productDetail->quantity) {

                    return redirect('/products/details/' . $productId)->with('error', "Số lượng bạn thêm nhiều hơn số lượng mà shop đang có!");
                }
                $cart = Cart::create([
                    'product_detail_id' => $proDetailId,
                    'user_id' => $user->id,
                    'quantity' => $request->quantity
                ]);

                return redirect('/products/details/' . $productId)->with('success', "Đã thêm $request->quantity sản phẩm vào giỏ hàng");
            }
        }
    }

    // public function userCartView(Request $request)
    // {
    //     $user = $request->user();
    //     // dd($user);
    //     $carts = Cart::join('product_details', 'product_details.id', '=', 'carts.product_detail_id')
    //         ->join('products', 'product_details.product_id', '=', 'products.id')
    //         ->where('user_id', $user->id)
    //         ->select(
    //             'carts.quantity as cart_quantity',
    //             'product_details.id as product_detail_id',
    //             'product_details.regular_price',
    //             'product_details.sale_price',
    //             'product_details.status',
    //             'product_details.quantity as product_detail_quantity',
    //             'products.id as product_id',
    //             'products.name',
    //         )
    //         ->get();
    //     // dd($carts);
    //     $allPrice = 0;
    //     if (sizeOf($carts) > 0) {
    //         foreach ($carts as $key => $cart) {
    //             if (isset($cart->sale_price)) {
    //                 $allPrice += $cart->sale_price * $cart->cart_quantity;
    //             } else {
    //                 $allPrice += $cart->regular_price * $cart->cart_quantity;
    //             }
    //         }
    //     }
    //     // lấy voucher nếu đã được áp mã
    //     $voucherCode = $request->session()->pull('voucherCode', ''); //hàm lấy đồng thời xóa session key là code
    //     // $voucherCode = $request->session()->get('voucherCode',''); hàm lấy
    //     // $request->session()->forget('voucherCode'); hàm xóa
    //     // lấy giá trị đơn hàng sau khi áp mã
    //     $paymentPrice = $allPrice;
    //     $saleEd = 0;
    //     if (!empty($voucherCode)) {
    //         // có 3 trường hợp, một là 1 trong 2 thằng bằng 0; ba là cả 2 khác 0 là giảm bao nhiêu %, tối đa bao nhiêu tiền
    //         // không nhất thiết phải kèm điều kiện tránh cả 2 bằng 0 vì đã ràng buộc ở khâu thêm mã giảm giá
    //         if ($voucherCode->money_value == 0 && $voucherCode->percent_value != 0) {
    //             $saleEd = round($allPrice * $voucherCode->percent_value / 100);
    //             $paymentPrice = round($allPrice - $saleEd);
    //             // dd($paymentPrice, $saleEd);
    //         }
    //         if ($voucherCode->percent_value == 0 && $voucherCode->money_value != 0) {
    //             $saleEd = round($voucherCode->money_value);
    //             $paymentPrice = round($allPrice - $saleEd);
    //             // dd($paymentPrice, $saleEd);
    //         }
    //         if ($voucherCode->money_value != 0 && $voucherCode->percent_value != 0) {
    //             $saleEd = round($allPrice * $voucherCode->percent_value / 100);
    //             if ($saleEd > $voucherCode->money_value) {
    //                 $saleEd = $voucherCode->money_value;
    //             }
    //             $paymentPrice = round($allPrice - $saleEd);
    //             // dd($paymentPrice, $saleEd);
    //         }
    //     }

    //     return view('user.cart.index', [
    //         'carts' => $carts,
    //         'allPrice' => $allPrice,
    //         'paymentPrice' => $paymentPrice,
    //         'saleEd' => $saleEd,
    //         'voucherCode' => $voucherCode,
    //     ]);
    // }

    public function userCartView(Request $request)
    {
        $user = $request->user();
        $vouchers = Voucher::all();
        $carts = Cart::join('product_details', 'product_details.id', '=', 'carts.product_detail_id')
            ->join('products', 'product_details.product_id', '=', 'products.id')
            ->where('user_id', $user->id)
            ->select(
                'carts.quantity as cart_quantity',
                'product_details.id as product_detail_id',
                'product_details.regular_price',
                'product_details.sale_price',
                'product_details.status',
                'product_details.quantity as product_detail_quantity',
                'products.id as product_id',
                'products.name',
            )
            ->get();
        // dd($carts);
        // nếu không có sản phẩm nào trong giỏ hàng thì return luông
        if (sizeof($carts) <= 0) {
            return view('user.cart.index', ['vouchers' => $vouchers]);
        }
        // xử lý lấy mảng thuộc tính theo từng cart
        $cartAttributes = [];
        foreach ($carts as $cart) {
            $cartAttribute = ProductAttributeProductDetail::join('product_attributes', 'product_attributes.id', '=', 'product_attribute_product_detail.product_attribute_id')
                ->where('product_attribute_product_detail.product_detail_id', $cart->product_detail_id)
                ->select(
                    'product_attribute_product_detail.product_detail_id as product_detail_id',
                    'product_attributes.id',
                    'product_attributes.name'
                )
                ->get();
            if (sizeOf($cartAttribute) > 0) {
                $cartAttributes[] = $cartAttribute;
            } else {
                $cartAttributes[] = '';
            }
        }
        // dd($carts, $cartAttributes);
        // xử lý nếu có sản phẩm
        $allPrice = 0;
        foreach ($carts as $cart) {
            if (isset($cart->sale_price)) {
                $allPrice += $cart->sale_price * $cart->cart_quantity;
            } else {
                $allPrice += $cart->regular_price * $cart->cart_quantity;
            }
        }
        // lấy mã voucher và check
        $code = $request->session()->pull('voucherCode', ''); //hàm lấy đồng thời xóa session key là code
        // $voucherCode = $request->session()->get('voucherCode',''); hàm lấy
        // $request->session()->forget('voucherCode'); hàm xóa

        // cần check có rỗng hay ko, rỗng thì return luôn
        if ($code == '') {
            return view('user.cart.index', [
                'carts' => $carts,
                'allPrice' => $allPrice,
                'vouchers' => $vouchers,
                'cartAttributes' => $cartAttributes
            ]);
        }
        // check tồn tại voucher hay không
        $checkCode = Voucher::where('code', $code)->doesntExist();
        if ($checkCode) {
            return redirect('/carts/view')->with('error', 'Mã Voucher không tồn tại, vui lòng nhập mã khác hoặc bỏ qua voucher!');
        }
        $voucherCode = Voucher::where('code', $code)->first();
        // check số lượng voucher
        if ($voucherCode->quantity <= 0 && $voucherCode->quantity != -1000) {
            return redirect('/carts/view')->with('error', 'Voucher đã hết lượt sử dụng, vui lòng nhập mã khác hoặc bỏ qua voucher!');
        }
        // check ngày áp dụng voucher
        if ($voucherCode->start_time > now()) {
            return redirect('/carts/view')->with('error', "Voucher đến $voucherCode->start_time mới sử dụng được, vui lòng nhập mã khác hoặc bỏ qua voucher!");
        }
        if ($voucherCode->end_time < now()) {
            return redirect('/carts/view')->with('error', "Voucher đã hết hạn, vui lòng nhập mã khác hoặc bỏ qua voucher!");
        }
        // check đơn hàng có đủ điều kiện áp dụng voucher hay không, cụ thể ở đây là có thỏa mãn giá trị đơn hàng tối thiểu hay không
        if ($allPrice < $voucherCode->order_value_total) {
            return redirect('/carts/view')->with('error', 'Giá trị đơn hàng chưa đạt giá trị tối thiểu, vui lòng nhập mã khác hoặc bỏ qua voucher!');
        }
        // mã đã được chấp nhận và bắt đầu tính giá sale
        $paymentPrice = $allPrice;
        $saleEd = 0;
        // có 3 trường hợp, một là 1 trong 2 thằng bằng 0; ba là cả 2 khác 0 là giảm bao nhiêu %, tối đa bao nhiêu tiền
        // không nhất thiết phải kèm điều kiện tránh cả 2 bằng 0 vì đã ràng buộc ở khâu thêm mã giảm giá
        if ($voucherCode->money_value == 0 && $voucherCode->percent_value != 0) {
            $saleEd = round($allPrice * $voucherCode->percent_value / 100);
            $paymentPrice = round($allPrice - $saleEd);
            // dd($paymentPrice, $saleEd);
        }
        if ($voucherCode->percent_value == 0 && $voucherCode->money_value != 0) {
            $saleEd = round($voucherCode->money_value);
            $paymentPrice = round($allPrice - $saleEd);
            // dd($paymentPrice, $saleEd);
        }
        if ($voucherCode->money_value != 0 && $voucherCode->percent_value != 0) {
            $saleEd = round($allPrice * $voucherCode->percent_value / 100);
            if ($saleEd > $voucherCode->money_value) {
                $saleEd = $voucherCode->money_value;
            }
            $paymentPrice = round($allPrice - $saleEd);
            // dd($paymentPrice, $saleEd);
        }

        return view('user.cart.index', [
            'carts' => $carts,
            'allPrice' => $allPrice,
            'paymentPrice' => $paymentPrice,
            'saleEd' => $saleEd,
            'voucherCode' => $voucherCode,
            'vouchers' => $vouchers,
            'cartAttributes' => $cartAttributes
        ]);
    }

    public function destroy($proDetailId)
    {
        $cart = Cart::where('product_detail_id', $proDetailId);
        if ($cart->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này trong giỏ hàng!');

            return redirect('/carts/view');
        }
        $cart->delete();
        session()->flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');

        return redirect('/carts/view');
    }

    public function update($proDetailId, $quantity, Request $request)
    {
        $cart = Cart::where('product_detail_id', $proDetailId);
        if ($cart->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này trong giỏ hàng!');

            return redirect('/carts/view');
        }
        $user = $request->user();
        $cart = Cart::join('product_details', 'product_details.id', '=', 'carts.product_detail_id')
            ->join('products', 'product_details.product_id', '=', 'products.id')
            ->where('user_id', $user->id)
            ->where('product_detail_id', $proDetailId)
            ->select(
                'carts.quantity as cart_quantity',
                'product_details.id as product_detail_id',
                'product_details.regular_price',
                'product_details.sale_price',
                'product_details.status',
                'product_details.quantity as product_detail_quantity',
                'products.id as product_id',
                'products.name',
            )
            ->first();
        // dd($cart->product_detail_quantity)
        if ($quantity > $cart->product_detail_quantity) {
            return redirect("/carts/view")->with('error', 'Số lượng bạn chọn nhiều hơn số lượng shop đang có!');
        }
        $cartUpdate = Cart::where('product_detail_id', $proDetailId)
            ->where('product_detail_id', $proDetailId);
        $cartUpdate->update([
            'quantity' => $quantity
        ]);
        session()->flash('success', 'Đã cập nhật thành công số lượng sản phẩm: ' . $request->name);

        return redirect('/carts/view');
    }



    // public function userCartCheckout(Request $request)
    // {
    //     // dd('sdfsdsdf');
    //     $user = $request->user();
    //     // dd($user);
    //     $carts = Cart::join('product_details', 'product_details.id', '=', 'carts.product_detail_id')
    //         ->join('products', 'product_details.product_id', '=', 'products.id')
    //         ->where('user_id', $user->id)
    //         ->select(
    //             'carts.quantity as cart_quantity', //số lượng sp trong giỏ hàng
    //             'product_details.id as product_detail_id',
    //             'product_details.regular_price',
    //             'product_details.sale_price',
    //             'product_details.status',
    //             'product_details.quantity as product_detail_quantity', //số lượng sp của cửa hàng
    //             'products.id as product_id',
    //             'products.name',
    //         )
    //         ->get();
    //     // dd($carts);
    //     // xử lý tổng tiền và check xem có sản phẩm nào có số lượng mua lớn hơn số lượng mà shop đang có hay không
    //     $allPrice = 0;
    //     if (sizeOf($carts) > 0) {
    //         foreach ($carts as $key => $cart) {
    //             if ($cart->cart_quantity > $cart->product_detail_quantity) {
    //                 return redirect('/carts/view')->with('error', "Sản phẩm $cart->name bạn muốn mua vượt quá số lượng shop đang có, vui lòng thay đổi số lượng!");
    //             }
    //             if ($cart->status != 1) {
    //                 return redirect('/carts/view')->with('error', "Sản phẩm $cart->name hiện không có sẵn để bán, hãy xóa và cập nhật lại giỏ!");
    //             }
    //             if (isset($cart->sale_price)) {
    //                 $allPrice += $cart->sale_price * $cart->cart_quantity;
    //             } else {
    //                 $allPrice += $cart->regular_price * $cart->cart_quantity;
    //             }
    //         }
    //     }
    //     // dd($allPrice);
    //     return view('user.cart.checkout', [
    //         'carts' => $carts,
    //         'allPrice' => $allPrice
    //     ]);
    // }
}
