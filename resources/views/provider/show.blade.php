@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="card card-primary">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid" src="{{ $provider->logo }}"
                             alt="Provider logo">

                    </div>

                    <h3 class="profile-username text-center">{{ $provider->name }}</h3>

                    <p class="text-muted text-center">{{ $provider->getCityName() }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>{{ __('Адреса') }}</b> <a class="float-right">{{ $provider->address }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Альяси') }}</b> <a class="float-right">{{ $provider->aliases }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Короткий опис') }}</b> <a class="float-right">{{ $provider->description }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Мін. ціна') }}</b> <a class="float-right">{{ $provider->min_price }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Статус') }}</b> <a class="float-right">{{ $provider->getStatusName() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Рейтинг') }}</b>
                            <a class="float-right">
                                @for ($i = 0; $i < $provider->rating; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Способи оплати') }}</b>
                            <a class="float-right">
                                <ul>
                                    @foreach($typesPay as $typePay)
                                        <li>{{ $typePay }}</li>
                                    @endforeach
                                </ul>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Способи доставки') }}</b>
                            <a class="float-right">
                                <ul>
                                    @foreach($typesDelivery as $typeDelivery)
                                        <li>{{ $typeDelivery }}</li>
                                    @endforeach
                                </ul>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Графік роботи') }}</b>
                            <a class="float-right">
                                <x-schedule-show :model="$provider" attr="work_schedule"/>
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('provider.edit', $provider->id) }}" class="btn btn-primary"><b>{{ __('Редагувати') }}</b></a>
                        @if(Auth::id() == \App\Models\User::ADMIN_ID)
                            <a href="{{ route('provider.history', $provider->id) }}" class="btn btn-info"><b>{{ __('Історія') }}</b></a>
                        @endif
                        <a href="{{ route('provider.index') }}" class="btn btn-success"><b>{{ __('Загальний список') }}</b></a>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection
