<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserFilterRequest;
use App\Http\Requests\UserRequest;
use App\Models\LogAction;
use App\Models\Permanent\Cities;
use App\Models\Permanent\Role;
use App\Models\Provider;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(UserFilterRequest $request)
    {
        $roles = Role::getList();
        $cities = Cities::getList('name');
        $providers = Provider::filterCity()->get();

        $data = $request->validated();
        $filter = app()->make(UserFilter::class, ['queryParams' => array_filter($data)]);
        $users = User::filter($filter)->filterCity()->where('id', '>', 1)->whereIn('status', [User::ACTIVE, User::DISACTIVE])->paginate(100);
        return view('user.index', compact('users', 'roles', 'cities', 'providers', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::getList();
        $providers = Provider::all();
        $statuses = User::getListStatus();
        return view('user.create', compact( 'roles', 'providers', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        if(empty($data['password'])) {
            throw ValidationException::withMessages([
                'password' => __('Не вказаний пароль'),
            ]);
        }
        $user = new User();
        $user->saveModel( $data);

        return redirect()->route('user.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(User $user)
    {
        if($user->id == User::ADMIN_ID || $user->status == User::DELETED){
            return redirect()->route('user.index');
        }
        if (Gate::denies('update-user', $user)) {
            abort(403);
        }
        $roles = Role::getList();
        $cities = Cities::getList('name');
        return view('user.show', compact('user', 'roles', 'cities'));
    }

    public function history(User $user)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $user->id)->where('model', User::class)->orderByDesc('id')->paginate(10);
            $title = 'Користувач: '. $user->name;
            $route = route('user.index');
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(User $user)
    {
        if($user->id == User::ADMIN_ID || $user->status == User::DELETED){
            return redirect()->route('user.index');
        }

        if (Gate::denies('update-user', $user)) {
            abort(403);
        }

        $roles = Role::getList();
        $cities = Cities::getList('name');
        $providers = Provider::all();
        $statuses = User::getListStatus();
        return view('user.edit', compact('user', 'roles', 'statuses', 'providers', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::findOrFail($id);
        if (Gate::allows('update-user', $user)) {
            $user->saveModel($data);
        }

        return redirect()->route('user.show', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(User $user)
    {
        if(Gate::allows('update-user', $user) && $user->id > User::ADMIN_ID){
            $user->status = User::DELETED;
            $user->saveOrFail();
        }
        return redirect()->route('user.index');
    }

    public function reload(User $user)
    {
        if(Auth::id() == User::ADMIN_ID){
            $loggedInUser = Auth::loginUsingId($user->id);

            if (!$loggedInUser) {
                // If User not logged in, then Throw exception
                throw new \Exception('Single SignOn: User Cannot be Signed In');
            }
        }
        return redirect()->route('user.index');
    }

    /**
     * зміна статусу користувача по аяксу
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Request $request)
    {
        $user = User::findOrFail($request->input('id'));

        if (! Gate::allows('update-user', $user)) {
            return response()->json(['success' => 'fail']);
        }
        $status = $user->status;
        if($user->id > User::ADMIN_ID  && $user->status != User::DELETED){
            switch ($request->input('status')) {
                case  User::DISACTIVE :
                    $status = User::ACTIVE;
                    $icon = '<i class="fas fa-user-minus"></i>';
                    $btn_class = 'btn btn-danger btn-sm';
                    $title = __('Деактивувати');
                    break;
                case  User::ACTIVE :
                    $status = User::DISACTIVE;
                    $icon = '<i class="fas fa-user-plus"></i>';
                    $btn_class = 'btn btn-info btn-sm';
                    $title = __('Активувати');
                    break;
            }
            $user->status = $status;
            $user->saveOrFail();
            return response()->json(compact('icon', 'btn_class', 'status', 'title'));
        }
        return response()->json(['success' => 'fail']);
    }

}
