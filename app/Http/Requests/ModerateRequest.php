<?php

namespace App\Http\Requests;

use App\Models\Foods\Food;
use App\Models\Permanent\TypeFood;
use App\Models\Permanent\TypeFoodIngredient;
use App\Rules\Schedule;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModerateRequest extends FormRequest
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
            'provider' => 'nullable|array',
            'food' => 'nullable|array',
            'ingredient' => 'nullable|array',
            'tag' => 'nullable|array',
        ];
    }
}
