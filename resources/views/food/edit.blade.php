@extends('layouts.main')

@section('content')
    <form action="{{ route('food.update', [$food->id]) }}" method="post" enctype="multipart/form-data" id="food_form">
        @csrf
        {{ method_field('PATCH') }}
        <input type="hidden" name="provider_id" id="provider_id" value="{{ $food->provider_id }}">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Редагування страви') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block  :model="$food" attr="name" title="Назва страви"/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <x-select :model="$food" :items="\App\Models\Permanent\TypeFood::getList()" attr="type_food" title="Тип"/>
                                </div>
                                <div class="col-4">
                                    <x-select :model="$food" :items="\App\Models\Permanent\TypeFoodIngredient::getList()" attr="food_ingredient" title="Інгредієнт"/>
                                </div>
                                <div class="col-4">
                                    <x-select :model="$food" :items="$food->getListStatus()" attr="status" title="Статус"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Опис страви') }}</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Опис ..." @if($food->isReadOnlyAttribute("description")) readonly @endif>{{ $food->description }}</textarea>
                            <div id="descriptionFeedback" class="invalid-feedback">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <x-input :model="$food" attr="amount" title="Кількість в порції"/>
                                </div>
                                <div class="col-4">
                                    <x-input :model="$food" attr="weight" title="Вага порції"/>
                                </div>
                                <div class="col-4">
                                    <x-input :model="$food" attr="price" title="Ціна"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tags">{{ __('Теги') }}</label>
                            <select class="select2bs4 @error('tags') is-invalid @enderror" multiple="multiple" name="tags[]" data-placeholder="Теги" style="width: 100%;" @if($food->isReadOnlyAttribute("tags")) disabled @endif>
                                @foreach($tags as $tag)
                                    <option {{ in_array($tag->id, $isTags) ? 'selected' : '' }} value="{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="tagsFeedback" class="invalid-feedback">
                                @error('tags')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <x-photo :model="$food" attr="photo" title="Фото"/>

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Графік активності страви') }}</h3>
                            </div>
                            <x-schedule :model="$food" attr="work_schedule"/>
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
                                        <x-select :model="$food" :items="$food->getListStatus()" attr="promote_status" title=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <x-input-block :model="$food" attr="promote_description" title="Назва акції"/>
                            </div>
                            <x-schedule :model="$food" attr="promote_schedule"/>
                            @error('promote_schedule')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="card card-primary @if($food->isHiddenAttribute('description_design')) d-none  @endif">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Додатковий опис, замість основного') }}</h3>
                            </div>
                            <div class="row p-2">
                                <div class="col-12">
                                    <label for="amount">{{ __('Заголовок') }}</label>
                                    <input type="text" name="description_design[title]"
                                           class="form-control" id="description_design_title"
                                           value="{{ $food->description_design['title'] ?? '' }}"
                                           placeholder="{{ __('Заголовок') }}"
                                           @if($food->isReadOnlyAttribute("description_design")) readonly @endif>
                                    <label for="amount">{{ __('Опис') }}</label>
                                </div>
                                <div class="col-12">
                                    <textarea name="description_design[description]" class="form-control" rows="3"
                                              placeholder="Опис ..." @if($food->isReadOnlyAttribute("description_design")) readonly @endif>{{ $food->description_design['description'] ?? '' }}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="amount">{{ __('Лівий блок') }}</label>
                                    <input type="text" name="description_design[left]"
                                           class="form-control" id="description_design_description"
                                           value="{{ $food->description_design['left'] ?? '' }}"
                                           placeholder="{{ __('Лівий блок') }}"
                                           @if($food->isReadOnlyAttribute("description_design")) readonly @endif>
                                </div>
                                <div class="col-6">
                                    <label for="amount">{{ __('Правий блок') }}</label>
                                    <input type="text" name="description_design[right]"
                                           class="form-control" id="description_design_description"
                                           value="{{ $food->description_design['right'] ?? '' }}"
                                           placeholder="{{ __('Правий блок') }}"
                                           @if($food->isReadOnlyAttribute("description_design")) readonly @endif>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <button  id="button" class="btn btn-primary">{{ __('Змінити') }}</button>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('food.index', $food->provider_id) }}"
                                       class="btn btn-success">{{ __('Відміна') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('modal.confirm')
@endsection
