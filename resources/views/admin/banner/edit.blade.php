@extends('admin.layouts.master')
@section('title', 'Sửa Banner')
@section('content')
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (isset($banner))
            <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/banners/update">
                @csrf
                <input hidden readonly name="bannerId" type="text" class="form-control" id="exampleName"
                    value="{{ isset($banner->id) ? $banner->id : 1 }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleImageUrl" class="form-label">Hình ảnh Banner</label>
                            <input name="image_url" type="file" class="form-control" id="exampleImageUrl"
                                value="{{ old('image_url') }}">
                            <p class="text-danger">
                                @error('image_url')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="exampleDescription" class="form-label">Image Alt</label>
                            <textarea name="image_alt" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('image_alt') != '' ? old('image_alt') : $banner->image_alt }}</textarea>
                            <p class="text-danger">
                                @error('image_alt')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleName" class="form-label ">Ảnh Trước đó: </b></label>
                            <img class="" style="width:40%" src="/{{ isset($banner) ? $banner->image_url : '' }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mb-3">Cập nhật</button>
            </form>
        @endif
        <a class="btn btn-outline-danger mt-5" href="/admin/banners">Quay lại danh sách</a>
    </div>
@endsection
