@extends('layouts.main')

@section('content')
    <form action="{{ route('client.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Створення клієнта') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block attr="phone" title="Телефон"/>
                        <x-input-block attr="name" title="Ім'я"/>

                        <x-select-block :items="$statuses" attr="status" title="Статус"/>
                        <x-input-block attr="address" title="Адреса"/>

                        @empty(Auth::user()->city_id)
                            <x-select-block  :items="$cities" attr="city_id" title="Місто"/>
                        @endempty
                        <div class="form-group">
                            <label for="notes">{{ __('Нотатки') }}</label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Опис ..."></textarea>
                            <div id="notesFeedback" class="invalid-feedback">
                                @error('notes')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <x-select-block :items="$blackListArr" attr="in_black_list" title="Статус"/>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Створити') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
