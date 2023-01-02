<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\CourierFilter;
use App\Http\Requests\CourierFilterRequest;
use App\Http\Requests\CourierRequest;
use App\Models\Courier;
use App\Models\LogAction;
use App\Models\Permanent\Cities;
use App\Models\Permanent\TypeDrive;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(CourierFilterRequest $request)
    {
        $cities = Cities::getList('name');
        $data = $request->validated();
        $filter = app()->make(CourierFilter::class, ['queryParams' => array_filter($data)]);
        $couriers = Courier::filter($filter)->filterCity()->whereIn('status', [Courier::ACTIVE, Courier::DISACTIVE])->paginate(100);
        return view('courier.index', compact('couriers',  'cities',  'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $cities = Cities::getList('name');
        $typeDrive = TypeDrive::getList();
        $statuses = Courier::$listStatus;
        return view('courier.create', compact( 'statuses', 'cities', 'typeDrive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CourierRequest $request)
    {
        $data = $request->validated();
        $courier = new Courier();
        $courier->saveModel( $data);

        return redirect()->route('courier.show', $courier->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Courier $courier
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Courier $courier)
    {
        if($courier->status == Courier::DELETED){
            return redirect()->route('courier.index');
        }
        if (Gate::denies('update-courier', $courier)) {
            abort(403);
        }
        $cities = Cities::getList('name');
        $typeDrive = TypeDrive::getList();
        return view('courier.show', compact('courier', 'cities', 'typeDrive'));
    }

    public function history(Courier $courier)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $courier->id)->where('model', Courier::class)->orderByDesc('id')->paginate(10);
            $title = 'Кур\'єр: '. $courier->name;
            $route = route('courier.index');
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Courier $courier
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Courier $courier)
    {
        if($courier->status == Courier::DELETED){
            return redirect()->route('courier.index');
        }

        if (Gate::denies('update-courier', $courier)) {
            abort(403);
        }

        $cities = Cities::getList('name');
        $statuses = Courier::$listStatus;
        $typeDrive = TypeDrive::getList();
        return view('courier.edit', compact('courier', 'statuses', 'cities', 'typeDrive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CourierRequest $request, $id)
    {
        $data = $request->validated();
        $courier = Courier::findOrFail($id);
        if (Gate::allows('update-courier', $courier)) {
            $courier->saveModel($data);
        }

        return redirect()->route('courier.show', $courier->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Courier $courier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Courier $courier)
    {
        if(Gate::allows('update-courier', $courier)){
            $courier->status = Courier::DELETED;
            $courier->saveOrFail();
        }
        return redirect()->route('courier.index');
    }

    /**
     * зміна статусу користувача по аяксу
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Request $request)
    {
        $courier = Courier::findOrFail($request->input('id'));

        if (Gate::denies('update-courier', $courier)) {
            abort(403);
        }
        $status = $courier->status;
        if($courier->status != Courier::DELETED){
            switch ($request->input('status')) {
                case  Courier::DISACTIVE :
                    $status = Courier::ACTIVE;
                    $icon = '<i class="fas fa-user-minus"></i>';
                    $btn_class = 'btn btn-danger btn-sm';
                    $title = __('Деактивувати');
                    break;
                case  Courier::ACTIVE :
                    $status = Courier::DISACTIVE;
                    $icon = '<i class="fas fa-user-plus"></i>';
                    $btn_class = 'btn btn-info btn-sm';
                    $title = __('Активувати');
                    break;
            }
            $courier->status = $status;
            $courier->saveOrFail();
            return response()->json(compact('icon', 'btn_class', 'status', 'title'));
        }
        return response()->json(['success' => 'fail']);
    }

}
