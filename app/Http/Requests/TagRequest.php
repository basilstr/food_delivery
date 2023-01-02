<?php

namespace App\Http\Requests;

use App\Models\Permanent\Role;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
            'name' =>  ['required', Rule::unique('tags')->ignore($this->tag)],
            'parent_id' => 'nullable|numeric',
            'description' => 'nullable|string',
            'status' => 'numeric',
            'photo' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('Такий тег вже існує'),
            'name.required' => __('Введіть назву тегу'),
        ];
    }
}
