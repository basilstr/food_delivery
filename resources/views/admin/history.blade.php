@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row justify-content-between mb-3">
                <h3>{{ $title }}</h3>
                <a href="{{ $route }}" class="btn btn-success"><b>{{ __('До списку') }}</b></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Користувач</th>
                    <th>Дата</th>
                    <th>Дія</th>
                    <th>Зміни</th>
                </tr>
                </thead>
                <tbody>
            @foreach($histories as $history)
                @if(!empty($data = $history->parseHistory()->parseData))
                        <tr>
                            <td>{{ $history->id }}</td>
                            <td>{{ isset($history->user) ? $history->user->name : 'anomimous' }}</td>
                            <td>{{ $history->created_at }}</td>
                            <td>{{ $history->action }}</td>
                            <td>
                            @foreach($data as $value)
                                Параметр "{{ $value['attr'] }}" змінено з
                                @if(count($value['params'])>1):<br> @endif
                                    @foreach($value['params'] as $key => $param)
                                        @if(count($value['params'])>1) {{ $key+1 }} - @endif "{{ $param['old'] }}" на "{{ $param['new'] }}"<br>
                                    @endforeach
                            @endforeach
                            </td>
                        </tr>
                @endif
            @endforeach
                </tbody>
            </table>
            <div>
                {{ $histories->links() }}
            </div>
        </div>
    </div>
@endsection
