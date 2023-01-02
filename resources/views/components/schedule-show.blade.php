<table class="jsgrid-table">
    <tbody>
    <tr class="jsgrid-row">
        <td>{{ __('Початок') }}</td>
        <td> - </td>
        <td>{{ $model->$attr->toFormatArray(true)['start'] }}</td>
    </tr>
    <tr class="jsgrid-row">
        <td>{{ __('Кінець') }}</td>
        <td> - </td>
        <td>{{ $model->$attr->toFormatArray(true)['finish'] }}</td>
    </tr>
    @foreach($week as $key => $day)
    <tr class="jsgrid-row">
        <td>{{ $day }}</td>
        <td> - </td>
        <td>{{ $model->$attr->toFormatArray(true)[$key] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
