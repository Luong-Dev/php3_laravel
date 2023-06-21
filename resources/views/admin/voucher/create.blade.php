@extends('admin.layouts.master')
@section('title', 'Thêm mới voucher')
@section('content')
    <div class="container mt-5">
        <h1 class="text-success fs-1 fw-bold mb-3">Thêm mới voucher</h1>

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="alert alert-warning" role="alert">
            Nếu nhập cả 2 trường giảm phần trăm và giảm tiền thì có nghĩa là giảm số phần trăm đã nhập và tối đa bao nhiêu tiền đã nhập!
        </div>
        <form class="form-control" method="POST" enctype="multipart/form-data" action="/admin/vouchers/store">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleName" class="form-label">Tên voucher</label>
                        <input name="name" type="text" class="form-control" id="exampleName"
                            value="{{ old('name') }}">
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
                            value="{{ old('code') }}">
                        <p class="text-danger">
                            @error('code')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleDescription" class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" id="exampleDescription" cols="30" rows="1">{{ old('description') }}</textarea>
                <p class="text-danger">
                    @error('description')
                        {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="examplePercentValue" class="form-label">Giảm phần trăm</label>
                        <input name="percent_value" type="number" class="form-control" id="examplePercentValue"
                            value="{{ old('percent_value') }}">
                        <p class="text-danger">
                            @error('percent_value')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="examplemoney_value" class="form-label">Giảm tiền</label>
                        <input name="money_value" type="number" class="form-control" id="examplemoney_value"
                            value="{{ old('money_value') }}">
                        <p class="text-danger">
                            @error('money_value')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="exampleorder_value_total" class="form-label">Đơn hàng tối thiểu</label>
                        <input name="order_value_total" type="number" class="form-control" id="exampleorder_value_total"
                            value="{{ old('order_value_total') }}">
                        <p class="text-danger">
                            @error('order_value_total')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="examplequantity" class="form-label">Số lượng</label>
                        <input name="quantity" type="number" class="form-control" id="examplequantity"
                            value="{{ old('quantity') }}">
                        <p class="text-danger">
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="examplestart_time" class="form-label">Thời gian bắt đầu</label>
                        <input name="start_time" type="datetime-local" class="form-control" id="examplestart_time"
                            value="{{ old('start_time') }}">
                        <p class="text-danger">
                            @error('start_time')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="exampleend_time" class="form-label">Thời gian kết thúc</label>
                        <input name="end_time" type="datetime-local" class="form-control" id="exampleend_time"
                            value="{{ old('end_time') }}">
                        <p class="text-danger">
                            @error('end_time')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Thêm mới</button>
            <a class="btn btn-outline-danger" href="/admin/vouchers">Quay lại danh sách</a>
        </form>
    </div>
@endsection
