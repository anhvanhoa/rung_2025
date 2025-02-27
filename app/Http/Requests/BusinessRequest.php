<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép request này chạy
    }

    public function rules()
    {
        return [
            '_token' => 'required|string',
            'unit' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'business_type' => 'required|integer',
            'business_form' => 'required|array|min:1',
            'business_form.*' => 'integer',
            'business_registration' => 'nullable|string|max:50',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'district' => 'required|string|max:10',
            'commune' => 'required|string|max:10',
            'supplier' => 'required|array|min:1',
            'supplier.*' => 'integer|exists:suppliers,id',
            'female_workers' => 'nullable|integer|min:0',
            'male_workers' => 'nullable|integer|min:0',
            'sell_trees_qty' => 'required|integer|min:0',
            'primary' => 'required|array|min:1',
            'primary.*' => 'integer|exists:breeds,id',
            'irrigation' => 'required|integer|exists:technologies,id',
            'nursery' => 'required|array|min:1',
            'nursery.*' => 'integer|exists:technologies,id',
            'annual_revenue' => 'required|numeric|min:0',
            'acreage' => 'required|numeric|min:0',
            'irrigation_type' => 'required|string|in:fixed,dynamic',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            '_token.required' => 'Thiếu mã token xác thực.',
            'unit.required' => 'Đơn vị không được để trống.',
            'unit.string' => 'Đơn vị phải là một chuỗi ký tự.',
            'unit.max' => 'Đơn vị không được vượt quá 255 ký tự.',

            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'business_type.required' => 'Loại hình kinh doanh không được để trống.',
            'business_type.integer' => 'Loại hình kinh doanh phải là số nguyên.',

            'business_form.required' => 'Loại hình kinh doanh không được để trống.',
            'business_form.array' => 'Loại hình kinh doanh phải là một danh sách.',
            'business_form.min' => 'Phải chọn ít nhất một loại hình kinh doanh.',
            'business_form.*.integer' => 'Mỗi loại hình kinh doanh phải là số nguyên.',

            'business_registration.string' => 'Mã đăng ký kinh doanh phải là chuỗi.',
            'business_registration.max' => 'Mã đăng ký kinh doanh không được vượt quá 50 ký tự.',

            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số.',

            'district.required' => 'Quận/Huyện không được để trống.',
            'district.string' => 'Quận/Huyện phải là một chuỗi ký tự.',
            'district.max' => 'Quận/Huyện không được vượt quá 10 ký tự.',

            'commune.required' => 'Xã/Phường không được để trống.',
            'commune.string' => 'Xã/Phường phải là một chuỗi ký tự.',
            'commune.max' => 'Xã/Phường không được vượt quá 10 ký tự.',

            'supplier.required' => 'Nhà cung cấp không được để trống.',
            'supplier.array' => 'Nhà cung cấp phải là một danh sách.',
            'supplier.min' => 'Phải chọn ít nhất một nhà cung cấp.',
            'supplier.*.integer' => 'Mỗi nhà cung cấp phải là số nguyên.',
            'supplier.*.exists' => 'Nhà cung cấp không hợp lệ.',

            'female_workers.integer' => 'Số lượng lao động nữ phải là số nguyên.',
            'female_workers.min' => 'Số lượng lao động nữ không được nhỏ hơn 0.',

            'male_workers.integer' => 'Số lượng lao động nam phải là số nguyên.',
            'male_workers.min' => 'Số lượng lao động nam không được nhỏ hơn 0.',

            'sell_trees_qty.required' => 'Số lượng cây bán không được để trống.',
            'sell_trees_qty.integer' => 'Số lượng cây bán phải là số nguyên.',
            'sell_trees_qty.min' => 'Số lượng cây bán không được nhỏ hơn 0.',

            'primary.required' => 'Sản phẩm chính không được để trống.',
            'primary.array' => 'Sản phẩm chính phải là một danh sách.',
            'primary.min' => 'Phải chọn ít nhất một sản phẩm chính.',
            'primary.*.integer' => 'Mỗi sản phẩm chính phải là số nguyên.',
            'primary.*.exists' => 'Sản phẩm chính không hợp lệ.',

            'irrigation.required' => 'Công nghệ tưới tiêu không được để trống.',
            'irrigation.integer' => 'Công nghệ tưới tiêu phải là số nguyên.',
            'irrigation.exists' => 'Công nghệ tưới tiêu không hợp lệ.',

            'nursery.required' => 'Vườn ươm không được để trống.',
            'nursery.array' => 'Vườn ươm phải là một danh sách.',
            'nursery.min' => 'Phải chọn ít nhất một vườn ươm.',
            'nursery.*.integer' => 'Mỗi vườn ươm phải là số nguyên.',
            'nursery.*.exists' => 'Vườn ươm không hợp lệ.',

            'annual_revenue.required' => 'Doanh thu hàng năm không được để trống.',
            'annual_revenue.numeric' => 'Doanh thu hàng năm phải là số.',
            'annual_revenue.min' => 'Doanh thu hàng năm không được nhỏ hơn 0.',

            'acreage.required' => 'Diện tích không được để trống.',
            'acreage.numeric' => 'Diện tích phải là số.',
            'acreage.min' => 'Diện tích không được nhỏ hơn 0.',

            'irrigation_type.required' => 'Loại tưới tiêu không được để trống.',
            'irrigation_type.string' => 'Loại tưới tiêu phải là chuỗi.',
            'irrigation_type.in' => 'Loại tưới tiêu chỉ có thể là "fixed" hoặc "dynamic".',

            'longitude.numeric' => 'Kinh độ phải là số.',
            'latitude.numeric' => 'Vĩ độ phải là số.',
        ];
    }
}
