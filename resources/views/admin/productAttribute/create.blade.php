@extends('admin.layouts.master')
@section('title', 'Thêm mới Thuộc Tính Sản Phẩm')
@section('content')
    <style>
        .description_no_select {
            display: none;
        }

        .selected_color {
            display: block;
        }
    </style>
    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/product-attributes/store">
            @csrf
            <div class="mb-3">
                <label for="exampleName" class="form-label">Tên thuộc tính sản phẩm</label>
                <input name="name" type="text" class="form-control" id="exampleName" aria-describedby="emailHelp"
                    value="{{ old('name') }}">
                <p class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3">
                <label for="exampleAttributeCategory" class="form-label">Loại thuộc tính sản phẩm</label>
                <select class="form-select js_selected_color" name="productAttributeCategory_id"
                    id="exampleAttributeCategory">
                    <option>Mở chọn loại thuộc tính</option>
                    @foreach ($productAttributeCategories as $productAttributeCategory)
                        <option value="{{ isset($productAttributeCategory) ? $productAttributeCategory->id : '' }}"
                            {{ old('productAttributeCategory_id') == $productAttributeCategory->id ? 'selected' : '' }}>
                            {{ $productAttributeCategory->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-danger">
                    @error('productAttributeCategory_id')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mb-3 js_description description_no_select">
                <label for="exampleDescription" class="form-label">Mô tả:
                    <span class="text-danger form-label">Ô giành cho loại màu sắc và ghi "MÃ MÀU" có dạng: <span
                            class="text-dark">#FFFFFF</span></span>
                </label>
                <textarea name="description_value" class="form-control" id="exampleDescription" cols="30" rows="2">{{ old('description_value') }}</textarea>
                <p class="text-danger">
                    @error('description_value')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
            <a class="btn btn-outline-danger" href="/admin/product-attributes">Quay lại danh sách</a>
        </form>
    </div>

    <script>
        const description = document.querySelector(".js_description");
        const selectColor = document.querySelector(".js_selected_color");
        if (selectColor) {
            selectColor.addEventListener('change', function() {
                if (selectColor.value == 6) {
                    description.classList.add('selected_color');
                } else {
                    description.classList.remove('selected_color');
                }
            })
        }
        if (selectColor) {
            if (selectColor.value == 6) {
                description.classList.add('selected_color');
            } else {
                description.classList.remove('selected_color');
            }
        }
    </script>
@endsection
