@extends('admin.layouts.master')
@section('title', 'Danh sách tài khoản')
@section('content')
    <div class="container">
        @isset($messenger)
            <h1 class="text-success mt-5 mb-4">{{ $messenger }}</h1>
            <a href="/admin/employees/1" class="btn btn-outline-primary">Quay lại</a>
        @endisset
        @if (isset($users))
            <div class="row">
                <div class="col-md-6">
                    <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH TÀI KHOẢN</h1>
                </div>
                <div class="col-md-6 text-right">
                    <a href="/admin/accounts/create" class="btn mt-5 btn-primary">Thêm mới tài khoản</a>
                </div>
            </div>
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        {{-- <th scope="col">Mã nv</th> --}}
                        <th scope="col">Tên nhân viên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ngày Sinh</th>
                        <th scope="col">Giới Tính</th>
                        <th scope="col">Vai Trò</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            {{-- <td>{{ isset($user->id) ? $user->id : '' }}</td> --}}
                            <td class="text-info">
                                {{ isset($user->last_name) ? $user->last_name : '' }}
                                {{ isset($user->first_name) ? $user->first_name : '' }} </td>
                            <td>{{ isset($user->phone_number) ? $user->phone_number : '' }}</td>
                            <td class="text-primary">{{ isset($user->email) ? $user->email : '' }}</td>
                            <td>{{ isset($user->birth_of_date) ? $user->birth_of_date : '' }}</td>
                            <td>{{ isset($user->gender) ? ($user->gender == 1 ? 'Nam' : 'nữ') : '' }}</td>
                            <td>{{ isset($user->role) ? ($user->role == 1 ? 'Super Admin' : ($user->role == 2 ? 'Admin' : 'User')) : '' }}
                            </td>
                            <td>{{ isset($user->status) ? ($user->status == 1 ? 'Hoạt Động' : 'Bị Khóa') : '' }}</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">Chi tiết</a>
                                <a href="" class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="" class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        @endif
    </div>
@endsection
