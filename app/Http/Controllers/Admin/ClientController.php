<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\ClientFilter;
use App\Http\Requests\ClientFilterRequest;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\LogAction;
use App\Models\Permanent\Cities;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(ClientFilterRequest $request)
    {
        $cities = Cities::getList('name');
        $data = $request->validated();
        $filter = app()->make(ClientFilter::class, ['queryParams' => array_filter($data)]);
        $clients = Client::filter($filter)->filterCity()->whereIn('status', [Client::ACTIVE, Client::DISACTIVE])->paginate(100);
        return view('client.index', compact('clients',  'cities',  'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $cities = Cities::getList('name');
        $blackListArr = [ 0=>'в білому списку', 1=>'в чорному списку'];
        $statuses = Client::$listStatus;
        return view('client.create', compact( 'statuses', 'cities', 'blackListArr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        $client = new Client();
        $client->saveModel( $data);

        return redirect()->route('client.show', $client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Client $client)
    {
        if($client->status == Client::DELETED){
            return redirect()->route('client.index');
        }
        if (Gate::denies('update-client', $client)) {
            abort(403);
        }
        $cities = Cities::getList('name');
        return view('client.show', compact('client', 'cities'));
    }

    public function history(Client $client)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $client->id)->where('model', Client::class)->orderByDesc('id')->paginate(10);
            $title = 'Клієнт: '. $client->name;
            $route = route('client.index');
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('client.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Client $client)
    {
        if($client->status == Client::DELETED){
            return redirect()->route('client.index');
        }

        if (Gate::denies('update-client', $client)) {
            abort(403);
        }

        $cities = Cities::getList('name');
        $statuses = Client::$listStatus;
        $blackListArr = [ 0=>'в білому списку', 1=>'в чорному списку'];
        return view('client.edit', compact('client', 'statuses', 'cities', 'blackListArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRequest $request, $id)
    {
        $data = $request->validated();
        $client = Client::findOrFail($id);
        if (Gate::allows('update-client', $client)) {
            $client->saveModel($data);
        }

        return redirect()->route('client.show', $client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Client $client)
    {
        if(Gate::allows('update-client', $client)){
            $client->status = Client::DELETED;
            $client->saveOrFail();
        }
        return redirect()->route('client.index');
    }

    /**
     * зміна статусу користувача по аяксу
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Request $request)
    {
        $client = Client::findOrFail($request->input('id'));

        if (! Gate::allows('update-client', $client)) {
            return response()->json(['success' => 'fail']);
        }
        $status = $client->status;
        if($client->status != Client::DELETED){
            switch ($request->input('status')) {
                case  Client::DISACTIVE :
                    $status = Client::ACTIVE;
                    $icon = '<i class="fas fa-user-minus"></i>';
                    $btn_class = 'btn btn-danger btn-sm';
                    $title = __('Деактивувати');
                    break;
                case  Client::ACTIVE :
                    $status = Client::DISACTIVE;
                    $icon = '<i class="fas fa-user-plus"></i>';
                    $btn_class = 'btn btn-info btn-sm';
                    $title = __('Активувати');
                    break;
            }
            $client->status = $status;
            $client->saveOrFail();
            return response()->json(compact('icon', 'btn_class', 'status', 'title'));
        }
        return response()->json(['success' => 'fail']);
    }

}
