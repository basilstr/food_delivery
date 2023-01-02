@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>{{ __('Користувачі') }}</h3>
            <a href="{{ route('user.create') }}" class="btn btn-success mb-3">{{ __('Створити користувача') }}</a>
        </div>
    </div>

    <form action="{{ route('user.index') }}" method="get">
        <x-filter :dataw="$data" :roles="$roles" :cities="$cities" :providers="$providers" route="user.index"/>
    </form>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('Аватар') }}</th>
                    <th scope="col">{{ __('Ім\'я') }}</th>
                    <th scope="col">{{ __('Роль') }}</th>
                    <th scope="col">{{ __('Дії')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td><img class="direct-chat-img" src="{{ $user->avatar }}" alt="User profile picture"></td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->getRoleName()}}</td>
                        <td>
                            @if(Auth::id() == \App\Models\User::ADMIN_ID)
                                <a href="{{ route('user.reload', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-user-friends"></i></a>
                            @endif
                            <a href="{{ route('user.show', $user->id) }}" class="btn btn-success btn-sm"><i class="far fa-eye"></i></a>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                            @if($user->status == App\Models\User::ACTIVE)
                                <button id="btn_active_{{ $user->id }}" class="btn btn-danger btn-sm" data-status="{{ \App\Models\User::ACTIVE }}" title="{{ __('Деактивувати') }}" onclick="setUserStatus({{ $user->id }})"><i class="fas fa-user-minus"></i></button>
                            @else
                                <button id="btn_active_{{ $user->id }}" class="btn btn-info btn-sm" data-status="{{ \App\Models\User::DISACTIVE }}" title="{{ __('Активувати') }}" onclick="setUserStatus({{ $user->id }})"><i class="fas fa-user-plus"></i></button>
                            @endif
                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
