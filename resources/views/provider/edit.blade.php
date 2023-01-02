@extends('layouts.main')

@section('content')
    <input type="hidden" id="new_lat">
    <input type="hidden" id="new_lon">

    <form action="{{ route('provider.update', $provider->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('Редагування закладу') }}</h3>
            </div>
            <div class="card-body">
                <x-input-block  :model="$provider" attr="name" title="Ім'я" required="true"/>
                <x-input-block  :model="$provider" attr="aliases" title="Альяси для пошуку (через ;)" required="true"/>

                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            <x-input :model="$provider" attr="description" title="Короткий опис (1-2 слова)"/>
                        </div>
                        <div class="col-4">
                            <x-input :model="$provider" attr="min_price" title="Мін. ціна замовлення"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="about">{{ __('Про заклад (детальний опис)') }}</label>
                    <textarea name="about" class="form-control" rows="3"
                              placeholder="Опис ..." @if($provider->isReadOnlyAttribute("description_design")) readonly @endif>{{ $provider->description ?? '' }}</textarea>
                    <div id="notesFeedback" class="invalid-feedback">
                        @error('about')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <x-input :model="$provider" attr="lat" title="Широта"/>
                        </div>
                        <div class="col-4">
                            <x-input :model="$provider" attr="lon" title="Довгота"/>
                        </div>
                        <div class="col-4 mt-auto">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                                {{ __('Вибрати на карті') }}
                            </button>
                        </div>
                    </div>
                </div>

                <x-input-block :model="$provider" attr="address" title="Адреса" required="true"/>

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Розпорядок роботи') }}</h3>
                    </div>
                    <x-schedule  :model="$provider" attr="work_schedule"/>
                    @error('work_schedule')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            @if(isset(Auth::user()->city_id))
                                <x-select :model="$provider" :items="$cities" attr="city_id" title="Місто" disabled />
                            @else
                                <x-select :model="$provider" :items="$cities" attr="city_id" title="Місто" />
                            @endif
                        </div>
                        <div class="col-4">
                            <x-select :model="$provider" :items="$provider->getListStatus()" attr="status" title="Статус" required/>
                        </div>
                        <div class="col-4">
                            <x-input :model="$provider" attr="sort" title="Сортування"/>
                        </div>
                    </div>
                </div>


                <x-select-block :model="$provider" :items="$typesPay" attr="type_pay" title="Доступні способи оплати" multiple/>
                <x-select-block :model="$provider" :items="$typesDelivery" attr="type_delivery" title="Доступні способи доставки" multiple/>

                <x-photo :model="$provider" attr="logo" title="Лого"/>

                <div class="form-group">
                    <div class="row justify-content-between">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">{{ __('Змінити') }}</button>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('provider.index') }}" class="btn btn-success">{{ __('Відміна') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
    @include('modal.map')
@endsection
