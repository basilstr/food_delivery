<?php

namespace App\Http\Requests;

use App\Models\Permanent\Cities;
use App\Models\Permanent\Role;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => preg_replace("/[^0-9]/", '', $this->phone)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|string|size:12',
            'name' => 'required|string',
            'city_id' => Rule::in(Cities::getListKey()),
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'in_black_list' => 'boolean',
            'status' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => __('Введіть номер телефону'),
            'phone.numeric' => __('Допускаються тільки цифри'),
            'phone.size' => __('Формат 380671234567 - 12 цифр'),
            'name.required' => __('Введіть ім\'я'),
        ];
    }
}
