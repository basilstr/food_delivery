@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-auto">
                    <h2>{{ __('Страви') }}</h2>
                </div>
                <div class="col-auto">
                    <div><b>{{ $provider->name }}</b></div>
                    <div>{{ __('Статус') }}: {{ $provider->getStatusName()  }}</div>
                </div>
            </div>

            <a href="{{ route('food.create', $provider->id) }}" class="btn btn-success mb-3">{{ __('Створити страву') }}</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('Фото') }}</th>
                    <th scope="col">{{ __('Назва') }}</th>
                    <th scope="col">{{ __('Статус') }}</th>
                    <th scope="col">{{ __('Ціна') }}</th>
                    <th scope="col">{{ __('Дії')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($foods as $food)
                    <tr>
                        <th scope="row">{{$food->id}}</th>
                        <td><img class="direct-chat-img" src="{{ $food->photo }}" alt="User profile picture"></td>
                        <td>{{$food->name}}</td>
                        <td>{{$food->getStatusName()}}</td>
                        <td>{{$food->price}}</td>
                        <td>
                            <a href="{{ route('ingredient.index', $food->id) }}" class="btn btn-success btn-sm"><i class="fas fa-list-ul"></i></a>

                            <a href="{{ route('food.show', $food->id) }}" class="btn btn-success btn-sm"><i class="far fa-eye"></i></a>

                            <a href="{{ route('food.edit', $food->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>

                            <a onclick="return confirm('{{ __('Продовжити видалення?') }}')" href="{{ route('food.delete', $food->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $foods->links() }}
            </div>
        </div>
    </div>
@endsection
