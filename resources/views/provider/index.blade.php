@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>{{ __('Заклади') }}</h3>
            <a href="{{ route('provider.create') }}" class="btn btn-success mb-3">{{ __('Створити заклад') }}</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">{{ __('Лого') }}</th>
                    <th scope="col">{{ __('Назва') }}</th>
                    <th scope="col">{{ __('Місто') }}</th>
                    <th scope="col">{{ __('Дії')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($providers as $provider)
                    <tr>
                        <th scope="row">{{$provider->id}}</th>
                        <td><img class="direct-chat-img" src="{{ $provider->logo }}" alt="User profile picture"></td>
                        <td>{{$provider->name}}</td>
                        <td>{{$provider->getCityName()}}</td>
                        <td>
                            <a href="{{ route('food.index', $provider->id) }}" class="btn btn-success btn-sm"><i class="fas fa-ice-cream"></i></a>
                            <a href="{{ route('provider.show', $provider->id) }}" class="btn btn-success btn-sm"><i class="far fa-eye"></i></a>
                            <a href="{{ route('provider.edit', $provider->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                            <a onclick="return confirm('{{ __('Продовжити видалення?') }}')" href="{{ route('provider.delete', $provider->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $providers->links() }}
            </div>
        </div>
    </div>
@endsection
