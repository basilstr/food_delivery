@extends('layouts.main')

@section('content')
    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Створення користувача') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block attr="login" title="Логін"/>

                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('Пароль') }}</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" id="password"
                                   placeholder="{{ __('Пароль') }}">
                            <div id="loginFeedback" class="invalid-feedback">
                                @error('password')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <x-input-block attr="name" title="Ім'я"/>

                        <x-select-block :items="$roles" attr="role" title="Роль"/>

                        <div class="form-group {{ empty($user->provider_id)  ?  ' d-none' : ''}}" id="provider-group">
                            <label for="role">{{ __('Керує закладом') }}</label>
                            <select name="provider_id" class="form-control select2bs4 select2-hidden-accessible"
                                    id="provider_id" style="width: 100%;">
                                <option selected value="0">
                                    {{ __('немає') }}
                                </option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-select-block :items="$statuses" attr="status" title="Статус"/>

                        <x-photo attr="avatar" title="Фото"/>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Створити') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
