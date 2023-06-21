<?php

namespace App\Http\Controllers;

use Termwind\Components\Dd;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // admin
    public function index()
    {
        // $productCategories = ProductCategory::all();
        // $products = Product::paginate(10);
        $products = Product::leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftJoin('product_details', 'product_details.product_id', '=', 'products.id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.short_description',
                'products.long_description',
                'product_categories.name as product_category_name',
                'product_details.quantity',
                Product::raw('sum(product_details.quantity) as product_quantity')
            )
            ->groupBy('products.id')
            ->paginate(10);
        // dd($products);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.product.index', ["products" => $products, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        $productCategories = ProductCategory::all();

        return view('admin.product.create', ["productCategories" => $productCategories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'short_description' => ['required', 'string', 'max:128'],
            'long_description' => ['required', 'string', 'max:600'],
            'product_category_id' => ['required', 'integer'],
        ]);
        $checkName = Product::where('name', $request->name)->exists();
        if ($checkName) {
            session()->flash('error', 'Tên đã có, thay tên khác đi bạn êii!');
            return redirect('/admin/products/create');
        }
        $product = Product::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'product_category_id' => $request->product_category_id
        ]);
        session()->flash('success', 'Thêm sản phẩm thành công, mời cập nhật thông tin chi tiết');

        return redirect("/admin/product-details/create-no-attribute/$product->id");
    }

    public function edit($id)
    {
        $product = Product::where('id', $id);
        if ($product->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products');
        }
        $product = Product::find($id);
        $productCategories = ProductCategory::all();

        return view("admin.product.edit", ["product" => $product], ["productCategories" => $productCategories]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'short_description' => ['required', 'string', 'max:255'],
            'long_description' => ['required', 'string', 'max:600'],
            'product_category_id' => ['required', 'integer'],
        ]);
        $checkName = Product::where('name', $request->name)->exists();
        if ($checkName) {
            $product = Product::where('id', $id)->first();
            if ($request->name != $product->name) {

                return redirect('/admin/products/edit/' . $id)->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
            }
        }
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'product_category_id' => $request->product_category_id
        ]);
        session()->flash('success', 'Cập nhật thông tin chung thành công!');

        return redirect('/admin/product-details/detail/' . $id);
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id);
        if ($product->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products');
        } else {
            $product->delete();
            session()->flash('success', 'Xóa sản phẩm thành công.');

            return redirect('/admin/products');
        }
    }

    public function listDeleted()
    {
        $products = Product::onlyTrashed()->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.product.deletedList', ["products" => $products, 'numberPage' => $numberPage]);
    }

    public function restoreDeleted($id)
    {
        //khôi phục
        $product = Product::withTrashed()
            ->where('id', $id);
        // dd('sdfsdf');
        if ($product->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products/deleted-list');
        } else {
            $product->restore();
            session()->flash('success', 'Khôi phục danh mục thành công!');

            return redirect('/admin/products/deleted-list');
        }
    }

    public function forceDeleted($id)
    {
        // xóa hẳn
        $product = Product::withTrashed()
            ->where('id', $id);
        if ($product->doesntExist()) {
            session()->flash('error', 'Không tồn tại sản phẩm này!');

            return redirect('/admin/products/deleted-list');
        } else {
            $product->forceDelete();
            session()->flash('success', 'Xóa sản phẩm thành công.');

            return redirect('/admin/products/deleted-list');
        }
    }

    // user
    public function userIndex()
    {
        // cần lấy sp có trạng thái khác ngưng bán
        // join vào bảng hình ảnh lấy ảnh có level là 1
        // join vào productDetail lấy tất cả bản ghi có trạng thái khác 4, thử nghiệm với giá lớn hơn hoặc bằng 0
        // groupBy theo productId
        // lấy min max
        $products = Product::leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftJoin('product_details', 'product_details.product_id', '=', 'products.id')
            ->where('product_images.level', '=', '0')
            ->where('product_details.status', '!=', '4')
            ->where('product_details.regular_price', '>=', '0')
            ->select(
                'products.id',
                'products.name',
                'products.views',
                'product_images.image_url',
                'product_images.image_alt',
                Product::raw('max(product_details.regular_price) as max_regular_price'),
                Product::raw('min(product_details.regular_price) as min_regular_price'),
                Product::raw('max(product_details.sale_price) as max_sale_price'),
                Product::raw('min(product_details.sale_price) as min_sale_price')
            )
            ->groupBy('products.id')
            ->paginate(8);
        // dd($products);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('user.product.index', ["products" => $products, 'numberPage' => $numberPage]);
        // $productImagesClient = Product::join('product_images', 'products.id', "=", 'product_images.product_id')
        //     ->groupBy('product_images.id')
        //     ->get();
        // $productDetails = Product::join('product_details', 'products.id', "=", 'product_details.product_id')
        //     ->groupBy('products.id')
        //     ->select(
        //         'products.name',
        //         "products.id",
        //         ProductDetail::raw('max(product_details.regular_price) as max_regular_price'),
        //         ProductDetail::raw('min(product_details.regular_price) as min_regular_price'),
        //         ProductDetail::raw('max(product_details.sale_price) as max_sale_price'),
        //         ProductDetail::raw('min(product_details.sale_price) as min_sale_price'),
        //     )->get();


        // $topProductLoves = Product::join('product_images', 'product_images.product_id', "=", "products.id")->groupBy("products.id")->orderBy('products.id', 'ASC')->limit(4)->get();
        // $productCategories = ProductCategory::leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
        //     ->select(
        //         'product_categories.id',
        //         'product_categories.name',
        //         'products.product_category_id',
        //         ProductCategory::raw('count(products.product_category_id) as product_quantity')
        //     )
        //     ->groupBy('product_categories.id')
        //     ->get();

        // return view("user.product.index", ['products' => $products, 'productImages' => $productImagesClient, 'productCategories' => $productCategories, 'topProductLoves' => $topProductLoves, 'productDetails' => $productDetails]);
    }
}