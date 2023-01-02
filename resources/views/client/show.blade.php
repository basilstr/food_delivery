@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">{{ $client->name }}</h3>
                    <p class="text-muted text-center">{{ $client->getCityName() }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>{{ __('Телефон') }}</b> <a class="float-right">{{ $client->phone }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Адреса') }}</b> <a class="float-right">{{ $client->address }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Примітки') }}</b> <a class="float-right">{{ $client->notes }}</a>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('client.edit', $client->id) }}" class="btn btn-primary"><b>{{ __('Редагувати') }}</b></a>
                        @if(Auth::id() == \App\Models\User::ADMIN_ID)
                            <a href="{{ route('client.history', $client->id) }}" class="btn btn-info"><b>{{ __('Історія') }}</b></a>
                        @endif
                        <a href="{{ route('client.index') }}" class="btn btn-success"><b>{{ __('Загальний список') }}</b></a>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection
