<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Models\Foods\Food;
use App\Models\Foods\Ingredient;
use App\Models\LogAction;
use App\Models\Permanent\TypeFoodIngredient;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;


class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Food $food)
    {
        if (Gate::denies('update-food', $food)) {
            abort(403);
        }
        $ingredients = Ingredient::where('parent_food_id', $food->id)
            ->whereNotIn('status', [Ingredient::DELETED])
            ->orderBy('sort')
            ->get();
        return view('ingredient.index', compact('ingredients', 'food'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request  $request)
    {
        $id = $request->input('id');
        $ingredients = Food::where('provider_id', $id)
            ->whereNotIn('status', [Food::DELETED])
            ->whereIn('food_ingredient', [TypeFoodIngredient::INGREDIENT, TypeFoodIngredient::FOOD_INGREDIENT])
            ->orderBy('sort')
            ->get();
        return view('ingredient.list', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request  $request)
    {
        $data = $request->all();
        $food = Food::find($data['id']);
        if (Gate::denies('update-food', $food)) {
            abort(403);
        }
        if($food){
            foreach ($data['list'] as $item){
                Ingredient::create([
                    'parent_food_id' => $food->id,
                    'ingredient_food_id' => $item,
                ]);
            }
            return response()->json(['success' => 'ok']);
        }
        return response()->json(['success' => 'fail', 'msg' => 'Помилка збереження']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data = $data['ing']; // перелік інгредієнтів (масив параметрів з значеннями)
        // екземпляр класу для отримання списку правил та повідомлень про помилки
        $ingredientRequest = new IngredientRequest();
        $validators = []; // масив валідаторів з помилками в даних
        foreach ($data as $key => $item){
            $validator = Validator::make($item, $ingredientRequest->rules(), $ingredientRequest->messages());
            if ($validator->fails()) {
                $validators[$key] = $validator;
            }else{
                $model = Ingredient::findOrFail($item['id']);
                if (Gate::allows('update-ingredient', $model)) {
                    $model->saveModel( $validator->validated());
                }
            }
        }

        // формування редіректу зі всіма помилками для всіх інгредієнтів страви
        $redirect = redirect()->route('ingredient.index',  $id);
        foreach ($validators as $key => $validator){
                $redirect = $redirect->withErrors($validator, 'block_'.$key);
        }

        if(!empty($validators)) $redirect->withInput();

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Food $food
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Ingredient $ingredient)
    {
        if (Gate::allows('update-ingredient', $ingredient)) {
            $ingredient->status = Ingredient::DELETED;
            $ingredient->saveOrFail();
        }
        return redirect()->route('ingredient.index', $ingredient->parent_food_id);
    }

    public function history(Ingredient $ingredient)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $ingredient->id)->where('model', Ingredient::class)->orderByDesc('id')->paginate(10);
            $title = 'Інгредієнт: '. $ingredient->parentIngredient->name;
            $route = route('ingredient.index', $ingredient->parent_food_id);
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('ingredient.index', $ingredient->parent_food_id);
    }
}
