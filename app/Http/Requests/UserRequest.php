<?php

namespace App\Http\Requests;

use App\Models\Permanent\Role;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => Rule::unique('users')->ignore($this->user),
            'password' => 'nullable|string',
            'provider_id' => 'nullable|numeric',
            'city_id' => 'nullable|numeric',
            'name' => 'required',
            'status' => 'numeric',
            'role' => Rule::in(Role::getListKey()),
            'avatar' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'login.unique' => __('Такий логін вже існує'),
            'name.required' => __('Введіть ім\'я'),
        ];
    }
}
