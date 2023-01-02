@extends('layouts.main')

@section('content')
    <form action="{{ route('food.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="provider_id" id="provider_id" value="{{ $provider->id }}">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Створення страви') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block  attr="name" title="Назва страви"/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <x-select :items="\App\Models\Permanent\TypeFood::getList()" attr="type_food" title="Тип"/>
                                </div>
                                <div class="col-4">
                                    <x-select :items="\App\Models\Permanent\TypeFoodIngredient::getList()" attr="food_ingredient" title="Інгредієнт"/>
                                </div>
                                <div class="col-4">
                                    <x-select :items="$statuses" attr="status" title="Статус"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Опис страви') }}</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Опис ..."></textarea>
                            <div id="descriptionFeedback" class="invalid-feedback">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tags">{{ __('Теги') }}</label>
                            <select class="select2bs4 @error('tags') is-invalid @enderror" multiple="multiple" name="tags[]" data-placeholder="Теги" style="width: 100%;">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <div id="tagsFeedback" class="invalid-feedback">
                                @error('tags')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <x-photo attr="photo" title="Фото"/>

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Графік активності страви') }}</h3>
                            </div>
                            <x-schedule attr="work_schedule"/>
                            @error('work_schedule')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="card card-success">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto mr-auto"><h3 class="card-title">{{ __('Акції') }}</h3></div>
                                    <div class="col-auto">
                                        <x-select :items="$statuses" attr="promote_status" title=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <x-input-block attr="promote_description" title="Назва акції"/>
                            </div>
                            <x-schedule attr="promote_schedule"/>
                            @error('promote_schedule')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Додатковий опис, замість основного') }}</h3>
                            </div>
                            <div class="row p-2">
                                <div class="col-12">
                                    <label for="amount">{{ __('Заголовок') }}</label>
                                    <input type="text" name="description_design[title]"
                                           class="form-control" id="description_design_title"
                                           value=""
                                           placeholder="{{ __('Заголовок') }}">
                                    <label for="amount">{{ __('Опис') }}</label>
                                </div>
                                <div class="col-12">
                                    <textarea name="description_design[description]" class="form-control" rows="3"
                                              placeholder="Опис ..."></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="amount">{{ __('Лівий блок') }}</label>
                                    <input type="text" name="description_design[left]"
                                           class="form-control" id="description_design_description"
                                           value=""
                                           placeholder="{{ __('Лівий блок') }}">
                                </div>
                                <div class="col-6">
                                    <label for="amount">{{ __('Правий блок') }}</label>
                                    <input type="text" name="description_design[right]"
                                           class="form-control" id="description_design_description"
                                           value=""
                                           placeholder="{{ __('Правий блок') }}">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Створити') }}</button>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('food.index', $provider->id) }}" class="btn btn-success">{{ __('Відміна') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
