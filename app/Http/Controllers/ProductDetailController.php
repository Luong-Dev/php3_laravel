<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Termwind\Components\Dd;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCategory;
use App\Models\ProductAttributeProductDetail;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImage;

class ProductDetailController extends Controller
{
    public function createNoAttribute($productId)
    {
        // check id sp
        $checkProduct = Product::where('id', $productId)->doesntExist();
        if ($checkProduct) {
            return redirect('/admin/products')->with('error', 'Không tồn tại sản phẩm này');
        }
        //check xem đã tồn tại product detail nào hay chưa
        $checkProductDetail = ProductDetail::where('product_id', $productId)->exists();
        if ($checkProductDetail) {
            session()->flash('error', 'Sản phẩm đã thiết lập thông tin chi tiết, vui lòng chỉnh sửa hoặc thiết lập lại thông tin!');

            return redirect("/admin/product-details/detail/$productId");
        }
        $product = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.short_description',
                'products.long_description',
                'product_categories.id as product_category_id',
                'product_categories.name as product_category_name',
            )
            ->find($productId);
        $arrStatus = [
            "1" => "Còn hàng",
            "2" => "Hàng đang về",
            "3" => "Tạm hết",
            "4" => "Ngưng bán"
        ];

        return view('admin.productDetail.createNoAttribute', ['product' => $product, 'arrStatus' => $arrStatus]);
    }

    public function storeNoAttribute($productId, Request $request)
    {
        $request->validate([
            'regular_price' => ['required', 'integer', 'min:0', 'max:99999999'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'quantity' => ['required', 'integer', 'min:0', 'max:99999999'],
            'status' => ['nullable', 'integer'],
        ]);
        if ($request->sale_price > $request->regular_price) {
            session()->flash('error', 'Bạn bị làm sao thế nhờ! Gía Sale sao có thể lớn hơn giá thường chứ!');

            return redirect("/admin/product-details/create-no-attribute/$productId");
        }
        $productDetail = ProductDetail::create([
            'product_id' => $productId,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);

        return redirect("/admin/product-details/detail/$productId");
    }

    public function createOptionHaveAttribute($productId)
    {
        // check id sp
        $checkProduct = Product::where('id', $productId)->doesntExist();
        if ($checkProduct) {
            return redirect('/admin/products')->with('error', 'Không tồn tại sản phẩm này');
        }
        //check xem đã tồn tại product detail nào hay chưa
        $checkProductDetail = ProductDetail::where('product_id', $productId)->exists();
        if ($checkProductDetail) {
            session()->flash('error', 'Sản phẩm đã thiết lập thông tin chi tiết, vui lòng chỉnh sửa hoặc thiết lập lại thông tin!');

            return redirect("/admin/product-details/detail/$productId");
        }
        $product = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.short_description',
                'products.long_description',
                'product_categories.id as product_category_id',
                'product_categories.name as product_category_name',
            )
            ->find($productId);
        $productAttributeCategories = ProductAttributeCategory::all();
        $productAttributes = ProductAttribute::all();

        return view('admin.productDetail.createOptionHaveAttribute', ['product' => $product, 'productAttributeCategories' => $productAttributeCategories, 'productAttributes' => $productAttributes]);
    }

    public function storeOptionHaveAttribute($productId, Request $request)
    {
        //lấy được 1 mảng có n danh mục thuộc tính rồi thì làm sao foreach được  được n cấp như dưới
        // foreach ($color as $key => $value) {
        //     foreach ($ram as $key => $value) {
        //         foreach ($rom as $key => $value) {
        //             foreach ($test as $key => $value) {
        //             }
        //         }
        //     }
        // }
        $productAttributeIds = [];
        $mixOptions = [];
        $colors = $request->input('attributes_6');
        $memories = $request->input('attributes_8');
        //$warranties = $request->input('attributes_14'); //thằng này đổi sang radio , chỉ được chọn 1 hoặc không chọn
        $warranties = [];
        // cả 3 khác rỗng
        if (!empty($colors) && !empty($memories) && !empty($warranties)) {
            foreach ($colors as  $color) {
                foreach ($memories as $memory) {
                    foreach ($warranties as $warranty) {
                        $mixOptions[] = [$color, $memory, $warranty];
                    }
                }
            }
            foreach ($colors as  $color) {
                $productAttributeIds[] = $color;
            }
            foreach ($memories as $memory) {
                $productAttributeIds[] = $memory;
            }
            foreach ($warranties as $warranty) {
                $productAttributeIds[] = $warranty;
            }
        }
        // 1 trong 3 rỗng
        if (empty($colors) && !empty($memories) && !empty($warranties)) {
            foreach ($memories as $memory) {
                foreach ($warranties as $warranty) {
                    $mixOptions[] = [$memory, $warranty];
                }
            }
            foreach ($memories as $memory) {
                $productAttributeIds[] = $memory;
            }
            foreach ($warranties as $warranty) {
                $productAttributeIds[] = $warranty;
            }
        }
        if (!empty($colors) && empty($memories) && !empty($warranties)) {
            foreach ($colors as  $color) {
                foreach ($warranties as $warranty) {
                    $mixOptions[] = [$color, $warranty];
                }
            }
            foreach ($colors as  $color) {
                $productAttributeIds[] = $color;
            }
            foreach ($warranties as $warranty) {
                $productAttributeIds[] = $warranty;
            }
        }
        if (!empty($colors) && !empty($memories) && empty($warranties)) {
            foreach ($colors as  $color) {
                foreach ($memories as $memory) {
                    $mixOptions[] = [$color, $memory];
                }
            }
            foreach ($colors as  $color) {
                $productAttributeIds[] = $color;
            }
            foreach ($memories as $memory) {
                $productAttributeIds[] = $memory;
            }
        }

        // 2 trong 3 rỗng
        if (empty($colors) && empty($memories) && !empty($warranties)) {
            foreach ($warranties as $warranty) {
                $mixOptions[] = [$warranty];
            }
            foreach ($warranties as $warranty) {
                $productAttributeIds[] = $warranty;
            }
        }
        if (empty($colors) && !empty($memories) && empty($warranties)) {
            foreach ($memories as $memory) {
                $mixOptions[] = [$memory];
            }
            foreach ($memories as $memory) {
                $productAttributeIds[] = $memory;
            }
        }
        if (!empty($colors) && empty($memories) && empty($warranties)) {
            foreach ($colors as  $color) {
                $mixOptions[] = [$color];
            }
            foreach ($colors as  $color) {
                $productAttributeIds[] = $color;
            }
        }
        $productDetailIds = [];
        if (!empty($mixOptions)) {
            $productAttributes = ProductAttribute::whereIn('id', $productAttributeIds)->get();
            foreach ($mixOptions as $mixOption) {
                $productDetail = ProductDetail::create([
                    'product_id' => $productId,
                    'regular_price' => -10,
                    'sale_price' => -10,
                    'quantity' => 0,
                    'status' => 4
                ]);
                // dd($productDetail->id);
                foreach ($mixOption as $value) {
                    ProductAttributeProductDetail::create([
                        'product_attribute_id' => $value,
                        'product_detail_id' => $productDetail->id
                    ]);
                }
            }
            // dd($productAttributeIds,$productAttibutes);
            // phải tạo được số productDetail tương ứng với count của mảng
            // lưu tạm thời thông tin gồm product_id, và lấy luôn id của bản ghi này bắn sang bước tiếp theo, còn những trường khác sẽ lưu sau
            // xong sẽ lấy id tương ứng để thêm vào bảng product_attribute_product_detail
            $product = Product::find($productId);

            return redirect("/admin/product-details/detail/$productId");
            // return redirect("/admin/product-attribute-product-detail/index/$productId");
        } else {
            return redirect("/admin/product-details/create-no-attribute/$productId");
        }
    }

    public function createHaveAttribute($productId)
    {
        $product = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.short_description',
                'products.long_description',
                'product_categories.id as product_category_id',
                'product_categories.name as product_category_name',
            )
            ->find($productId);
        $arrStatus = [
            "1" => "Còn hàng",
            "2" => "Hàng đang về",
            "3" => "Tạm hết",
            "4" => "Ngưng bán"
        ];
        $productAttributeCategories = ProductAttributeCategory::all();
        $productAttributes = ProductAttribute::all();

        return view('admin.productDetail.createHaveAttribute', ['product' => $product, 'arrStatus' => $arrStatus, 'productAttributeCategories' => $productAttributeCategories, 'productAttributes' => $productAttributes]);
    }

    public function storeHaveAttribute($productId, Request $request)
    {

        $request->validate([
            'regular_price' => ['required', 'integer', 'min:0', 'max:99999999'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'quantity' => ['required', 'integer', 'max:99999999'],
            // 'image_url' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,max:2048'],
            // 'image_alt' => ['nullable', 'string', 'max:128'],
            'status' => ['nullable', 'integer'],
        ]);
        $productDetail = ProductDetail::create([
            'product_id' => $productId,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);

        return redirect('/admin/products');
    }


    public function detail($productId)
    {
        // check id sp
        $checkProduct = Product::where('id', $productId)->doesntExist();
        if ($checkProduct) {
            return redirect('/admin/products')->with('error', 'Không tồn tại sản phẩm này');
        }
        $product = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.short_description',
                'products.long_description',
                'products.views',
                'product_categories.id as product_category_id',
                'product_categories.name as product_category_name'
            )
            ->where('products.id', $productId)
            ->first();
        // dd($product);
        $productDetails = ProductDetail::where('product_id', $productId)->get();
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

        $productImages = ProductImage::where('product_id', "=", $productId)->get();

        return view('admin.productDetail.detail', [
            'arrStatus' => $arrStatus, 'productDetails' => $productDetails, 'mixOptions' => $mixOptions,
            'productAttributeProductDetails' => $productAttributeProductDetails, 'arrStatus' => $arrStatus,
            'product' => $product, "productImages" => $productImages
        ]);
    }

    public function edit($productId, $productDetailId)
    {
        $product = Product::where('id', $productId);
        if ($product->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products');
        }
        $productDetail = ProductDetail::where('id', $productDetailId);
        if ($productDetail->doesntExist()) {
            session()->flash('error', 'Không tồn tại chi tiết này!');

            return redirect('/admin/product-details/detail/' . $productId);
        }
        $product = Product::find($productId);
        $productDetail = ProductDetail::find($productDetailId);
        $arrStatus = [
            "1" => "Còn hàng",
            "2" => "Hàng đang về",
            "3" => "Tạm hết",
            "4" => "Ngưng bán"
        ];

        return view('admin.productDetail.edit', ['productId' => $productId, 'productDetailId' => $productDetailId, 'productDetail' => $productDetail, 'product' => $product, 'arrStatus' => $arrStatus]);
    }

    public function update($productId, $productDetailId, Request $request)
    {
        $request->validate([
            'regular_price' => ['required', 'integer', 'min:0', 'max:99999999'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'quantity' => ['required', 'integer', 'min:0', 'max:99999999'],
            'status' => ['nullable', 'integer'],
        ]);
        if ($request->sale_price > $request->regular_price) {
            session()->flash('error', 'Bạn bị làm sao thế nhờ! Gía Sale sao có thể lớn hơn giá thường chứ!');

            return redirect("/admin/product-details/edit/$productId/$productDetailId");
        }
        $productDetail = ProductDetail::find($productDetailId);
        $productDetail->update([
            'product_id' => $productId,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);
        session()->flash('success', 'Cập nhật thành công!');

        return redirect("/admin/product-details/detail/$productId");
    }

    public function destroyAll($productId)
    {
        $product = Product::where('id', $productId);
        if ($product->exists()) {
            $productDetails = ProductDetail::where('product_id', $productId)->get();
            foreach ($productDetails as $key => $productDetail) {
                $productDetail->delete();
            }
            session()->flash('success', 'Làm mới thành công.');

            return redirect('/admin/product-details/detail/' . $productId);
        } else {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products');
        }
    }

    public function destroyOne($productId, $productDetailId)
    {
        $product = Product::where('id', $productId);
        if ($product->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products');
        }
        $productDetail = ProductDetail::where('id', $productDetailId);
        if ($productDetail->doesntExist()) {
            session()->flash('error', 'Không tồn tại chi tiết này!');

            return redirect('/admin/product-details/detail/' . $productId);
        }
        $productDetail = ProductDetail::where('id', $productDetailId);
        $productDetail->delete();
        session()->flash('success', 'Xóa thành công.');

        return redirect('/admin/product-details/detail/' . $productId);
    }

    public function userDetail($id)
    {
        // hiện tại đang vì hình ảnh mà xung đột. check chung chung báo lỗi chưa lên kệ cho out về trang sản phẩm
        $checkProduct = Product::where('id', $id)->doesntExist();
        if ($checkProduct) {
            return redirect('/products')->with('error', 'Không tồn tại sản phẩm này');
        }
        $product =  Product::find($id);
        // tăng views
        $product->increment('views');
        // dd($product->views);
        // lấy hình ảnh
        $productImages = ProductImage::join('products', 'product_images.product_id', "=", 'products.id')
            ->groupBy('product_images.id')
            ->where('products.id', '=', $id)
            ->where('product_images.level', '!=', 0)
            ->limit(5)
            ->get();
        $productImageMain = ProductImage::join('products', 'product_images.product_id', "=", 'products.id')
            ->groupBy('product_images.id')
            ->where('products.id', '=', $id)
            ->where('product_images.level', '=', 0)
            ->first();
        // dd($productImages, $productImageMain);
        // bài toán đặt ra là đưa ra user một danh sách phân loại loại thuộc tính mà sp có, và thuộc tính tương ứng với loại mà sp có
        $productDetails = ProductDetail::leftJoin('product_attribute_product_detail', 'product_attribute_product_detail.product_detail_id', '=', 'product_details.id')
            ->leftJoin('product_attributes', 'product_attribute_product_detail.product_attribute_id', '=', 'product_attributes.id')
            ->leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
            ->where('product_details.product_id', '=', $id);
        $productAttributeCategories = $productDetails
            ->select(
                'product_attribute_categories.id',
                'product_attribute_categories.name',
                // 'product_attribute_categories.id as product_attribute_category_id',
                // 'product_attribute_categories.name as product_attribute_category_name',
                ProductDetail::raw('count(product_attribute_categories.id) as quantity_product_attribute_category'),
            )
            ->groupBy('product_attribute_categories.id')
            ->get();
        // tới đây xét điều kiện đếm có loại thuộc tính, tức là có thuộc tính mới chạy tiếp query lấy thuộc tính
        // phải xét trường có thuộc tính, không thuộc tính, có thuộc tính mà hết hàng hoặc ngưng bán,,...
        $productAttributes = $productDetails
            ->select(
                'product_attributes.id as id',
                'product_attributes.name as name',
                'product_attributes.description_value as description_value',
                'product_attribute_categories.id as product_attribute_category_id',
                'product_attribute_categories.name as product_attribute_category_name',
            )
            ->groupBy('product_attributes.id')
            ->get();
        // dd($productAttributeCategories, $productAttributes);

        // ở đây sẽ lấy sản phẩm có giá trị sale min nhỏ nhất để qua bên kia tự động select vào

        // xét trường hợp chỉ có 1 option thì đổ luôn hết thông tin ra, bất kể có thuộc tính hay không

        // dd('đến đây');

        // xét trường hợp sp không có thuộc tính
        $productNoAttribute = [];
        if (isset($productAttributeCategories['0']) && $productAttributeCategories['0']->quantity_product_attribute_category == 0) {
            // dd('ko thuộc tính');
            $productNoAttribute = $productDetails
                ->select(
                    'product_details.id',
                    'product_details.product_id',
                    'product_details.regular_price',
                    'product_details.sale_price',
                    'product_details.quantity',
                    'product_details.status',
                )
                ->first();
        }
        // xét trường hợp sản phẩm không có thông tin gì chi tiết thì cho out về sản phẩm
        if (!isset($productAttributeCategories['0'])) {
            return redirect('/products')->with('error', "Sản phẩm hiện ở trạng thái chưa sẵn sàng để bán!");
        }
        // dd('đến đây');
        // dd($productNoAttribute);

        $productStatus = [
            '1' => 'Còn hàng',
            '2' => 'Đang về',
            '3' => 'Tạm hết',
            '4' => 'Ngưng bán',
        ];

        return view("user.product.detail", [
            'product' => $product,
            'productImages' => $productImages, 'productImageMain' => $productImageMain,
            'productAttributeCategories' => $productAttributeCategories, 'productAttributes' => $productAttributes,
            'productNoAttribute' => $productNoAttribute, 'productStatus' => $productStatus
        ]);


        // về mặt controller thì lấy đk option thuộc tính mà người dùng sp vào, đưa vào dạng 1 mảng và so sánh mảng
        // trước khi thực hiện thì test so sánh mảng, tìm phương án so sánh

        $product = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.short_description',
                'products.long_description',
                'products.views',
                'product_categories.id as product_category_id',
                'product_categories.name as product_category_name'
            )
            ->where('products.id', $id)
            ->first();
        // dd($product);


        // cần lấy được tất cả thuộc tính con của sp này, và phân loại để qua bên view foreach
        // màu sắc có id là 6
        //bộ nhớ có id là 8
        // lấy tất cả thuộc tính của sp
        $productDetail = ProductDetail::where('product_id', $id)
            ->where('product_details.status', '!=', '4')
            ->where('product_details.regular_price', '>=', '0');
        if ($productDetail->exists()) {
            // dd("cos option");
            // dd($productDetail->first()->id);
            $productDetailId = $productDetail->first()->id;
            $productAttributeCategories = ProductAttributeProductDetail::join('product_attributes', 'product_attribute_product_detail.product_attribute_id', '=', 'product_attributes.id')
                ->join('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
                ->where('product_attribute_product_detail.product_detail_id', '=', $productDetailId)
                ->select(
                    // 'product_attribute_product_detail.product_attribute_id as product_attribute_id',
                    'product_attribute_categories.id as product_attribute_category_id',
                    // 'product_attributes.name as product_attribute_name',
                    // 'product_attributes.description_value as color_description_value',
                    'product_attribute_categories.name as product_attribute_category_name',
                )
                ->get();
            // dd($query);
            // if()
            $productAttributeCategoryDetails = []; //lấy loại thuộc tính
            foreach ($productAttributeCategories as $key => $productAttributeCategory) {
                $productAttributeCategoryDetails["$productAttributeCategory->product_attribute_category_id"] = $productAttributeCategory->product_attribute_category_name;
            }
            // dd($productAttributeCategoryDetails);
        }
        // lấy danh sách option
        // $productDetails = ProductDetail::where('product_id', $id)->get();
        // // lấy danh sách thuộc tính
        // $productAttributes = [];
        // if (sizeOf($productDetails) > 0) {
        //     foreach ($productDetails as $key => $productDetail) {
        //         $query = ProductAttributeProductDetail::where('product_attribute_product_detail.product_detail_id', '=', $productDetail->id);
        //     }
        // }
        // tesst tuwf ddaay
        $productDetails = ProductDetail::leftJoin('product_attribute_product_detail', 'product_attribute_product_detail.product_detail_id', '=', 'product_details.id')
            ->leftJoin('product_attributes', 'product_attribute_product_detail.product_attribute_id', '=', 'product_attributes.id')
            ->leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
            ->where('product_details.product_id', '=', $id);
        // từ đây có thể cắt ra thành 2 lần
        // ->select(
        //     'product_attributes.id as product_attribute_id',
        //     'product_attributes.name as  product_attribute_name',
        //     'product_attribute_categories.id as product_attribute_category_id',
        //     'product_attribute_categories.name as product_attribute_category_name',
        // );
        // ->groupBy('product_attributes.id')->get();
        $productAttributeCategories = $productDetails
            ->select(
                'product_attribute_categories.id as product_attribute_category_id',
                'product_attribute_categories.name as product_attribute_category_name'
            )
            ->groupBy('product_attribute_categories.id')
            ->get();
        $productAttributes = $productDetails
            ->select(
                'product_attributes.id as product_attribute_id',
                'product_attributes.name as  product_attribute_name',
                'product_attribute_categories.id as product_attribute_category_id',
                'product_attribute_categories.name as product_attribute_category_name',
            )
            ->groupBy('product_attributes.id')
            ->get();
        // dd($productAttributeCategories, $productAttributes);




        return view("user.product.detail", [
            'productImages' => $productImages, 'productImageMain' => $productImageMain,
            'productAttributeCategories' => $productAttributeCategories, 'productAttributes' => $productAttributes
        ]);




        $arr = [];
        if (sizeOf($productDetails) > 0) {
        }
        $productOptions = [];
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
        // người dùng bấm vào sẽ gửi 1 mảng gồm các thuộc tính
        // so sánh mảng này với mảng sau đây
        $productDetails = ProductDetail::where('product_id', $id)->get();
        $mixOptions = []; //để lưu các thuộc tính của 1 option chưa lấy được giá trị sat, phải for...
        $mixDetailOptions = []; //lưu các option với giá trị cụ thể.
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

        return view("user.product.detail", ['productImages' => $productImages, 'productImageMain' => $productImageMain]);

        $productDetail = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->groupBy('products.id')
            ->select(
                'products.name',
                "products.id",
                "products.short_description",
                "products.long_description",
                "product_categories.name as category_name",
                "product_details.status as status",
                ProductDetail::raw('max(product_details.regular_price) as max_regular_price'),
                ProductDetail::raw('min(product_details.regular_price) as min_regular_price'),
                ProductDetail::raw('max(product_details.sale_price) as max_sale_price'),
                ProductDetail::raw('min(product_details.sale_price) as min_sale_price'),
            )
            ->where('products.id', '=', $id)
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
        $productCategories = ProductCategory::leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'product_categories.id',
                'product_categories.name',
                'products.product_category_id',
                ProductCategory::raw('count(products.product_category_id) as product_quantity')
            )
            ->groupBy('product_categories.id')
            ->get();
        $productAttribute = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
            ->join('product_attribute_product_detail', 'product_attribute_product_detail.product_detail_id', '=', 'product_details.id')
            ->join('product_attributes', 'product_attributes.id', '=', 'product_attribute_product_detail.product_attribute_id')
            ->join('product_attribute_categories', 'product_attribute_categories.id', 'product_attributes.product_attribute_category_id')
            ->groupBy('product_attribute_product_detail.product_attribute_id')
            ->select("product_attribute_product_detail.product_attribute_id", "product_attribute_categories.name", "product_attributes.name as Name_atribute")
            ->where('products.id', '=', $id)
            ->get();

        return view("user.product.detail", ['productImages' => $productImages, 'topProductLoves' => $topProductLoves, 'productDetail' => $productDetail, 'productCategories' => $productCategories, 'productAttribute' => $productAttribute]);
    }
}
