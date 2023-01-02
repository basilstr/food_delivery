<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Http\Requests\ProviderRequest;
use App\Models\Foods\Food;
use App\Models\LogAction;
use App\Models\Permanent\TypeFood;
use App\Models\Permanent\Week;
use App\Models\Provider;
use App\Models\Tag;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Gate;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Provider $provider)
    {
        if ( Gate::denies('update-provider', $provider)) {
            abort(403);
        }
        $foods = Food::where('provider_id', $provider->id)
            ->whereNotIn('status', [Food::DELETED])
            ->paginate(100);
        return view('food.index', compact('foods', 'provider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Provider $provider)
    {
        $typeFoods = TypeFood::getList();
        $tags = Tag::all();
        $statuses = Food::$listStatus;
        return view('food.create', compact('provider', 'tags', 'typeFoods', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FoodRequest $request)
    {
        $data = $request->validated();
        $food = new Food();
        $food->saveModel($data);
        return redirect()->route('food.show', $food->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Provider $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Food $food)
    {
        if ( Gate::denies('update-food', $food)) {
            abort(403);
        }
        $typeFoods = TypeFood::getList();
        $week = Week::getList('short');
        return view('food.show', compact('food', 'typeFoods', 'week'));
    }

    public function history(Food $food)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $food->id)->where('model', Food::class)->orderByDesc('id')->paginate(10);
            $title = 'Страва: '. $food->name;
            $route = route('food.index', $food->provider_id);
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('food.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProviderRequest $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Food $food)
    {
        if ( Gate::denies('update-food', $food)) {
            abort(403);
        }
        $typeFoods = TypeFood::getList();
        $tags = Tag::all();
        $isTags = $food->tags->pluck('id')->toArray();
        $week = Week::getList('short');
        return view('food.edit', compact('food', 'typeFoods', 'tags', 'isTags','week'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FoodRequest $request, $id)
    {
        $data = $request->validated();
        $food = Food::findOrFail($id);
        if (Gate::allows('update-food', $food)) {
            $food->tags()->detach();
            if (isset($data['tags'])) {
                foreach ($data['tags'] as $tag) {
                    $food->tags()->attach(intval($tag));
                }
            }
            $food->saveModel($data);
        }
        return redirect()->route('food.show', $food->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Food $food
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Food $food)
    {
        if (Gate::allows('update-food', $food)) {
            $food->status = Food::DELETED;
            $food->saveOrFail();
        }
        return redirect()->route('food.index', $food->provider_id);
    }
}
