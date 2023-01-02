<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\LogAction;
use App\Models\Permanent\Cities;
use App\Models\Permanent\TypeDelivery;
use App\Models\Permanent\TypePay;
use App\Models\Permanent\Week;
use App\Models\Provider;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Gate;


class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $providers = Provider::whereNotIn('status', [Provider::DELETED])->filterCity()->paginate(100);
        return view('provider.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $cities = Cities::getList('name');
        $week = Week::getList('short');
        $typesPay = TypePay::getList();
        $typesDelivery = TypeDelivery::getList();
        return view('provider.create', compact('cities', 'week', 'typesPay', 'typesDelivery'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProviderRequest $request)
    {
        $data = $request->validated();

        $provider = new Provider();
        $provider->saveModel($data);

        return redirect()->route('provider.show', $provider->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Provider $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Provider $provider)
    {
        if (! Gate::allows('update-provider', $provider)) {
            return redirect()->route('provider.index');
        }
        $typesPay = TypePay::getListOnlyParam($provider->type_pay);
        $typesDelivery = TypeDelivery::getListOnlyParam($provider->type_delivery);
        $week = Week::getList('full');
        return view('provider.show', compact('provider', 'typesPay', 'typesDelivery', 'week'));
    }

    public function history(Provider $provider)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $provider->id)->where('model', Provider::class)->orderByDesc('id')->paginate(10);
            $title = 'Заклад: '. $provider->name;
            $route = route('provider.index');
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('provider.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProviderRequest $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Provider $provider)
    {
        if (Gate::denies('update-provider', $provider)) {
            abort(403);
        }
        $cities = Cities::getList('name');
        $week = Week::getList('short');
        $typesPay = TypePay::getList();
        $typesDelivery = TypeDelivery::getList();
        return view('provider.edit', compact('provider', 'cities', 'week', 'typesPay', 'typesDelivery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProviderRequest $request, $id)
    {
        $data = $request->validated();
        $provider= Provider::findOrFail($id);
        if ( Gate::allows('update-provider', $provider)) {
            $provider->saveModel($data);
        }
        return redirect()->route('provider.show', $provider->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Provider $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Provider $provider)
    {
        if (Gate::allows('update-provider', $provider)) {
            $provider->status = Provider::DELETED;
            $provider->saveOrFail();
        }
        return redirect()->route('provider.index');
    }
}
