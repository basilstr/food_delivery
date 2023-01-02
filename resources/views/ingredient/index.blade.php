@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <div class="text-center"><img class="profile-user-img" src="{{ $food->photo }}"/></div>
                        </div>
                        <div class="col-auto px-4">
                            <div><h4>{{ $food->name }}</h4></div>
                            <div>{{ __('Ціна:') }} <b>{{ $food->price }}</b> </div>
                            <div>{{ __('Статус:') }} <b>{{ $food->getStatusName() }}</b></div>
                        </div>
                        <div class="col px-4">
                            <div>{{ __('Кількість в порції') }} : <b>{{ $food->amount }}</b> </div>
                            <div>{{ __('Вага порції') }}: <b>{{ $food->weight }}</b> </div>
                            <div>{{ __('Акції:') }} <b>{{ $food->getPromoteStatusName() }}</b></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="d-flex justify-content-start">
                            <button type="button" class="btn btn-success mr-1" onclick="loadIngredient({{ $food->provider_id }})">
                                {{ __('Новий інгредієнт') }}
                            </button>
                            <a onclick="return hasChangeForm('ingredient_form')" href="{{ route('food.index', $food->provider_id) }}" class="btn btn-info mr-1">{{ __('Страви') }}</a>
                            <a onclick="return hasChangeForm('ingredient_form')" href="{{ route('food.edit', $food->id) }}" class="btn btn-warning mr-1">{{ __('Редагувати страву') }}</i></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                @if($ingredients->count() > 0)
                    <div class="card-body">
                        <form action="{{ route('ingredient.update', [$food->id]) }}" method="post"
                              enctype="multipart/form-data" id="ingredient_form">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div id="accordion">
                                @foreach($ingredients as $ingredient)
                                    @include('ingredient.accordion')
                                @endforeach

                            </div>
                            <div class="form-group">
                                <div class="row justify-content-between">
                                    <button type="submit" class="btn btn-primary">{{ __('Змінити') }}</button>
                                    <a href="{{ route('food.index', $food->provider_id) }}" class="btn btn-success">{{ __('Відміна') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            <!-- /.card-body -->
            </div>
        </div>
    </div>
    @include('modal.add-ingredient')
@endsection
