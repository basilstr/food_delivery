<?php

namespace App\Http\Requests;

use App\Models\Foods\Food;
use App\Models\Permanent\TypeFood;
use App\Models\Permanent\TypeFoodIngredient;
use App\Rules\Schedule;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FoodRequest extends FormRequest
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
            'provider_id' => 'required|numeric',
            'name' =>  'required',
            'photo' => 'nullable|image',
            'type_food' => Rule::in(TypeFood::getListKey()),
            'food_ingredient' => Rule::in(TypeFoodIngredient::getListKey()),
            'description' => 'nullable|string',
            'description_design' =>  ['nullable', 'array'],
            'amount' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'status' => Rule::in(Food::getListStatusKey()),
            'work_schedule' => ['nullable', 'array', new Schedule],
            'promote_status' => 'required|numeric',
            'promote_description' => 'nullable|string',
            'promote_schedule' =>  ['nullable', 'array', new Schedule],
            'sort' => 'nullable|numeric',
            'tags' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('Така назва вже існує'),
            'name.required' => __('Введіть назву'),
            'address.required' => __('Введіть адресу'),
            'promote_status.required' => __('Необхідно вказати статус'),
        ];
    }
}
