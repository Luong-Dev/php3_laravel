@extends('admin.layouts.master')
@section('title', 'Danh sách Banner')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH BANNER</h1>
            </div>
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
        </div>
        @if (isset($banner))
            <form method="post" action="/admin/banners/updateLevel">
                @csrf
                <table class="mt-3 table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Level</th>
                            <th scope="col" style="width: 35%">Mô tả dự phòng</th>
                            <th scope="col">Cập nhập Level</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banner as $key => $banner)
                            <tr>
                                <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}
                                </th>
                                <td>
                                    <img style="width: 268px ; height:66px"
                                        src="/{{ isset($banner->image_url) ? $banner->image_url : '' }}" alt="Link hỏng">
                                </td>
                                <td>{{ isset($banner->level) ? $banner->level : '' }}</td>
                                <td>{{ isset($banner->image_alt) ? $banner->image_alt : 'Không có' }}</td>
                                <td>
                                    <select class="form-select w-70" name="{{ $banner->id }}"
                                        aria-label="Default select example">
                                        @for ($i = 0; $i < $levels; $i++)
                                            <option {{ $banner->level == $i + 1 ? 'selected' : '' }}
                                                value="{{ $i + 1 }}">
                                                {{ $i + 1 }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <a href="/admin/banners/edit/{{ isset($banner->id) ? $banner->id : '' }}"
                                        class="btn btn-outline-success btn-sm">Sửa</a>
                                    <a href="/admin/banners/deleted-force/{{ isset($banner->id) ? $banner->id : '' }}"
                                        onclick="return confirm('Bạn có muốn xóa không')"
                                        class="btn btn-outline-danger btn-sm">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-start">
                    <a href="/admin/banners/create" class="btn btn-primary">Thêm mới ảnh</a>
                    <button type="submit" class="btn btn-outline-success">Cập nhật Level</button>
                    {{-- <a href="/admin/banners/deleted-list" class="btn btn-primary">Xem danh sách đã xóa</a> --}}
                </div>
            </form>
        @endif
    </div>
@endsection
