@extends('admin.layouts.master')
@section('title', 'Danh sách Voucher')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-success mt-5 fs-2 fw-bold">DANH SÁCH VOUCHER</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/vouchers/create" class="btn mt-5 btn-primary">Thêm mới VOUCHER</a>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger mt-3" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success mt-3" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (isset($vouchers))
            <table class="mt-5 table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col" style="width: 10%">Tên Voucher</th>
                        <th scope="col" style="width: 10%">Mã voucher</th>
                        <th scope="col" style="width: 10%">Mô tả</th>
                        <th scope="col">Giảm giá (%)</th>
                        <th scope="col">Giảm giá (tiền)</th>
                        <th scope="col">Đơn hàng tối thiểu</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đã sử dụng</th>
                        <th scope="col" style="width: 7%">Ngày bắt đầu</th>
                        <th scope="col" style="width: 7%">Ngày kết thúc</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $key => $voucher)
                        <tr>
                            <th scope="row">{{ isset($numberPage) ? ($numberPage - 1) * 10 + $key + 1 : $key + 1 }}</th>
                            <td class="">{{ isset($voucher->name) ? $voucher->name : '' }}</td>
                            <td class="text-primary">{{ isset($voucher->code) ? $voucher->code : '' }}</td>
                            <td class="">{{ isset($voucher->description) ? $voucher->description : '' }}</td>
                            <td class="">{{ isset($voucher->percent_value) ? $voucher->percent_value . ' %' : '' }}
                            </td>
                            <td class="">{{ isset($voucher->money_value) ? $voucher->money_value . ' Vnđ' : '' }}</td>
                            <td class="">
                                {{ isset($voucher->order_value_total) ? $voucher->order_value_total . ' Vnđ' : '' }}
                            </td>
                            <td class="">{{ isset($voucher->quantity) ? $voucher->quantity : '' }}</td>
                            <td class="">{{ isset($voucher->quantity_used) ? $voucher->quantity_used : '' }}</td>
                            <td class="">{{ isset($voucher->start_time) ? $voucher->start_time : '' }}</td>
                            <td class="">{{ isset($voucher->end_time) ? $voucher->end_time : '' }}</td>
                            <td>
                                <a href="/admin/vouchers/edit/{{ isset($voucher->id) ? $voucher->id : '' }}"
                                    class="btn btn-outline-success btn-sm">Sửa</a>
                                <a href="/admin/vouchers/delete/{{ isset($voucher->id) ? $voucher->id : '' }}"
                                    onclick="return confirm('Bạn có muốn xóa không')"
                                    class="btn btn-outline-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $vouchers->links() }}
        @endif
        {{-- <div class="text-center">
            <a href="/admin/vouchers/deleted-list" class="btn mt-5 btn-primary">Xem danh sách đã xóa</a>
        </div> --}}
    </div>
@endsection
