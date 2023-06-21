<?php


namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCategory;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Http\Request;


class HomePageController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('level', 'asc')->get();
        $topProductNews = Product::orderBy('id', 'ASC')->limit(10)->get();
        $productImagesClient = Product::join('product_images', 'products.id', "=", 'product_images.product_id')
            ->groupBy('product_images.id')
            ->get();
        $topProductLoves = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
            ->join('product_images', 'products.id', "=", 'product_images.product_id')
            ->groupBy('products.id')
            ->select(
                'products.name',
                "products.id",
                "product_images.image_url",
                ProductDetail::raw('max(product_details.regular_price) as max_regular_price'),
                ProductDetail::raw('min(product_details.regular_price) as min_regular_price'),
                ProductDetail::raw('max(product_details.sale_price) as max_sale_price'),
                ProductDetail::raw('min(product_details.sale_price) as min_sale_price'),
            )
            ->limit(4)
            ->get();
        // $topProductLoves = Product::join('product_images', 'product_images.product_id' , "=" , "products.id")->groupBy("products.id")->orderBy('products.id', 'ASC')->limit(4)->get();
        $productCategories = ProductCategory::leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'product_categories.id',
                'product_categories.name',
                'products.product_category_id',
                ProductCategory::raw('count(products.product_category_id) as product_quantity')
            )
            ->groupBy('product_categories.id')
            ->get();
        // dd($topProductNews);
        return view('user.home.index', ['banners' => $banners, 'topProductNews' => $topProductNews, 'productCategories' => $productCategories, 'topProductLoves' => $topProductLoves]);
    }

    // public function userIndex()
    // {
    //     $productImagesClient = Product::join('product_images', 'products.id', "=", 'product_images.product_id')
    //         ->groupBy('product_images.id')
    //         ->get();
    //     $productDetails = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
    //         ->groupBy('products.id')
    //         ->select(
    //             'products.name',
    //             "products.id",
    //             ProductDetail::raw('max(product_details.regular_price) as max_regular_price'),
    //             ProductDetail::raw('min(product_details.regular_price) as min_regular_price'),
    //             ProductDetail::raw('max(product_details.sale_price) as max_sale_price'),
    //             ProductDetail::raw('min(product_details.sale_price) as min_sale_price'),
    //         )->get();
    //     $topProductLoves = Product::join('product_images', 'product_images.product_id', "=", "products.id")->groupBy("products.id")->orderBy('products.id', 'ASC')->limit(4)->get();
    //     $productCategories = ProductCategory::leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
    //         ->select(
    //             'product_categories.id',
    //             'product_categories.name',
    //             'products.product_category_id',
    //             ProductCategory::raw('count(products.product_category_id) as product_quantity')
    //         )
    //         ->groupBy('product_categories.id')
    //         ->get();

    //     return view("user.product.index", ['productImages' => $productImagesClient, 'productCategories' => $productCategories, 'topProductLoves' => $topProductLoves, 'productDetails' => $productDetails]);
    // }

    // public function userDetail($id)
    // {
    //     // $productImages = Product::join('product_images', 'product_images.product_id', "=", 'products.id')
    //     // ->groupBy('product_images.id')
    //     // ->where('products.id' , '=' , $id)
    //     // ->where('product_images.deleted_at' , '=' , null)
    //     // ->get();
    //     $productImages = ProductImage::join('products', 'product_images.product_id', "=", 'products.id')
    //         ->groupBy('product_images.id')
    //         ->where('products.id', '=', $id)
    //         ->limit(5)
    //         ->get();
    //     $productDetail = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
    //         ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
    //         ->groupBy('products.id')
    //         ->select(
    //             'products.name',
    //             "products.id",
    //             "products.short_description",
    //             "products.long_description",
    //             "product_categories.name as category_name",
    //             "product_details.status as status",
    //             ProductDetail::raw('max(product_details.regular_price) as max_regular_price'),
    //             ProductDetail::raw('min(product_details.regular_price) as min_regular_price'),
    //             ProductDetail::raw('max(product_details.sale_price) as max_sale_price'),
    //             ProductDetail::raw('min(product_details.sale_price) as min_sale_price'),
    //         )
    //         ->where('products.id', '=', $id)
    //         ->get();
    //     $topProductLoves = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
    //         ->join('product_images', 'products.id', "=", 'product_images.product_id')
    //         ->groupBy('products.id')
    //         ->select(
    //             'products.name',
    //             "products.id",
    //             "product_images.image_url",
    //             ProductDetail::raw('max(product_details.regular_price) as max_regular_price'),
    //             ProductDetail::raw('min(product_details.regular_price) as min_regular_price'),
    //             ProductDetail::raw('max(product_details.sale_price) as max_sale_price'),
    //             ProductDetail::raw('min(product_details.sale_price) as min_sale_price'),
    //         )
    //         ->limit(4)
    //         ->get();
    //     $productCategories = ProductCategory::leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
    //         ->select(
    //             'product_categories.id',
    //             'product_categories.name',
    //             'products.product_category_id',
    //             ProductCategory::raw('count(products.product_category_id) as product_quantity')
    //         )
    //         ->groupBy('product_categories.id')
    //         ->get();
    //     $productAttribute = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
    //         ->join('product_attribute_product_detail', 'product_attribute_product_detail.product_detail_id', '=', 'product_details.id')
    //         ->join('product_attributes', 'product_attributes.id', '=', 'product_attribute_product_detail.product_attribute_id')
    //         ->join('product_attribute_categories', 'product_attribute_categories.id', 'product_attributes.product_attribute_category_id')
    //         ->groupBy('product_attribute_product_detail.product_attribute_id')
    //         ->select("product_attribute_product_detail.product_attribute_id", "product_attribute_categories.name", "product_attributes.name as Name_atribute")
    //         ->where('products.id', '=', $id)
    //         ->get();
    //     // $productDetails = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
    //     //     ->leftJoin('product_details', 'product_details.product_id', '=', 'products.id')
    //     //     ->leftJoin('product_attribute_product_detail', 'product_details.id', '=', 'product_attribute_product_detail.product_detail_id')
    //     //     ->leftJoin('product_attributes', 'product_attribute_product_detail.product_attribute_id', '=', 'product_attributes.id')
    //     //     ->leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
    //     //     ->select(
    //     //         'products.id as product_id',
    //     //         'products.name as product_name',
    //     //         'products.short_description',
    //     //         'products.long_description',
    //     //         'product_categories.id as product_category_id',
    //     //         'product_categories.name as product_category_name',
    //     //         'product_details.id',
    //     //         'product_details.regular_price',
    //     //         'product_details.sale_price',
    //     //         'product_details.quantity',
    //     //         'product_details.status',
    //     //         'product_attribute_product_detail.product_attribute_id',
    //     //         'product_attributes.name as product_attribute_name',
    //     //         'product_attributes.description_value',
    //     //         'product_attribute_categories.name as product_attribute_category_name',
    //     //     )
    //     //     ->where('products.id', '=', $id)
    //     //     ->get();
    //     //     dd($productDetails);

    //     return view("user.product.detail", ['productImages' => $productImages, 'topProductLoves' => $topProductLoves, 'productDetail' => $productDetail, 'productCategories' => $productCategories, 'productAttribute' => $productAttribute]);
    // }
}
