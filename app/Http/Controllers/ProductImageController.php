<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
        $productImages = ProductImage::paginate(10);
        $products = Product::all();
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productImage.index', ["productImages" => $productImages, 'products' => $products, 'numberPage' => $numberPage]);
    }

    public function productImage($id)
    {
        $productImages = ProductImage::where('product_id', "=", $id)->get();
        $product = Product::find($id);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productImage.productImage', ["productImages" => $productImages, 'product' => $product, 'numberPage' => $numberPage]);
    }

    public function create($id)
    {
        $product = Product::find($id);
        return view('admin.productImage.create', ['id' => $id, 'product' => $product]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_alt' => ['nullable', 'string', 'max:128']
        ]);
        $images = $request->file('image_url');
        $quantityImage = 0;
        if (isset($images)) {
            for ($i = 0; $i < sizeOf($images); $i++) {
                $image_path[$i] = 'images/product/' . $images[$i]->getClientOriginalName();
                $images[$i]->move(public_path('images/product'), $images[$i]->getClientOriginalName());
                if ($i == 0) {
                    $ProductImage = ProductImage::create([
                        'product_id' => $request->productId,
                        'image_url' => $image_path[$i],
                        'level' => 0,
                        'image_alt' => $request->image_alt
                    ]);
                } else {
                    $ProductImage = ProductImage::create([
                        'product_id' => $request->productId,
                        'image_url' => $image_path[$i],
                        'level' => 1,
                        'image_alt' => $request->image_alt
                    ]);
                }
            }
            $quantityImage = sizeOf($images);
        }
        if (isset($request->productId)) {
            $product = Product::find($request->productId);
            $productName = $product->name;
            session()->flash('success', "Thêm thành công $quantityImage ảnh cho sản phẩm: $productName ");
        }

        return redirect('/admin/product-details/detail/' . $request->productId);
    }

    public function edit($id)
    {
        $productImage = ProductImage::find($id);
        return view('admin.productImage.edit', ['productImage' => $productImage]);
    }

    public function update(Request $request)
    {
        if (isset($request)) {
            $image = $request->file('image_url');
            if (isset($image)) {
                $image_path = 'images/product/' . $image->getClientOriginalName();
                $image->move(public_path('images/product'), $image->getClientOriginalName());
                $productImage = ProductImage::find($request->productImageId);
                $productImage->update([
                    "image_url" => $image_path,
                    "image_alt" => $request->image_alt
                ]);
                session()->flash('success', "Cập Nhập Ảnh Thành Công!");

                return redirect('/admin/product-details/detail/' . $productImage->product_id);
            }
            $productImage = ProductImage::find($request->productImageId);
            $productImage->update([
                "image_alt" => $request->image_alt
            ]);
            session()->flash('success', "Cập Nhập Ảnh Thành Công!");

            return redirect('/admin/product-details/detail/' . $productImage->product_id);
        }
    }

    // public function destroy($id)
    // {
    //     $productImage = ProductImage::find($id);
    //     $productImage->delete();

    //     return redirect('/admin/product-details/detail/' . $id);
    // }
    public function destroy($id)
    {
        $productImage = ProductImage::find($id);
        $productImage->delete();
        $productId = $productImage->product_id;
        session()->flash('success', "Xóa thành công!");

        return redirect('/admin/product-details/detail/' . $productId);
    }

    public function listDeleted()
    {
        $products = Product::all();
        $productImages = ProductImage::onlyTrashed()->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.productImage.deletedList', ["productImages" => $productImages, 'products' => $products, 'numberPage' => $numberPage]);
    }

    public function restoreDeleted($id)
    {
        // xử lý check danh mục có có hay ko
        $productImages = ProductImage::withTrashed()
            ->where('id', $id)
            ->restore();
        session()->flash('success', "Khôi Phục Ảnh Thành Công!");

        return redirect('/admin/product-images/deleted-list');
    }
    public function forceDeleted($id)
    {
        // dd("sdfgdfgdfgdfg");
        // xử lý check danh mục có có hay ko
        $productImages = ProductImage::withTrashed()
            ->where('id', $id)
            ->forceDelete();
        session()->flash('error', "Xóa Vĩnh Viễn Ảnh Thành Công!");

        return redirect('/admin/product-images/deleted-list');
    }
}
