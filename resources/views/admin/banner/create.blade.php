@extends('admin.layouts.master')
@section('title', 'Thêm mới Banner')
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
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/banners/store">
            @csrf
            <div class="mb-3">
                <label for="exampleImageUrl" class="form-label">Hình ảnh Banner</label>
                <input name="image_url[]" type="file" class="form-control" multiple id="exampleImageUrl"
                    value="{{ old('image_url') }}">
                <p class="text-danger">
                    @error('image_url.*')
                        {{ $message }}
                    @enderror
                    @error('image_url')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3">
                <label for="exampleDescription" class="form-label">Image Alt</label>
                <textarea name="image_alt" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('image_alt') }}</textarea>
                <p class="text-danger">
                    @error('image_alt')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
            <a class="btn btn-outline-danger" href="/admin/banners">Quay lại danh sách</a>
        </form>
    </div>
@endsection
