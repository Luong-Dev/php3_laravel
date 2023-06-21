@extends('admin.layouts.master')
@section('title', 'Thêm mới tài khoản')
@section('content')
    <x-guest-layout>
        <form method="POST" action="/admin/accounts/create">
            @csrf
            <!-- Fisrt Name -->
            <div>
                <x-input-label for="first_name" :value="__('Tên')" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"
                    required autofocus autocomplete="firstname" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Lasrt Name -->
            <div>
                <x-input-label for="last_name" :value="__('Họ')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                    required autofocus autocomplete="lastname" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- phone_number --}}
            <div>
                <x-input-label for="phone_number" :value="__('Số điện thoại')" />
                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"
                    :value="old('phone_number')" autofocus autocomplete="phonenumber" />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mật khẩu')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- role --}}
            <div class="mt-4">
                <x-input-label for="role" :value="__('Phân quyền')" />
                <select name="role" id="role" class="block mt-1 w-full" autocomplete="role">
                    {{-- <option value="">Chọn vai trò</option> --}}
                    @if (auth()->user()->role == 1)
                        <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Admin</option>
                    @endif
                    <option selected value="5" {{ old('role') == 5 ? 'selected' : '' }}>User</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            {{-- birth of date --}}
            <div class="mt-4">
                <x-input-label for="birth_of_date" :value="__('Ngày sinh')" />
                <x-text-input id="birth_of_date" class="block mt-1 w-full" type="date" name="birth_of_date"
                    :value="old('birth_of_date')" autocomplete="birthofdate" />
                <x-input-error :messages="$errors->get('birth_of_date')" class="mt-2" />
            </div>

            {{-- gender --}}
            <div class="mt-4">
                <x-input-label for="gender" :value="__('Giới tính')" />
                <select name="gender" id="gender" class="block mt-1 w-full" autocomplete="gender">
                    <option value="">Chọn giới tính</option>
                    <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Nam</option>
                    <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Nữ</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <!-- Address -->
            <div>
                <x-input-label for="address" :value="__('Địa chỉ')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                    autofocus autocomplete="address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <input class="" type="submit" value="Thêm mới">
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="/admin/accounts">Quay lại danh sách</a>
            </div>
        </form>
    </x-guest-layout>
@endsection
