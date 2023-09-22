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
    </style>
</head>
<body>
<div>
    <table border="1" width="90%">
        <thead>
        <tr style="font-weight: bold">
            <th>#</th>
            <th>Счёт раками</th>
            <th>Йил</th>
            <th>Дт мик</th>
            <th>Дт сумма</th>
            <th>Кт мик</th>
            <th>Кт сумма</th>
        </tr>
        </thead>
        <tbody>
        @foreach($debts as $item)
            <tr>
                <td>{{$loop->index +1}}</td>
                <td>{{$item->dtkt}}</td>
                <td>{{$item->year}}</td>
                <td>{{$item->dt_weight}}</td>
                <td>{{number_format($item->dt_price, 2, ',', ' ')}}</td>
                <td>{{$item->kt_weight}}</td>
                <td>{{number_format($item->kt_price, 2, ',', ' ')}}</td>
            </tr>
        @endforeach
        <tr style="font-weight: bold">
            <td colspan="3">ЖАМИ</td>
            <td></td>
            <td>{{number_format($sum['dt_price'], 2, ',', ' ')}}</td>
            <td></td>
            <td>{{number_format($sum['kt_price'], 2, ',', ' ')}}</td>
        </tr>
        <tr style="font-weight: bold">
            <td colspan="3">ФАРК</td>
            <td></td>
            <td>
                @if($sum['dt_price'] > $sum['kt_price'])
                    {{number_format($sum['dt_price']-$sum['kt_price'], 2, ',', ' ')}}
                @else
                    0
                @endif
            </td>
            <td></td>
            <td>
                @if($sum['dt_price'] < $sum['kt_price'])
                    {{number_format($sum['kt_price']-$sum['dt_price'], 2, ',', ' ')}}
                @else
                    0
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

