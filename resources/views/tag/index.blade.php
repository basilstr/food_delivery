@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>{{ __('Теги') }}</h3>
            <a href="{{ route('tag.create') }}" class="btn btn-success mb-3">{{ __('Створити тег') }}</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('Фото') }}</th>
                    <th scope="col">{{ __('Назва') }}</th>
                    <th scope="col">{{ __('Кореневий') }}</th>
                    <th scope="col">{{ __('Дії')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <th scope="row">{{$tag->id}}</th>
                        <td><img class="direct-chat-img" src="{{ $tag->photo }}" alt="User profile picture"></td>
                        <td>{{$tag->name}}</td>
                        <td>{{ empty($tag->parent_id) ? 'кореневий' : $tag->parentTag->name }}</td>
                        <td>
                            @if(Auth::id() == \App\Models\User::ADMIN_ID)
                                <a href="{{ route('tag.history', $tag->id) }}" class="btn btn-info btn-sm"><i class="fas fa-microscope"></i></a>
                            @endif

                            <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                            <a onclick="return confirm('{{ __('Будуть видалені всі підпорядковані теги також. Продовжити?') }}')" href="{{ route('tag.delete', $tag->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $tags->links() }}
            </div>
        </div>
    </div>
@endsection
