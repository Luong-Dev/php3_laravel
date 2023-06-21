<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailPayment;
use App\Models\ProductAttributeProductDetail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // cần check lại cart 1 lần nữa thỏa mãn số lượng còn hàng,.. hay không, thoải mãn mới đi xét validate các thứ, nếu check validate các thứ trước thì thằng này ko thỏa mãn vẫn phải reload lại hết, buộc người dùng phải thay đổi số lượng, sp phù hợp
        // ở đây nếu gặp lỗi thì ko return kèm mã code trước đó, vì giỏ hàng sẽ buộc phải thay đổi thì mã giảm giá có thể ko còn đk áp dụng được nữa
        $user = $request->user();
        $carts = Cart::join('product_details', 'product_details.id', '=', 'carts.product_detail_id')
            ->join('products', 'product_details.product_id', '=', 'products.id')
            ->where('user_id', $user->id)
            ->select(
                'carts.quantity as cart_quantity', //số lượng sp trong giỏ hàng
                'product_details.id as product_detail_id',
                'product_details.regular_price',
                'product_details.sale_price',
                'product_details.status',
                'product_details.quantity as product_detail_quantity', //số lượng sp của cửa hàng
                'products.id as product_id',
                'products.name',
            )
            ->get();
        // check xem có sản phẩm nào có số lượng mua lớn hơn số lượng mà shop đang có hay không, hoặc ko ở trong trạng thái còn hàng không
        if (sizeOf($carts) > 0) {
            foreach ($carts as $cart) {
                if ($cart->cart_quantity > $cart->product_detail_quantity) {
                    return redirect('/carts/view')->with('error', "Sản phẩm $cart->name bạn muốn mua vượt quá số lượng shop đang có, vui lòng thay đổi số lượng!");
                }
                if ($cart->status != 1) {
                    return redirect('/carts/view')->with('error', "Sản phẩm $cart->name hiện không có sẵn để bán, hãy xóa và cập nhật lại giỏ!");
                }
            }
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
        } else {
            // check card tránh trường hợp f5
            return redirect('/carts/view')->with('error', "Giỏ hàng hiện đang trống!");
        }
        // thỏa mãn đủ đk hàng hóa thì mới vào đây
        $validator = Validator::make($request->all(), [
            // 'voucher_code' => ['nullable', 'string', 'min:6'],
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'note' => ['nullable', 'string', 'max:250'],
            'phone_number' => ['required', 'numeric', 'digits_between:10,14'],
            'address' => ['required', 'string', 'min:10', 'max:200'],
        ], [
            // 'image_url.*.required' => 'Vui lòng chọn ảnh banner.',
            'name.required' => 'Vui lòng nhập tên của bạn',
            'name.min' => 'Tên của bạn quá ngắn',
            'name.max' => 'Tên của bạn quá dài',
            'phone_number.required' => 'Vui lòng nhập số điện thoại của bạn',
            'phone_number.numeric' => 'Vui lòng nhập dạng số',
            'phone_number.digits_between' => 'Số điện thoại quá ngắn hoặc quá dài',
            'address.required' => 'Vui lòng nhập địa chỉ của bạn',
            'address.min' => 'Địa chỉ bạn nhập quá ngắn, không đủ chi tiết',
            'address.max' => 'Địa chỉ bạn nhập quá dài',
            'note.max' => 'Ghi chú bạn nhập quá dài',
        ]);
        if ($validator->fails()) {
            return redirect('/carts/view')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Cập nhật lại thông tin giao hàng nhé bạn iu!')
                ->with('voucherCode', $request->voucher_code);
        }

        // xử lý lên đơn hàng
        // tính tiền tính tổng tiền
        $allPrice = 0;
        foreach ($carts as $cart) {
            if (isset($cart->sale_price)) {
                $allPrice += $cart->sale_price * $cart->cart_quantity;
            } else {
                $allPrice += $cart->regular_price * $cart->cart_quantity;
            }
        }
        $paymentPrice = $allPrice;
        $saleEd = 0;
        $voucherId = 0;
        if (isset($request->voucher_code) && !empty($request->voucher_code)) {
            // dd($request->voucher_code);
            $voucherCode = Voucher::where('code', $request->voucher_code)->first();
            // dd($voucherCode);
            if ($voucherCode->money_value == 0 && $voucherCode->percent_value != 0) {
                $saleEd = round($allPrice * $voucherCode->percent_value / 100);
                $paymentPrice = round($allPrice - $saleEd);
            }
            if ($voucherCode->percent_value == 0 && $voucherCode->money_value != 0) {
                $saleEd = round($voucherCode->money_value);
                $paymentPrice = round($allPrice - $saleEd);
            }
            if ($voucherCode->money_value != 0 && $voucherCode->percent_value != 0) {
                $saleEd = round($allPrice * $voucherCode->percent_value / 100);
                if ($saleEd > $voucherCode->money_value) {
                    $saleEd = $voucherCode->money_value;
                }
                $paymentPrice = round($allPrice - $saleEd);
            }
            $voucherId = $voucherCode->id;
        }
        // function codeLuuXoaFunction()
        // {
        //     dd(
        //         $request->user()->id,
        //         $voucherId,
        //         $request->name,
        //         $request->phone_number,
        //         $request->address,
        //         $request->note,
        //         $allPrice,
        //         $paymentPrice,
        //     );
        //     // test thêm oder
        //     // thêm order
        //     $order = Order::create([
        //         'user_id' => $request->user()->id,
        //         'voucher_id' => $voucherId,
        //         'name' => $request->name,
        //         'phone_number' => $request->phone_number,
        //         'address' => $request->address,
        //         'note' => $request->note,
        //         'price_total' => $allPrice,
        //         'price_payment' => $paymentPrice,
        //     ]);
        //     // dd($order->id);
        //     foreach ($carts as $cart) {
        //         // dd($orderId);
        //         $price = $cart->regular_price;
        //         if (isset($cart->sale_price)) {
        //             $price = $cart->sale_price;
        //         }
        //         // thêm order-details
        //         $orderDetail = OrderDetail::create([
        //             'product_detail_id' => $cart->product_detail_id,
        //             'order_id' => $order->id,
        //             'quantity' => $cart->cart_quantity,
        //             'price' => $price,
        //             'price_total' => $cart->cart_quantity * $price
        //         ]);
        //         // trừ đi số sản phẩm còn trong shop
        //         $productDetail = ProductDetail::find($cart->product_detail_id);
        //         $newQuantity = $productDetail->quantity - $cart->cart_quantity;
        //         $productDetail->quantity = $newQuantity;
        //         $productDetail->save();
        //     }
        //     // nếu có voucher thì trừ đi voucher
        //     if ($voucherId != 0) {
        //         $voucher = Voucher::find($voucherId);
        //         $newQuantity = $voucher->quantity - 1;
        //         $newQuantityUsed = $voucher->quantity_used + 1;
        //         $voucher->quantity = $newQuantity;
        //         $voucher->quantity_used = $newQuantityUsed;
        //         $voucher->save();
        //     }
        //     // xóa giỏ hàng
        //     Cart::where('user_id', $request->user()->id)->delete();
        // }
        DB::transaction(function () use ($request, $voucherId, $allPrice, $paymentPrice, $carts) {
            // thêm order
            $order = Order::create([
                'user_id' => $request->user()->id,
                'voucher_id' => $voucherId,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'note' => $request->note,
                'price_total' => $allPrice,
                'price_payment' => $paymentPrice,
            ]);
            // dd($order->id);
            foreach ($carts as $cart) {
                // dd($orderId);
                $price = $cart->regular_price;
                if (isset($cart->sale_price)) {
                    $price = $cart->sale_price;
                }
                // thêm order-details
                $orderDetail = OrderDetail::create([
                    'product_detail_id' => $cart->product_detail_id,
                    'order_id' => $order->id,
                    'quantity' => $cart->cart_quantity,
                    'price' => $price,
                    'price_total' => $cart->cart_quantity * $price
                ]);
                // trừ đi số sản phẩm còn trong shop
                $productDetail = ProductDetail::find($cart->product_detail_id);
                $newQuantity = $productDetail->quantity - $cart->cart_quantity;
                $productDetail->quantity = $newQuantity;
                $productDetail->save();
            }
            // nếu có voucher thì trừ đi voucher
            if ($voucherId != 0) {
                $voucher = Voucher::find($voucherId);
                $newQuantity = $voucher->quantity - 1;
                $newQuantityUsed = $voucher->quantity_used + 1;
                $voucher->quantity = $newQuantity;
                $voucher->quantity_used = $newQuantityUsed;
                $voucher->save();
            }
            // xóa giỏ hàng
            Cart::where('user_id', $request->user()->id)->delete();
        });
        // dd($user,$carts,$cartAttributes,$voucherId,$allPrice,$paymentPrice,$saleEd);
        Mail::to("$user->email")->send(new SendEmailPayment($user, $carts, $cartAttributes, $voucherId, $allPrice, $paymentPrice, $saleEd));

        return redirect('/carts/view')->with('success', "Cảm ơn bạn đã đặt hàng, đừng có mà bom nhóe!");
    }
}
