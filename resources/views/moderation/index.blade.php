@extends('layouts.main')

@section('content')
    <form action="{{ route('moderation.update') }}" method="post" enctype="multipart/form-data" id="moderation_form">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="col-md-12">
                <div class="timeline">
                    @if($providers->count())
                        <div class="time-label ml-3">
                            <span class="bg-warning col-1">{{ __('Заклади') }}</span>
                        </div>

                        @foreach($providers as $provider)
                            <div>
                                <i class="fas fa-hamburger bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $provider->updated_at }}</span>
                                    <div class="card-body">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="provider_moderation" name="provider[]"
                                                   id="provider_{{ $provider->id }}" value="{{ $provider->id }}" checked>
                                            <label for="provider_{{ $provider->id }}"></label>
                                        </div>
                                        <a href="{{ route('provider.show', $provider->id) }}">{{ $provider->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($foods->count())
                        <div class="time-label ml-3">
                            <span class="bg-warning col-1">{{ __('Страви') }}</span>
                        </div>

                        @foreach($foods as $food)
                            <div>
                                <i class="fas fa-ice-cream bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $food->updated_at }}</span>
                                    <div class="card-body">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="food_moderation" name="food[]"
                                                   id="food_{{ $food->id }}" value="{{ $food->id }}" checked>
                                            <label for="food_{{ $food->id }}"></label>
                                        </div>
                                        <a href="{{ route('food.show', $food->id) }}">{{ $food->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($ingredients->count())
                        <div class="time-label ml-3">
                            <span class="bg-warning col-1">{{ __('Інгредієнти') }}</span>
                        </div>

                        @foreach($ingredients as $ingredient)
                            <div>
                                <i class="fas fa-list-ul bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $ingredient->updated_at }}</span>
                                    <div class="card-body">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="ingredient_moderation"
                                                   name="ingredient[]"
                                                   value="{{ $ingredient->id }}"
                                                   id="ingredient_{{ $ingredient->id }}" checked>
                                            <label for="ingredient_{{ $ingredient->id }}"></label>
                                        </div>
                                        <a href="{{ route('ingredient.index', $ingredient->parentFood->id) }}">{{ $ingredient->parentIngredient->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($tags->count())
                        <div class="time-label ml-3">
                            <span class="bg-warning col-1">{{ __('Теги') }}</span>
                        </div>

                        @foreach($tags as $tag)
                            <div>
                                <i class="fas fa-tags bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $tag->updated_at }}</span>
                                    <div class="card-body">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="tag_moderation" name="tag[]"
                                                   id="tag_{{ $tag->id }}" value="{{ $tag->id }}" checked>
                                            <label for="tag_{{ $tag->id }}"></label>
                                        </div>
                                        <a href="{{ route('tag.edit', $tag->id) }}">{{ $tag->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
            @if($tags->count() || $ingredients->count() || $foods->count() || $providers->count())
            <div class="col-12">
                <button type="submit" class="btn btn-primary ml-3">{{ __('В ПРОДАКШН') }}</button>
            </div>
            @else
                <div class="col-12">
                    {{ __('Дані для публікації відсутні') }}
                </div>
            @endif
        </div>
    </form>
@endsection
