<?php

namespace App\Http\Requests;

use App\Models\Permanent\Cities;
use App\Models\Permanent\Role;
use App\Rules\Schedule;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProviderRequest extends FormRequest
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
            'name' =>  ['required', Rule::unique('providers')->ignore($this->provider)],
            'aliases' =>  'nullable|string',
            'lat' => 'nullable|string',
            'lon' => 'nullable|string',
            'city_id' => Rule::in(Cities::getListKey()),
            'logo' => 'nullable|image',
            'address' => 'required',
            'status' => 'required|numeric',
            'sort' => 'nullable|numeric',
            'work_schedule' => ['required', 'array', new Schedule],
            'type_pay' => 'nullable|array',
            'type_delivery' => 'nullable|array',
            'about' => 'nullable|string',
            'description' => 'nullable|string',
            'min_price' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('Така назва вже існує'),
            'name.required' => __('Введіть назву'),
            'address.required' => __('Введіть адресу'),
            'work_schedule.required' => __('Введіть графік роботи'),
            'status.required' => __('Статус не може бути пустий'),
        ];
    }
}
