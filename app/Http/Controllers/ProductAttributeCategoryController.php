<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ProductAttributeCategory;


class ProductAttributeCategoryController extends Controller
{
    public function index()
    {
        $productAttributeCategory = ProductAttributeCategory::paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view("admin.productAttributeCategory.index", ['productAttributeCategories' => $productAttributeCategory, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        return view('admin.productAttributeCategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'description' => ['nullable', 'string', 'max:128'],
        ]);
        $checkName = ProductAttributeCategory::where('name', $request->name)->exists();
        if ($checkName) {
            // session()->flash('error', 'Tên đã có, thay tên khác đi bạn êii!');
            return redirect('/admin/product-categories/create')->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
        }
        $productAttributeCategory = ProductAttributeCategory::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        // dd($ProductAttributeCategory);

        return redirect('/admin/product-attribute-categories');
    }

    public function edit($id)
    {
        $productAttributeCategory = ProductAttributeCategory::find($id);

        return view("admin.productAttributeCategory.edit", ["productAttributeCategory" => $productAttributeCategory]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:60'],
            'description' => ['nullable', 'string', 'max:128'],
        ]);
        $productAttributeCategory = ProductAttributeCategory::find($id);
        $productAttributeCategory->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        session()->flash('success', 'Cập nhật thành công.');

        return redirect('/admin/product-attribute-categories');
    }

    public function destroy($id)
    {
        // xử lý check danh mục có có hay ko
        $product = ProductAttributeCategory::find($id);
        $product->delete();

        return redirect('/admin/product-attribute-categories');
    }

    public function listDeleted()
    {
        $productAttributeCategories = ProductAttributeCategory::onlyTrashed()->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productAttributeCategory.deletedList', ["productAttributeCategories" => $productAttributeCategories, 'numberPage' => $numberPage]);
    }

    public function restoreDeleted($id)
    {
        // xử lý check danh mục có có hay ko
        $product = ProductAttributeCategory::withTrashed()
            ->where('id', $id)
            ->restore();
        // dd($product);

        return redirect('/admin/product-attribute-categories/deleted-list');
    }
    public function forceDeleted($id)
    {
        // dd("sdfgdfgdfgdfg");
        // xử lý check danh mục có có hay ko
        $product = ProductAttributeCategory::withTrashed()
            ->where('id', $id)
            ->forceDelete();

        return redirect('/admin/product-attribute-categories/deleted-list');
    }
}
