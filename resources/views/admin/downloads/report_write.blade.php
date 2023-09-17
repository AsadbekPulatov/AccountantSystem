<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{'Праводка '. \Illuminate\Support\Facades\Auth::user()->name.'('.$years[0]->year.')'}}</title>
    <style>
        * {
            font-family: DejaVu Sans;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 5px;
            text-align: center;
        }

        .header {
            width: 100%;
            margin-bottom: 60px;
        }

        .row-item-1 {
            width: 45%;
            text-align: center;
            float: left;
        }

        .row-item-2 {
            width: 45%;
            margin-left: 100px;
            line-height: 5px;
            float: left;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="row-item-1">
        <p>ПРАВОДКА № {{ $n_id }}</p>
    </div>
    <div class="row-item-2">
        <p>{{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
        <p>{{ $year['year'] }} - йил
            @switch($month)
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
            ойи</p>
    </div>
</div>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>№</th>
        <th>Мазмуни</th>
        <th>КГ</th>
        <th>ДТ</th>
        <th>КТ</th>
        <th>Нархи</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $item)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td style="text-align: left">{{ $item->title }}</td>
            <td>{{ $item->weight }}</td>
            <td>{{ $item->dt }}</td>
            <td>{{ $item->kt }}</td>
            <td style="text-align: right">{{ number_format($item->price, 2, ',', ' ')  }}</td>
        </tr>
    @endforeach
    <tr style="font-weight: bold">
        <td></td>
        <td>ЖАМИ</td>
        <td>{{ number_format($sum['weight'], 0, ',', '') }}</td>
        <td>X</td>
        <td>X</td>
        <td style="text-align: right">{{ number_format($sum['price'], 2, ',', ' ')  }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
