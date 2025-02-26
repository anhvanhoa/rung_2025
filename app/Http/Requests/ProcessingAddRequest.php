<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessingAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'integer', 'exists:business_types,id'],
            'business_form' => ['required', 'array', 'min:1'],
            'business_form.*' => ['integer', 'exists:business_forms,id'], // Mỗi phần tử phải là số và tồn tại trong bảng business_forms

            'business_registration' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15'],
            'district' => ['required', "exists:districts,code"],
            'commune' => ['required', "exists:communes,code"],
            'source' => ['required', 'array', 'min:1'],
            'source.*' => ['integer', 'exists:sources,id'], // Mỗi phần tử phải là số và tồn tại trong bảng sources
            'workers_deg' => ['nullable', 'integer', 'min:0'],
            'workers_no_qual' => ['nullable', 'integer', 'min:0'],
            'average_consumption' => ['required', 'numeric', 'min:0'],
            'primary' => ['required', 'array', 'min:1'],
            'primary.*' => ['integer', 'exists:breeds,id'], // Mỗi phần tử phải là số và tồn tại trong bảng breeds
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
        ];
    }

    public function messages()
    {
        return [
            'unit.required' => 'Trường đơn vị là bắt buộc.',
            'unit.string' => 'Trường đơn vị phải là chuỗi ký tự.',
            'unit.max' => 'Trường đơn vị không được vượt quá :max ký tự.',

            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',

            'business_type.required' => 'Loại hình kinh doanh là bắt buộc.',
            'business_type.integer' => 'Loại hình kinh doanh phải là số nguyên.',
            'business_type.exists' => 'Loại hình kinh doanh không hợp lệ.',

            'business_form.min' => 'Hình thức kinh doanh là bắt buộc.',
            'business_form.*.exists' => 'Hình thức kinh doanh không hợp lệ',

            'business_registration.string' => 'Mã đăng ký kinh doanh phải là chuỗi ký tự.',
            'business_registration.max' => 'Mã đăng ký không được vượt quá :max ký tự.',

            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',

            'district.required' => 'Trường quận/huyện là bắt buộc.',
            'district.string' => 'Trường quận/huyện phải là chuỗi ký tự.',
            'district.max' => 'Quận/huyện không được vượt quá :max ký tự.',

            'commune.required' => 'Trường xã/phường là bắt buộc.',
            'commune.string' => 'Trường xã/phường phải là chuỗi ký tự.',
            'commune.max' => 'Xã/phường không được vượt quá :max ký tự.',

            'source.required' => 'Bạn phải chọn ít nhất một nguồn.',
            'source.array' => 'Nguồn phải là một mảng dữ liệu.',
            'source.*.integer' => 'Mỗi nguồn phải là một số nguyên.',
            'source.*.exists' => 'Nguồn không hợp lệ.',

            'workers_deg.integer' => 'Số lượng công nhân có bằng cấp phải là số nguyên.',
            'workers_deg.min' => 'Số lượng công nhân có bằng cấp không được nhỏ hơn :min.',

            'workers_no_qual.integer' => 'Số lượng công nhân không có bằng cấp phải là số nguyên.',
            'workers_no_qual.min' => 'Số lượng công nhân không có bằng cấp không được nhỏ hơn :min.',

            'average_consumption.required' => 'Mức tiêu thụ trung bình là bắt buộc.',
            'average_consumption.numeric' => 'Mức tiêu thụ trung bình phải là số.',
            'average_consumption.min' => 'Mức tiêu thụ trung bình không được nhỏ hơn :min.',

            'primary.required' => 'Bạn phải chọn ít nhất một ngành chính.',
            'primary.array' => 'Ngành chính phải là một mảng dữ liệu.',
            'primary.*.integer' => 'Mỗi ngành chính phải là số nguyên.',
            'primary.*.exists' => 'Ngành chính không hợp lệ.',

            'longitude.numeric' => 'Kinh độ phải là số.',
            'longitude.between' => 'Kinh độ phải nằm trong khoảng -180 đến 180.',

            'latitude.numeric' => 'Vĩ độ phải là số.',
            'latitude.between' => 'Vĩ độ phải nằm trong khoảng -90 đến 90.',
        ];
    }
}
