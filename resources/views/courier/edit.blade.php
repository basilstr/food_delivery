@extends('layouts.main')

@section('content')
    <form action="{{ route('courier.update', $courier->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Редагування кур\'єра') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block :model="$courier" attr="phone" title="Телефон"/>
                        <x-input-block :model="$courier" attr="name" title="Ім'я"/>
                        <x-input-block :model="$courier" attr="password" title="Ім'я"/>

                        <x-select-block :model="$courier" :items="$statuses" attr="status" title="Статус"/>
                        <x-select-block :model="$courier" :items="$typeDrive" attr="type_drive" title="Статус"/>


                        @empty(Auth::user()->city_id)
                            <x-select-block  :model="$courier" :items="$cities" attr="city_id" title="Місто"/>
                        @endempty
                        <div class="form-group">
                            <label for="notes">{{ __('Нотатки') }}</label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Опис ..."> {{ $courier->notes }}</textarea>
                            <div id="notesFeedback" class="invalid-feedback">
                                @error('notes')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Змінити') }}</button>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('courier.index') }}"
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
