@extends('admin.master')
{{--@section('title', 'Бажарилган ишлар')--}}
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">{{ __("messages.debts") }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div>
                            <a href="{{ route('debts.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i> {{ __("messages.add") }}
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Счёт раками</th>
                                <th>Йил</th>
                                <th>Дт мик</th>
                                <th>Дт сумма</th>
                                <th>Кт мик</th>
                                <th>Кт сумма</th>
                                <th>Амаллар</th>
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
                                    <td class="d-flex justify-content-center">

                                        <a href="{{ route('debts.edit', $item->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>


                                        <form action="{{route('debts.destroy', $item->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger show_confirm"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            <tr class="text-bold">
                                <td colspan="3">ЖАМИ</td>
                                <td></td>
                                <td>{{number_format($sum['dt_price'], 2, ',', ' ')}}</td>
                                <td></td>
                                <td>{{number_format($sum['kt_price'], 2, ',', ' ')}}</td>
                                <td class="d-flex justify-content-center"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-md-6 -->
    </div>
@endsection
