<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.voucher.index', ["vouchers" => $vouchers, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:60'],
            'code' => ['required', 'string', 'min:6', 'max:15'],
            'description' => ['nullable', 'string', 'max:128'],
            'percent_value' => ['nullable', 'integer', 'min:0', 'max:100'],
            'money_value' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'order_value_total' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'quantity' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'start_time' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'end_time' => ['nullable', 'date_format:Y-m-d\TH:i']
        ]);
        // dd(\Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time)->format('Y-m-d H:i:s'));
        $checkCode = Voucher::where('code', $request->code)->exists();
        if ($checkCode) {
            // session()->flash('error', 'Tên đã có, thay tên khác đi bạn êii!');
            return redirect('/admin/vouchers/create')->with('error', 'Mã đã có, thay mã khác đi bạn êii!');
        }
        $checkName = Voucher::where('name', $request->name)->exists();
        if ($checkName) {
            return redirect('/admin/vouchers/create')->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
        }
        !isset($request->description) ? $description = "" : $description = $request->description;
        !isset($request->percent_value) ? $percent_value = 0 :  $percent_value = $request->percent_value;
        !isset($request->money_value) ? $money_value = 0 :  $money_value = $request->money_value;
        !isset($request->order_value_total) ? $order_value_total = 0 : $order_value_total = $request->order_value_total;
        !isset($request->quantity) ? $quantity = -1000 : $quantity = $request->quantity;
        !isset($request->start_time) ? $start_time = now() : $start_time = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time)->format('Y-m-d H:i:s');
        !isset($request->end_time) ? $end_time = "2100-10-10" : $end_time = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time)->format('Y-m-d H:i:s');
        if ($money_value == 0 && $percent_value == 0) {
            return redirect('/admin/vouchers/create')->with('error', 'Chỉ một trong 2 giá trị giảm phần trăm hoặc giá trị giảm tiền được bằng 0, hãy thay đổi giá trị');
        }
        // dd($start_time, $end_time);
        $voucher = Voucher::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $description,
            'percent_value' => $percent_value,
            'money_value' => $money_value,
            'order_value_total' => $order_value_total,
            'quantity' => $quantity,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);
        session()->flash('success', 'Đã thêm mới voucher: ' . $request->name);

        return redirect('/admin/vouchers');
    }

    public function edit($id)
    {
        // xử lý check danh mục có có hay ko
        $voucher = Voucher::where('id', $id)->doesntExist();
        if ($voucher) {
            session()->flash('error', 'Không tồn tại voucher này!');

            return redirect('/admin/vouchers');
        }
        // xử lý orders đã được sử dụng hay chưa
        $voucher = Voucher::find($id);
        $voucher->start_time = \Carbon\Carbon::parse($voucher->start_time)->format('Y-m-d\TH:i');
        $voucher->end_time = \Carbon\Carbon::parse($voucher->end_time)->format('Y-m-d\TH:i');
        $checkVoucher = false;
        $checkProduct = Order::where('voucher_id', $id)->exists();
        if ($checkProduct) {
            $checkVoucher = true;
        }

        return view("admin.voucher.edit", ["voucher" => $voucher, "checkVoucher" => $checkVoucher]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:60'],
            'code' => ['required', 'string', 'min:6', 'max:15'],
            'description' => ['nullable', 'string', 'max:128'],
            'percent_value' => ['nullable', 'integer', 'min:0', 'max:100'],
            'money_value' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'order_value_total' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'quantity' => ['nullable', 'integer', 'max:99999999'],
            'start_time' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'end_time' => ['nullable', 'date_format:Y-m-d\TH:i']
        ]);
        $voucher = Voucher::find($id);
        $checkCode = Voucher::where('code', $request->code)->exists();
        if ($checkCode) {
            if ($request->code != $voucher->code) {

                return redirect('/admin/vouchers/edit/' . $id)->with('error', "Mã code $request->code đã có, thay mã khác đi bạn êii!");
            }
        }
        $checkName = Voucher::where('name', $request->name)->exists();
        if ($checkName) {
            if ($request->name != $voucher->name) {

                return redirect('/admin/vouchers/edit/' . $id)->with('error', "Tên $request->name đã có, thay tên khác đi bạn êii!");
            }
        }
        !isset($request->description) ? $description = "" : $description = $request->description;
        !isset($request->percent_value) ? $percent_value = 0 :  $percent_value = $request->percent_value;
        !isset($request->money_value) ? $money_value = 0 :  $money_value = $request->money_value;
        !isset($request->order_value_total) ? $order_value_total = 0 : $order_value_total = $request->order_value_total;
        !isset($request->quantity) ? $quantity = -1000 : $quantity = $request->quantity;
        !isset($request->start_time) ? $start_time = now() : $start_time = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time)->format('Y-m-d H:i:s');
        !isset($request->end_time) ? $end_time = "2100-10-10" : $end_time = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time)->format('Y-m-d H:i:s');
        if ($money_value == 0 && $percent_value == 0) {
            return redirect("/admin/vouchers/edit/$id")->with('error', 'Chỉ một trong 2 giá trị giảm phần trăm hoặc giá trị giảm tiền được bằng 0, hãy thay đổi giá trị');
        }
        $voucher->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $description,
            'percent_value' => $percent_value,
            'money_value' => $money_value,
            'order_value_total' => $order_value_total,
            'quantity' => $quantity,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);
        session()->flash('success', 'Đã cập nhật voucher: ' . $request->name);

        return redirect('/admin/vouchers');
    }

    public function destroy($id)
    {
        $voucher = Voucher::where('id', $id);
        if ($voucher->doesntExist()) {
            session()->flash('error', 'Không tồn tại voucher này!');

            return redirect('/admin/vouchers');
        }
        // xử lý orders đã được sử dụng hay chưa
        $checkProduct = Order::where('voucher_id', $id)->exists();
        if ($checkProduct) {
            session()->flash('error', 'Voucher này đã có người sử dụng, chỉ được cập nhật, không được xóa!');

            return redirect('/admin/vouchers');
        }
        $voucher->delete();
        session()->flash('success', 'Xóa voucher thành công.');

        return redirect('/admin/vouchers');
    }

    // public function checkVoucher(Request $request)
    // {
    //     // dd('vafo ddaay');
    //     $request->validate([
    //         'code' => ['required', 'string']
    //     ]);
    //     // check tồn tại voucher hay không
    //     $checkCode = Voucher::where('code', $request->code)->doesntExist();
    //     if ($checkCode) {
    //         return redirect('/carts/view')->with('error', 'Mã Voucher tồn tại, vui lòng nhập mã khác hoặc bỏ qua voucher!');
    //     }
    //     $voucherCode = Voucher::where('code', $request->code)->first();
    //     // check số lượng voucher
    //     if ($voucherCode->quantity <= 0 && $voucherCode->quantity != -1000) {
    //         return redirect('/carts/view')->with('error', 'Voucher đã hết lượt sử dụng, vui lòng nhập mã khác hoặc bỏ qua voucher!');
    //     }
    //     // check ngày áp dụng voucher
    //     if ($voucherCode->start_time > now()) {
    //         return redirect('/carts/view')->with('error', "Voucher đến $voucherCode->start_time mới sử dụng được, vui lòng nhập mã khác hoặc bỏ qua voucher!");
    //     }
    //     if ($voucherCode->end_time < now()) {
    //         return redirect('/carts/view')->with('error', "Voucher đã hết hạn, vui lòng nhập mã khác hoặc bỏ qua voucher!");
    //     }
    //     // check đơn hàng có đủ điều kiện áp dụng voucher hay không, cụ thể ở đây là có thỏa mãn giá trị đơn hàng tối thiểu hay không
    //     $user = $request->user();
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
    //     if ($allPrice < $voucherCode->order_value_total) {
    //         return redirect('/carts/view')->with('error', 'Giá trị đơn hàng chưa đạt giá trị tối thiểu, vui lòng nhập mã khác hoặc bỏ qua voucher!');
    //     }

    //     return redirect('/carts/view')->with('voucherCode', $voucherCode);
    // }

    public function checkVoucher(Request $request)
    {
        // dd('vafo ddaay');
        $request->validate([
            'code' => ['required', 'string']
        ]);

        return redirect('/carts/view')->with('voucherCode', $request->code);
    }
}
