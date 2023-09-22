@extends('admin.master')
{{--@section('title', 'Бажарилган ишлар')--}}
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">{{ __("messages.debts") }}</h3>
                </div>
                <div class="modal fade" id="modal-create">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __("messages.filter") }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="{{ route('debts.index') }}" id="form">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="year">Йил:</label>
                                            <select name="year" id="year" class="form-control form-select"
                                                    onchange="find()">
                                                <option value="">Барчаси</option>
                                                @foreach($years as $item)
                                                    <option value="{{$item}}">{{$item}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Счёт раками</label>
                                            <select id="dtkt" class="select2" name="dtkt[]" multiple="multiple"
                                                    data-placeholder="Барчаси" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal">{{ __("messages.close") }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">{{ __("messages.save") }}</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div>
                            <a href="{{ route('debts.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i> {{ __("messages.add") }}
                            </a>
                        </div>
                        <button type="button" class="btn btn-info ml-3" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-filter"></i> {{ __("messages.filter") }}
                        </button>
                        <div>
                            <a href="{{ route('download.report.debts', ['year' => $year, 'dtkt' => $dtkt]) }}"
                               class="btn btn-info ml-3"><i
                                    class="fa fa-download"></i> {{ __("messages.download") }}</a>
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
                            <tr class="text-bold">
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
    <script>
        $('#dtkt').select2({
            theme: "classic",
        });

        function find() {
            let year = $('#year').val();
            let table = 'reports_{{ \Illuminate\Support\Facades\Auth::id() }}';
            let debts_table = 'debts_{{ \Illuminate\Support\Facades\Auth::id() }}';
            $.ajax({
                url: "{{ route('filter.findDtKt') }}",
                type: "GET",
                data: {year: year, table: table, debts_table: debts_table, page: "debt"},
                success: function (data) {
                    $('#dtkt').empty();
                    $.each(data, function (key, value) {
                        $('#dtkt').append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        }
    </script>
@endsection
