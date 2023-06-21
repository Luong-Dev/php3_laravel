<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCategory;
use App\Http\Requests\NhapProductAttribute;


class ProductAttributeController extends Controller
{
    //
    public function index()
    {
        $productAttributes  = ProductAttribute::leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
            ->select(
                'product_attributes.id',
                'product_attribute_categories.name as product_attribute_category_name',
                'product_attributes.name as product_attribute_name',
                'product_attributes.description_value',
            )
            ->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }
        return view("admin.productAttribute.index", ['productAttributes' => $productAttributes, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        $productAttributeCategories = ProductAttributeCategory::all();
        // check màu sắc có còn là id=6 không;
        return view('admin.productAttribute.create', ['productAttributeCategories' => $productAttributeCategories]);
    }

    public function store(NhapProductAttribute $request)
    {
        // check màu sắc có còn là id=6 không;
        if ($request->productAttributeCategory_id == 6) {
            $request->validate([
                'productAttributeCategory_id' => ['required', 'integer'],
                'name' => ['required', 'string', 'max:60'],
                'description_value' => ['required', 'string', 'max:30']
            ]);
        } else {
            $request->validate([
                'productAttributeCategory_id' => ['required', 'integer'],
                'name' => ['required', 'string', 'max:60'],
                'description_value' => ['nullable', 'string', 'max:0']
            ]);
        }
        $checkName = ProductAttribute::where('name', $request->name)->exists();
        if ($checkName) {
            // session()->flash('error', 'Tên đã có, thay tên khác đi bạn êii!');
            return redirect('/admin/product-attributes/create')->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
        }

        $productAttribute = ProductAttribute::create([
            'product_attribute_category_id' => $request->productAttributeCategory_id,
            'name' => $request->name,
            'description_value' => $request->description_value
        ]);
        // dd($ProductAttribute);
        session()->flash('success', 'Thêm thành công thuộc tính: ' . $request->name);

        return redirect('/admin/product-attributes');
    }

    public function edit($id)
    {
        $productAttribute = ProductAttribute::find($id);
        $productAttributeCategories = ProductAttributeCategory::all();

        return view("admin.productAttribute.edit", ["productAttribute" => $productAttribute, 'productAttributeCategory' => $productAttributeCategories]);
    }

    public function update($id, NhapProductAttribute $request)
    {
        $request->validate([
            'productAttributeCategory_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:60'],
            'description_value' => ['nullable', 'string', 'max:128']
        ]);
        $checkName = ProductAttribute::where('name', $request->name)->exists();
        if ($checkName) {
            $productAttribute = ProductAttribute::where('id', $id)->first();
            if ($request->name != $productAttribute->name) {

                return redirect('/admin/product-attributes/edit/' . $id)->with('error', 'Tên đã có, thay tên khác đi bạn êii!');
            }
        }
        $productAttribute = ProductAttribute::find($id);
        $productAttribute->update([
            'product_attribute_category_id' => $request->productAttributeCategory_id,
            'name' => $request->name,
            'description_value' => $request->description_value
        ]);
        session()->flash('success', 'Cập nhật thành công.');

        return redirect('/admin/product-attributes');
    }

    public function destroy($id)
    {
        // xử lý check danh mục có có hay ko
        $product = ProductAttribute::find($id);
        $product->delete();

        return redirect('/admin/product-attributes');
    }

    public function listDeleted()
    {
        // $productAttributes = ProductAttribute::onlyTrashed()->paginate(10);
        $productAttributes  = ProductAttribute::leftJoin('product_attribute_categories', 'product_attribute_categories.id', '=', 'product_attributes.product_attribute_category_id')
            ->select(
                'product_attributes.id',
                'product_attribute_categories.name as product_attribute_category_name',
                'product_attributes.name as product_attribute_name',
                'product_attributes.description_value',
            )
            ->onlyTrashed()->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productAttribute.deletedList', ["productAttributes" => $productAttributes, 'numberPage' => $numberPage]);
    }

    public function restoreDeleted($id)
    {
        // xử lý check danh mục có có hay ko
        $product = ProductAttribute::withTrashed()
            ->where('id', $id)
            ->restore();
        // dd($product);

        return redirect('/admin/product-attributes/deleted-list');
    }
    public function forceDeleted($id)
    {
        // dd("sdfgdfgdfgdfg");
        // xử lý check danh mục có có hay ko
        $product = ProductAttribute::withTrashed()
            ->where('id', $id)
            ->forceDelete();

        return redirect('/admin/product-attributes/deleted-list');
    }
}
