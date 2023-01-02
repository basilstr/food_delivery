<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModerateRequest;
use App\Models\Foods\Food;
use App\Models\Foods\Ingredient;
use App\Models\Provider;
use App\Models\Tag;



class ModerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $providers = Provider::moderation()->get();
        $foods = Food::moderation()->get();
        $ingredients = Ingredient::moderation()->get();
        $tags = Tag::moderation()->get();
        return view('moderation.index', compact('providers', 'foods', 'ingredients', 'tags'));
    }

    public function update(ModerateRequest $request)
    {
        $data = $request->validated();
        if(isset($data['provider'])) Provider::setActiveStatus($data['provider']);
        if(isset($data['food'])) Food::setActiveStatus($data['food']);
        if(isset($data['ingredient'])) Ingredient::setActiveStatus($data['ingredient']);
        if(isset($data['tag'])) Tag::setActiveStatus($data['tag']);
        return redirect()->route('moderation.index');
    }

}
