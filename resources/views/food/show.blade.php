@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="card card-primary">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid" src="{{ $food->photo }}"
                             alt="Provider logo">

                    </div>

                    <h3 class="profile-username text-center">{{ $food->name }}</h3>

                    <p class="text-muted text-center">{{ $food->price }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>{{ __('Назва страви') }}</b> <a class="float-right">{{ $food->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Тип') }}</b> <a class="float-right">{{ $typeFoods[$food->type_food] ?? 'не визначено' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Кількість в порції') }}</b> <a class="float-right">{{ $food->amount }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Вага порції') }}</b> <a class="float-right">{{ $food->weight }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Опис') }}</b> <a class="float-right">{{ $food->description }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Ціна') }}</b> <a class="float-right">{{ $food->price }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Ціна упаковки') }}</b> <a class="float-right">{{ $food->price_pack }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Статус') }}</b> <a class="float-right">{{ $food->getStatusName() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Графік активності страви') }}</b>
                            <a class="float-right">
                                <x-schedule-show :model="$food" attr="work_schedule"/>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Статус акції') }}</b> <a class="float-right">{{ $food->promote ? __('активна') : __('неактивна') }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{ __('Початок та кінець акції | Акції по дням тижня') }}</b>
                            <a class="float-right">
                                <x-schedule-show :model="$food" attr="promote_schedule"/>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <i>{{ __('Додатковий опис') }}</i><br>
                            <b>{{ $food->description_design['title'] ?? '' }}</b><br>
                            {{ $food->description_design['description'] ?? '' }}
                            <span class="float-left bg-warning mr-2">{{ $food->description_design['left'] ?? '' }}</span>
                            <span class="float-right bg-warning ml-2">{{ $food->description_design['right'] ?? '' }}</span>
                        </li>

                    </ul>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('food.edit', [$food->id]) }}" class="btn btn-primary"><b>{{ __('Редагувати') }}</b></a>
                        @if(Auth::id() == \App\Models\User::ADMIN_ID)
                            <a href="{{ route('food.history', $food->id) }}" class="btn btn-info"><b>{{ __('Історія') }}</b></a>
                        @endif
                        <a href="{{ route('food.index', $food->provider_id) }}" class="btn btn-success"><b>{{ __('Загальний список') }}</b></a>
                        <a href="{{ route('ingredient.index', $food->id) }}" class="btn btn-info"><b>{{ __('Інгредієнти') }}</b></a>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection
