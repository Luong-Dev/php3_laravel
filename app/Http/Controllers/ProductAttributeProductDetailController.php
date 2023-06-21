<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeProductDetail;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use PDO;

class ProductAttributeProductDetailController extends Controller
{
    public function index($productId, Request $request)
    {
        // dd('vaof dday hehe');
        $product = Product::find($productId);
        $productDetails = ProductDetail::where('product_id', $productId)->get();
        // $productDetails =   Product::leftJoin('product_details', 'product_details.product_id', '=', 'products.id')
        //     ->where('products.id', '=', $productId)
        //     ->get();
        $mixOptions = [];
        if (!empty($productDetails)) {
            foreach ($productDetails as $productDetail) {
                $mixOptions["$productDetail->id"] = ProductAttributeProductDetail::leftJoin('product_attributes', 'product_attribute_product_detail.product_attribute_id', '=', 'product_attributes.id')
                    ->leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
                    ->where('product_detail_id', $productDetail->id)
                    ->select(
                        'product_attribute_product_detail.product_attribute_id as product_attribute_id',
                        'product_attributes.name as product_attribute_name',
                        'product_attribute_categories.name as product_attribute_category_name',
                    )
                    ->get();
            }
        }
        // dd($productDetails, $mixOptions);

        $productAttributeProductDetails = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftJoin('product_details', 'product_details.product_id', '=', 'products.id')
            ->leftJoin('product_attribute_product_detail', 'product_details.id', '=', 'product_attribute_product_detail.product_detail_id')
            ->leftJoin('product_attributes', 'product_attribute_product_detail.product_attribute_id', '=', 'product_attributes.id')
            ->leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.short_description',
                'products.long_description',
                'product_categories.id as product_category_id',
                'product_categories.name as product_category_name',
                'product_details.id',
                'product_details.regular_price',
                'product_details.sale_price',
                'product_details.quantity',
                'product_details.status',
                'product_attribute_product_detail.product_attribute_id',
                'product_attributes.name as product_attribute_name',
                'product_attributes.description_value',
                'product_attribute_categories.name as product_attribute_category_name',
            )
            ->where('products.id', '=', $productId)
            ->get();
        // dd($productAttributeProductDetails);
        $arrStatus = [
            "1" => "Còn hàng",
            "2" => "Hàng đang về",
            "3" => "Tạm hết",
            "4" => "Ngưng bán"
        ];
        return view('admin.productAttributeProductDetail.index', ['productDetails' => $productDetails, 'mixOptions' => $mixOptions, 'productAttributeProductDetails' => $productAttributeProductDetails, 'arrStatus' => $arrStatus, 'product' => $product]);

        // dd($product);

        // return view('admin.productDetail.createHaveAttribute');
        // return view('admin.productAttributeProductDetail.create', ['mixOptions' => $mixOptions, 'product' => $product, 'productId' => $productId, 'productAttributes' => $productAttributes]);
    }    
}
