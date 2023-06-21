<?php


namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Since;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::orderBy('level', 'asc')
            ->paginate(10);
        $levels = sizeOf($banner);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.banner.index', ["banner" => $banner, "levels" => $levels, 'numberPage' => $numberPage]);
    }

    public function create()
    {
        $banner = Banner::all();
        $countBanner = sizeOf($banner);
        if ($countBanner >= 10) {
            session()->flash('error', 'Số lượng banner đã đạt giới hạn cho phép, cần xóa bớt để thêm mới!');

            return redirect('/admin/banners');
        }

        return view('admin.banner.create', []);
    }

    public function store(Request $request)
    {
        $banner = Banner::all();
        $countBanner = sizeOf($banner);
        $images = $request->file('image_url');
        if (isset($images) && sizeOf($images) > 0) {
            $validator = Validator::make($request->all(), [
                'image_url.*' => 'required|image|max:2048|mimes:jpeg,jpg,png,gif', // validate từng file trong mảng images, giới hạn dung lượng 2MB
                'image_url' => 'max:' . (10 - $countBanner), // giới hạn tối đa 4 file
                'image_alt' => ['nullable', 'string', 'max:128']
            ], [
                'image_url.*.required' => 'Vui lòng chọn ảnh banner.',
                'image_url.*.image' => 'Tệp tin có loại không phải là hình ảnh.',
                'image_url.*.max' => 'Dung lượng tối đa cho phép là :max kilobytes.',
                'image_url.*.mimes' => 'Định dạng tệp tin cho phép là :values.',
                'image_url.max' => 'Số lượng file đẩy lên tối đa là ' . (10 - $countBanner),
                // 'image_alt.required' => 'Vui lòng nhập nội dung thay thế cho ảnh.',
                'image_alt.max' => 'Mô tả vượt quá số ký tự cho phép là 128'
            ]);
            if ($validator->fails()) {
                return redirect('/admin/banners/create')
                    ->withErrors($validator)
                    ->withInput();
            }
            //end validation

            // xử lý trùng tên ảnh

            $maxLevel = Banner::max('level');
            for ($i = 0; $i < sizeOf($images); $i++) {
                $image_path[$i] = 'images/banner/' . $images[$i]->getClientOriginalName();
                $images[$i]->move(public_path('images/banner'), $images[$i]->getClientOriginalName());
                $banner = Banner::create([
                    'level' => $i + 1 + $maxLevel,
                    'image_url' => $image_path[$i],
                    'image_alt' => $request->image_alt
                ]);
            }
            session()->flash('success', 'Thêm ảnh banner thành công');

            return redirect('/admin/banners');
        } else {
            session()->flash('error', 'Không có hình ảnh nào được chọn!');

            return redirect('/admin/banners/create');
        }
    }

    public function edit($id)
    {
        $bannerCheck = Banner::where('id', $id);
        if ($bannerCheck->doesntExist()) {
            session()->flash('error', 'Không tồn tại ảnh này!');

            return redirect('/admin/banners');
        }
        $banner = Banner::find($id);

        return view('admin.banner.edit', ['banner' => $banner]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'image_url' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:128']
        ]);
        $image = $request->file('image_url');
        if (isset($image)) {
            $image_path = 'images/banner/' . $image->getClientOriginalName();
            $image->move(public_path('images/banner'), $image->getClientOriginalName());
            $banner = banner::find($request->bannerId);
            $banner->update([
                'image_url' => $image_path,
                'image_alt' => $request->image_alt
            ]);
            session()->flash('succcess', "Cập Nhập Ảnh Thành Công!");

            return redirect('/admin/banners');
        }
        $banner = banner::find($request->bannerId);
        $banner->update([
            "image_alt" => $request->image_alt
        ]);
        session()->flash('success', "Cập Nhập Ảnh Thành Công!");

        return redirect('/admin/banners');
    }

    public function updateLevel(Request $request)
    {
        $banners = Banner::all();
        $levels = [];
        for ($i = 0; $i < sizeOf($banners); $i++) {
            $levels[$banners[$i]->id] = $request[$banners[$i]->id];
        }
        if (sizeOf(collect($levels)->duplicates()) > 0) {
            session()->flash('error', 'Level đang bị trùng , mời nhập lại');

            return redirect('/admin/banners');
        } else {
            for ($i = 0; $i < sizeOf($banners); $i++) {
                $banners[$i]->update([
                    'level' => $levels[$banners[$i]->id]
                ]);
            };
            session()->flash('success', 'Cập Nhập Thành Công Level!');

            return redirect('/admin/banners');
        }
    }

    public function destroy($id)
    {
        $Banner = Banner::find($id);
        if (isset($banner)) {
            $Banner->delete();
        }

        return redirect('/admin/banners');
    }

    public function listDeleted()
    {
        $banner = Banner::onlyTrashed()->paginate(10);
        if (isset($_GET['page'])) {
            $numberPage = $_GET['page'];
        } else {
            $numberPage = 1;
        }

        return view('admin.banner.deletedList', ["banner" => $banner, 'numberPage' => $numberPage]);
    }

    public function restoreDeleted($id)
    {
        // xử lý check danh mục có có hay ko
        $banner = Banner::withTrashed()
            ->where('id', $id)
            ->restore();

        return redirect('/admin/banners/deleted-list');
    }

    public function forceDeleted($id)
    {
        //Xoá là bay màu về index luôn
        $banner = Banner::withTrashed()
            ->where('id', $id);
        if ($banner->doesntExist()) {
            session()->flash('error', 'Không tồn tại ảnh này!');

            return redirect('/admin/banners');
        }
        $banner->forceDelete();
        session()->flash('success', 'Xóa ảnh thành công.');
        // update lại level cho toàn bộ ảnh
        $banners = Banner::orderBy('level', 'asc')->get();
        if (sizeOf($banners) > 0) {
            foreach ($banners as $key => $banner) {
                $banner->update([
                    'level' => $key + 1
                ]);
                // echo $banner->id ."sdsd".$banner->level;
            }
        }

        return redirect('/admin/banners');
    }
}
