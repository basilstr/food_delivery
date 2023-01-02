@extends('layouts.main')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Редагування користувача') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block :model="$user" attr="login" title="Логін"/>

                        <div class="form-group">
                            <label for="password">{{ __('Пароль') }}</label>
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="{{ __('Пароль') }}">
                        </div>

                        <x-input-block :model="$user" attr="name" title="Ім'я"/>

                        <x-select-block :model="$user" :items="$roles" attr="role" title="Роль"/>

                        <div class="form-group {{ empty($user->provider_id)  ?  ' d-none' : ''}}" id="provider-group">
                            <label for="provider_id">{{ __('Керує закладом') }}</label>
                            <select name="provider_id" class="form-control select2bs4 select2-hidden-accessible"
                                    id="provider_id" style="width: 100%;">
                                <option {{ empty($user->provider_id)  ?  ' selected' : ''}} value="0">
                                    {{ __('немає') }}
                                </option>
                                @foreach($providers as $provider)
                                    <option
                                        {{ $user->provider_id == $provider->id ?  ' selected' : ''}}
                                        value="{{ $provider->id }}">{{ $provider->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <x-select-block  :model="$user" :items="$statuses" attr="status" title="Статус"/>

                        @empty(Auth::user()->city_id)
                            <x-select-block  :model="$user" :items="$cities" attr="city_id" title="Місто" nullable="true"/>
                        @endempty

                        <x-photo  :model="$user" attr="avatar" title="Фото"/>

                        <div class="form-group">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Змінити') }}</button>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('user.index') }}"
                                       class="btn btn-success">{{ __('Відміна') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
