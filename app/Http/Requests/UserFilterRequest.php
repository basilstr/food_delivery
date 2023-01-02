<?php

namespace App\Http\Requests;

use App\Models\Permanent\Role;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFilterRequest extends FormRequest
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
            'provider_id' => 'nullable|numeric',
            'city_id' => 'nullable|numeric',
            'name' => 'nullable|string',
            'status' => 'nullable|numeric',
            'role' => 'nullable|string',
        ];
    }
}
