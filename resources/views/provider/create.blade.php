@extends('layouts.main')

@section('content')
    <input type="hidden" id="new_lat">
    <input type="hidden" id="new_lon">

    <form action="{{ route('provider.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Створення закладу') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block attr="name" title="Ім'я"/>
                        <x-input-block attr="aliases" title="Альяси для пошуку (через ;)" required="true"/>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-8">
                                    <x-input attr="description" title="Короткий опис (1-2 слова)"/>
                                </div>
                                <div class="col-4">
                                    <x-input attr="min_price" title="Мін. ціна замовлення"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="about">{{ __('Про заклад (детальний опис)') }}</label>
                            <textarea name="about" class="form-control" rows="3"
                                      placeholder="Опис ..."></textarea>
                            <div id="notesFeedback" class="invalid-feedback">
                                @error('about')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <label for="lat">{{ __('Широта') }}</label>
                                    <input type="text" name="lat" class="form-control" id="lat" value="49.424862" placeholder="{{ __('Широта') }}">
                                </div>
                                <div class="col-4">
                                    <label for="lon">{{ __('Довгота') }}</label>
                                    <input type="text" name="lon" class="form-control" id="lon" value="26.983493" placeholder="{{ __('Довгота') }}">
                                </div>
                                <div class="col-4 mt-auto">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                                        {{ __('Вибрати на карті') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <x-input-block attr="address" title="Адреса"/>
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Розпорядок роботи') }}</h3>
                            </div>
                            <x-schedule attr="work_schedule"/>
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
                                        <x-select :items="$cities" attr="city_id" title="Місто" disabled />
                                    @else
                                        <x-select :items="$cities" attr="city_id" title="Місто"/>
                                    @endif
                                </div>
                                <div class="col-4">
                                    <x-select :items="\App\Models\Provider::$listStatus" attr="status" title="Статус"/>
                                </div>
                                <div class="col-4">
                                    <x-input   attr="sort" title="Сортування"/>
                                </div>
                            </div>
                        </div>

                        <x-select-block :items="$typesPay" attr="type_pay" title="Доступні способи оплати" multiple="true"/>
                        <x-select-block :items="$typesDelivery" attr="type_delivery" title="Доступні способи доставки" multiple="true"/>

                        <x-photo attr="logo" title="Лого"/>

                        <div class="form-group">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Створити') }}</button>
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
