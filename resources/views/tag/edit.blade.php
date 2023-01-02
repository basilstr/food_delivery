@extends('layouts.main')

@section('content')
    <form action="{{ route('tag.update', $tag->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Редагування тега') }}</h3>
                    </div>
                    <div class="card-body">
                        <x-input-block :model="$tag" attr="name" title="Назва тегу"/>
                        <x-input-block :model="$tag" attr="description" title="Опис тегу"/>
                        <x-select-block :model="$tag" :items="$statuses" attr="status" title="Статус"/>
                        <div class="form-group">
                            <label for="role">{{ __('Кореневий тег') }}</label>
                            <select name="parent_id" class="custom-select rounded-0" id="parent_id">
                                <option value="0">{{ __('Кореневий') }}</option>
                                @foreach($tags as $parentTag)
                                    <option
                                        {{ $parentTag->id == $tag->parent_id ?  ' selected' : ''}}
                                        value="{{ $parentTag->id }}">
                                        {{ $parentTag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-photo :model="$tag" attr="photo" title="Фото"/>
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">{{ __('Змінити') }}</button>
                                <a href="{{ route('tag.index') }}" class="btn btn-success">{{ __('Відміна') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
