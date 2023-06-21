<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class NhapProductAttribute extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // $rules = [
        //     'productAttributeCategory_id' => ['required', 'integer'],
        //     'name' => ['required', 'string', 'max:60']
        // ];

        // if ($this->input('description_value') != '') {
        //     $rules['description_value'] = ['required', 'string', 'max:30'];
        // } else {
        //     $rules['description_value'] = ['nullable', 'string', 'max:30'];
        // }

        // return $rules;

        return [
            'productAttributeCategory_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:60'],
            'description_value' => ['nullable', 'string', 'max:30']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => "Bạn Chưa Nhập Name",
            'productAttributeCategory_id.required' => "bạn chưa chọn loại thuộc tính sản phẩm",
            'productAttributeCategory_id.integer' => "Sai kiểu dữ liệu vì chưa chọn loại thuộc tính",
            'description_value.required' => "Phải nhập mã màu sắc"
        ];
    }
}
