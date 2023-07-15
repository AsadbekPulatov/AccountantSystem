@extends('admin.master')
{{--@section('title', 'Бажарилган ишлар')--}}
@section('content')
    <style>
        .table-row {
            background-color: #bdbdbd;
            font-weight: bold;
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">{{ __("messages.reports.calculate") }}</h3>
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
                                <form method="get" action="{{ route('reports.calculate') }}" id="form">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="year">Йил:</label>
                                            <select name="year" id="year" class="form-control form-select"
                                                    onchange="find()">
                                                <option value="">Барчаси</option>
                                                @foreach($years as $year)
                                                    <option value="{{$year}}">{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Multiple</label>
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
                            <a href="{{ route('reports.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i> {{ __("messages.add") }}
                            </a>
                        </div>
                        <button type="button" class="ml-3 btn btn-info" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-filter"></i> {{ __("messages.filter") }}
                        </button>
                        <div>
                            <a href="" class="btn btn-info ml-3"><i
                                    class="fa fa-download"></i> {{ __("messages.download") }}</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered">
                            <thead>
                            <tr style="background-color: #6767f1; font-weight: bold">
                                <th>#</th>
                                <th>Сана</th>
                                <th>№</th>
                                <th>Мазмуни</th>
                                <th>ДТ КГ</th>
                                <th>ДТ сумма</th>
                                <th>КТ КГ</th>
                                <th>КТ сумма</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $item)
                                <tr class="table-row">
                                    <td colspan="8">СЧЁТ № {{ $key }}</td>
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
                                                {{number_format($value->price, 0, ' ', ' ')}}
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
                                                {{number_format($value->price, 0, ' ', ' ')}}
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
                                    <td>{{number_format($item['dt_price'], 0, ' ', ' ')}}</td>
                                    <td>{{$item['kt_weight']}}</td>
                                    <td>{{number_format($item['kt_price'], 0, ' ', ' ')}}</td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>01.01.{{ $value->year + 1 }} - йилга колдик</td>
                                    <td>
                                        @if ($item['dt_weight'] > $item['kt_weight'])
                                            {{$item['dt_weight'] - $item['kt_weight']}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['dt_price'] > $item['kt_price'])
                                            {{number_format($item['dt_price'] - $item['kt_price'], 0, ' ', ' ')}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['kt_weight'] > $item['dt_weight'])
                                            {{$item['kt_weight'] - $item['dt_weight']}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['kt_price'] > $item['dt_price'])
                                            {{number_format($item['kt_price'] - $item['dt_price'], 0, ' ', ' ')}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
            $.ajax({
                url: "{{ route('filter.findDtKt') }}",
                type: "GET",
                data: {year: year, table: table},
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
