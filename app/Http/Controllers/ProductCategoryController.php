<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::paginate(10);
        $products =  ProductCategory::leftJoin('products', 'product_categories.id', '=', 'products.product_category_id')
            ->select(
                'product_categories.id',
                'products.product_category_id',
                ProductCategory::raw('count(products.product_category_id) as product_quantity')
            )
            ->groupBy('product_categories.id')
            ->get();
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productCategory.index', ["productCategories" => $productCategories, "products" => $products, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        return view('admin.productCategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'description' => ['nullable', 'string', 'max:128'],
            'image_url' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:128']
        ]);
        $checkName = ProductCategory::where('name', $request->name)->exists();
        if ($checkName) {
            // session()->flash('error', 'Tên đã có, thay tên khác đi bạn êii!');
            return redirect('/admin/product-categories/create')->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
        }
        // dd( $request->file('image_url'));
        $image = $request->file('image_url');
        if ($image != '') {
            $image_path = 'images/productCategory/' . $image->getClientOriginalName();
            $image->move(public_path('images/productCategory'), $image->getClientOriginalName());
        } else {
            $image_path = '';
        }
        // dd($image->getClientOriginalName());
        $productCategory = ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_url' => $image_path,
            'image_alt' => $request->image_alt
        ]);
        session()->flash('success', 'Đã thêm mới danh mục: ' . $request->name);

        return redirect('/admin/product-categories');
    }

    public function edit($id)
    {
        // xử lý check danh mục có có hay ko
        $productCategory = ProductCategory::where('id', $id);
        if ($productCategory->doesntExist()) {
            session()->flash('error', 'Không tồn tại danh mục này!');

            return redirect('/admin/product-categories');
        }
        $productCategory = ProductCategory::find($id);

        return view("admin.productCategory.edit", ["productCategory" => $productCategory]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'description' => ['nullable', 'string', 'max:128'],
            'image_url' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:128']
        ]);
        $checkName = ProductCategory::where('name', $request->name)->exists();
        if ($checkName) {
            $productCategory = ProductCategory::where('id', $id)->first();
            if ($request->name != $productCategory->name) {

                return redirect('/admin/product-categories/edit/' . $id)->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
            }
        }
        $productCategory = ProductCategory::find($id);
        $image = $request->file('image_url');
        if ($image != '') {
            $image_path = 'images/productCategory/' . $image->getClientOriginalName();
            $image->move(public_path('images/productCategory'), $image->getClientOriginalName());
        } else {
            $image_path = $productCategory->image_url;
        }
        if ($request->image_alt == '') {
            $image_alt = $productCategory->image_alt;
        } else {
            $image_alt = $request->image_alt;
        }
        $productCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'image_url' => $image_path,
            'image_alt' => $image_alt
        ]);
        session()->flash('success', 'Cập nhật thành công danh mục: ' . $request->name);

        return redirect('/admin/product-categories');
    }

    public function destroy($id)
    {
        // xử lý check danh mục có có hay ko
        $productCategory = ProductCategory::where('id', $id);
        if ($productCategory->doesntExist()) {
            session()->flash('error', 'Không tồn tại danh mục này!');

            return redirect('/admin/product-categories');
        }
        // xử lý danh mục có sản phẩm hay không
        $checkProduct = Product::where('product_category_id', $id)->exists();
        if ($checkProduct) {
            session()->flash('error', 'Danh mục này đã có sản phẩm, không được xóa!');

            return redirect('/admin/product-categories');
        }
        $productCategory->delete();
        session()->flash('success', 'Xóa danh mục thành công.');

        return redirect('/admin/product-categories');
    }

    public function listDeleted()
    {
        $productCategories = ProductCategory::onlyTrashed()->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productCategory.deletedList', ["productCategories" => $productCategories, 'numberPage' => $numberPage]);
    }

    public function restoreDeleted($id)
    {
        //khôi phục
        $productCategory = ProductCategory::withTrashed()
            ->where('id', $id);
        if ($productCategory->doesntExist()) {
            session()->flash('error', 'Không tồn tại danh mục này!');

            return redirect('/admin/product-categories/deleted-list');
        } else {
            $productCategory->restore();
            session()->flash('success', 'Khôi phục danh mục thành công!');

            return redirect('/admin/product-categories/deleted-list');
        }
    }
    public function forceDeleted($id)
    {
        // xóa hẳn
        $productCategory = ProductCategory::withTrashed()
            ->where('id', $id);
        if ($productCategory->doesntExist()) {
            session()->flash('error', 'Không tồn tại danh mục này!');

            return redirect('/admin/product-categories/deleted-list');
        }
        // xử lý danh mục có sản phẩm hay không
        $checkProduct = Product::where('product_category_id', $id)->exists();
        if ($checkProduct) {
            session()->flash('error', 'Danh mục này đã có sản phẩm, không được xóa!');

            return redirect('/admin/product-categories');
        }
        $productCategory->forceDelete();
        session()->flash('success', 'Xóa danh mục thành công.');

        return redirect('/admin/product-categories/deleted-list');
    }
}
