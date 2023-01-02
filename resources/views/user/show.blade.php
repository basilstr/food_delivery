@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ $user->avatar }}"
                             alt="User profile picture">

                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->getRoleName() }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>{{ __('Логін') }}</b> <a class="float-right">{{ $user->login }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Місто') }}</b> <a class="float-right">{{ $user->getCityName() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Остання активність') }}</b> <a class="float-right">{{ $user->last_active }}</a>
                        </li>
                    </ul>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary"><b>{{ __('Редагувати') }}</b></a>
                        @if(Auth::id() == \App\Models\User::ADMIN_ID)
                            <a href="{{ route('user.history', $user->id) }}" class="btn btn-info"><b>{{ __('Історія') }}</b></a>
                        @endif
                        <a href="{{ route('user.index') }}" class="btn btn-success"><b>{{ __('Загальний список') }}</b></a>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection
