<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ \Illuminate\Support\Facades\Auth::user()->name.$year }}</title>
    <style>
        * {
            font-family: DejaVu Sans !important;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        tr, td, th {
            height: 25px;
        }

        .table-row {
            background-color: #bdbdbd;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div>
    <table border="1">
        <thead style="background-color: #6767f1; font-weight: bold">
        <tr>
            <td rowspan="2" width="5%">#</td>
            <td colspan="2" width="15%">Праводка</td>
            <td rowspan="2" width="40%">Мазмуни</td>
            <td colspan="2" width="20%">Дебет</td>
            <td colspan="2" width="20%">Кредит</td>
        </tr>
        <tr>
            <th>Вакти</th>
            <th>№</th>
            <th width="5%">мик</th>
            <th width="15%">суммаси</th>
            <th width="5%">мик</th>
            <th width="15%">суммаси</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key => $item)
            <tr class="table-row">
                <td colspan="8">СЧЁТ № {{ $key }}</td>
            </tr>
            <tr class="table-row">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    @if(isset($debt[$key]->year))
                        01.01.{{ $debt[$key]->year }} - йилга колдик
                    @else
                        01.01.{{ $item['data'][0]->year }} - йилга колдик
                    @endif
                </td>
                <td>
                    @if(isset($debt[$key]->dt_weight))
                        {{ $debt[$key]->dt_weight }}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if(isset($debt[$key]->dt_price))
                        {{ number_format($debt[$key]->dt_price, 2, ',',' ') }}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if(isset($debt[$key]->kt_weight))
                        {{ $debt[$key]->kt_weight }}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if(isset($debt[$key]->kt_price))
                        {{ number_format($debt[$key]->kt_price, 2, ',',' ') }}
                    @else
                        0
                    @endif
                </td>
            </tr>
            @foreach($item['data'] as $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>
                        @switch($value->month)
                            @case(1)
                                {{ __("messages.january") }}
                                @break
                            @case(2)
                                {{ __("messages.february") }}
                                @break
                            @case(3)
                                {{ __("messages.march") }}
                                @break
                            @case(4)
                                {{ __("messages.april") }}
                                @break
                            @case(5)
                                {{ __("messages.may") }}
                                @break
                            @case(6)
                                {{ __("messages.june") }}
                                @break
                            @case(7)
                                {{ __("messages.july") }}
                                @break
                            @case(8)
                                {{ __("messages.august") }}
                                @break
                            @case(9)
                                {{ __("messages.september") }}
                                @break
                            @case(10)
                                {{ __("messages.october") }}
                                @break
                            @case(11)
                                {{ __("messages.november") }}
                                @break
                            @case(12)
                                {{ __("messages.december") }}
                                @break
                        @endswitch

                        {{$value->year}}
                    </td>
                    <td>{{$value->n_id}}</td>
                    <td>{{$value->title}}</td>
                    <td>
                        @if ($key == $value->dt)
                            {{$value->weight}}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if ($key == $value->dt)
                            {{number_format($value->price, 2, ',', ' ')}}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if ($key == $value->kt)
                            {{$value->weight}}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if ($key == $value->kt)
                            {{number_format($value->price, 2, ',', ' ')}}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr class="table-row">
                <td></td>
                <td></td>
                <td></td>
                <td>оборот</td>
                <td>{{$item['dt_weight']}}</td>
                <td>{{number_format($item['dt_price'], 2, ',', ' ')}}</td>
                <td>{{$item['kt_weight']}}</td>
                <td>{{number_format($item['kt_price'], 2, ',', ' ')}}</td>
            </tr>
            <tr class="table-row">
                <td></td>
                <td></td>
                <td></td>
                <td>01.01.{{ $year + 1 }} - йилга колдик</td>
                <?php
                if (!isset($debt[$key]->dt_weight)) {
                    $dt_weight = 0;
                } else {
                    $dt_weight = $debt[$key]->dt_weight;
                }
                if (!isset($debt[$key]->dt_price)) {
                    $dt_price = 0;
                } else {
                    $dt_price = $debt[$key]->dt_price;
                }
                if (!isset($debt[$key]->kt_weight)) {
                    $kt_weight = 0;
                } else {
                    $kt_weight = $debt[$key]->kt_weight;
                }
                if (!isset($debt[$key]->kt_price)) {
                    $kt_price = 0;
                } else {
                    $kt_price = $debt[$key]->kt_price;
                }
                $dt_price_sum = $item['dt_price'] + $dt_price;
                $kt_price_sum = $item['kt_price'] + $kt_price;

                $dt_weight_sum = $item['dt_weight'] + $dt_weight;
                $kt_weight_sum = $item['kt_weight'] + $kt_weight;
                ?>
                <td>
                    @if($dt_weight_sum > $kt_weight_sum)
                        {{$dt_weight_sum - $kt_weight_sum}}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if($dt_price_sum > $kt_price_sum)
                        {{number_format($dt_price_sum - $kt_price_sum, 2, ',', ' ')}}
                    @else
                        0,00
                    @endif
                </td>
                <td>
                    @if($kt_weight_sum > $dt_weight_sum)
                        {{$kt_weight_sum - $dt_weight_sum}}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if($kt_price_sum > $dt_price_sum)
                        {{number_format($kt_price_sum - $dt_price_sum, 2, ',', ' ')}}
                    @else
                        0,00
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>

