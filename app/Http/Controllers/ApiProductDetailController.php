<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductDetail as ProductDetailResource;
use App\Models\ProductAttributeProductDetail;
use Illuminate\Http\Request;

class ApiProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
    }
    public function detail($productId, $a, $b)
    {
        // cần trả về cho api thông tin giá, trạng thái, số lượng
        // có mảng đầu vào rồi
        // cần 1 mảng các option của sp, mỗi phần tử là 1 mảng chứa các thuộc tính
        // xử lý có thuộc tính thôi

        $optionUseRequest = [];
        if ($a == 0 && $b != 0) {
            $optionUseRequest[] = $b;
        }
        if ($b == 0 && $a != 0) {
            $optionUseRequest[] = $a;
        }
        if ($a != 0 && $b != 0) {
            $optionUseRequest[] = $a;
            $optionUseRequest[] = $b;
        }
        // lấy được mảng option người dùng gửi lên
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
                // echo $proDetailId;
                // trả về được id option rồi
                $option = ProductDetail::where('id', '=', $proDetailId)->first();
                $arr = [
                    'status' => true,
                    'message' => "Thông tin options",
                    'data' => $option
                ];
                
                return response()->json($arr, 200);
            }
        }


        // $products = Product::all();
        // $products = [$a, $b];
        // $arr = [
        //     'status' => true,
        //     'message' => "Danh sách sản phẩm",
        //     'data' => ProductResource::collection($products)
        // ];
        // $products = [$a, $b];
        // $arr = [
        //     'status' => true,
        //     'message' => "Danh sách sản phẩm",
        //     'data' => $products
        // ];
        // return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
