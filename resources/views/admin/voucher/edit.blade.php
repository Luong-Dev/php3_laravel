@extends('admin.layouts.master')
@section('title', 'Sửa Danh Mục')
@section('content')
    <div class="container mt-5">
        <h2 class="text-success fs-2 fw-bold mt-2 mb-5">
            {{ isset($voucher->name) ? "Sửa Voucher: $voucher->name" : 'Không tồn tại Voucher' }} </h2>
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
        @if ($checkVoucher)
            <div class="alert alert-warning mt-3" role="alert">
                Voucher này đã có người sử dụng, chỉ được cập nhật một số thông tin cần thiết!
            </div>
        @endif
        @if (isset($voucher))
            <form class="form-control" method="POST" enctype="multipart/form-data"
                action="/admin/vouchers/update/{{ isset($voucher->id) ? $voucher->id : '' }}">
                @csrf
                <div {{ $checkVoucher ? 'hidden' : '' }} class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleName" class="form-label">Tên voucher</label>
                            <input name="name" type="text" class="form-control" id="exampleName"
                                value="{{ old('name') != '' ? old('name') : $voucher->name }}">
                            <p class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleCode" class="form-label">Mã voucher</label>
                            <input name="code" type="text" class="form-control" id="exampleCode"
                                value="{{ old('code') != '' ? old('code') : $voucher->code }}">
                            <p class="text-danger">
                                @error('code')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                    </div>
                </div>
                <div {{ !$checkVoucher ? 'hidden' : '' }} class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Tên voucher</label>
                            <input name="" type="text" class="form-control" id=""
                                value="{{ $voucher->name }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Mã voucher</label>
                            <input name="" type="text" class="form-control" id=""
                                value="{{ $voucher->code }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleDescription" class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" id="exampleDescription" cols="30" rows="1">{{ old('description') != '' ? old('description') : $voucher->description }}</textarea>
                    <p class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="row">
                    <div {{ $checkVoucher ? 'hidden' : '' }} class="col-md-6">
                        <div class="mb-3">
                            <label for="examplePercentValue" class="form-label">Giảm phần trăm</label>
                            <input name="percent_value" type="number" class="form-control" id="examplePercentValue"
                                value="{{ old('percent_value') != '' ? old('percent_value') : $voucher->percent_value }}">
                            <p class="text-danger">
                                @error('percent_value')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="examplemoney_value" class="form-label">Giảm tiền</label>
                            <input name="money_value" type="number" class="form-control" id="examplemoney_value"
                                value="{{ old('money_value') != '' ? old('money_value') : $voucher->money_value }}">
                            <p class="text-danger">
                                @error('money_value')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="exampleorder_value_total" class="form-label">Đơn
                                hàng tối thiểu</label>
                            <input name="order_value_total" type="number" class="form-control"
                                id="exampleorder_value_total"
                                value="{{ old('order_value_total') != '' ? old('order_value_total') : $voucher->order_value_total }}">
                            <p class="text-danger">
                                @error('order_value_total')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                    </div>
                    <div {{ !$checkVoucher ? 'hidden' : '' }} class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Giảm phần trăm</label>
                            <input name="" type="number" class="form-control" id="" disabled
                                value="{{ $voucher->percent_value }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Giảm tiền</label>
                            <input name="" type="number" class="form-control" id="" disabled
                                value="{{ $voucher->money_value }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Đơn
                                hàng tối thiểu</label>
                            <input name="" type="number" class="form-control" id="" disabled
                                value="{{ $voucher->order_value_total }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="examplequantity" class="form-label">Số lượng</label>
                            <input name="quantity" type="number" class="form-control" id="examplequantity"
                                value="{{ old('quantity') != '' ? old('quantity') : $voucher->quantity }}">
                            <p class="text-danger">
                                @error('quantity')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="examplestart_time" class="form-label">Thời gian bắt đầu</label>
                            <input name="start_time" type="datetime-local" class="form-control" id="examplestart_time"
                                value="{{ old('start_time') != '' ? old('start_time') : $voucher->start_time }}">
                            <p class="text-danger">
                                @error('start_time')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="exampleend_time" class="form-label">Thời gian kết thúc</label>
                            <input name="end_time" type="datetime-local" class="form-control" id="exampleend_time"
                                value="{{ old('end_time') != '' ? old('end_time') : $voucher->end_time }}">
                            <p class="text-danger">
                                @error('end_time')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Xác nhận CẬP NHẬT!')">Cập
                    nhật</button>
            </form>
        @endif
        <a class="btn btn-outline-danger mt-3" href="/admin/vouchers">Quay lại danh sách</a>
    </div>
@endsection
