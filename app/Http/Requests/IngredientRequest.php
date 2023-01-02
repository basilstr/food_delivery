<?php

namespace App\Http\Requests;

use App\Models\Foods\Food;
use App\Models\Foods\Ingredient;
use App\Models\Permanent\TypeFood;
use App\Rules\Schedule;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IngredientRequest extends FormRequest
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
            'id' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'amount' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'price_package' => 'nullable|numeric',
            'can_change' => 'required|numeric',
            'type_change' => 'required|numeric',
            'type_food' => Rule::in(TypeFood::getListKey()),
            'status' => Rule::in(Ingredient::getListStatusKey()),
            'work_schedule' => ['nullable', 'array', new Schedule],
            'promote_status' => Rule::in(Ingredient::getListStatusKey()),
            'promote_description' => 'nullable|string',
            'promote_schedule' =>  ['nullable', 'array', new Schedule],
            'sort' =>  'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'weight.numeric' => __('Тільки цифри'),
            'amount.numeric' => __('Тільки цифри'),
            'address.required' => __('Введіть адресу'),
            'type_change.required' => __('Введіть тип'),
        ];
    }
}
