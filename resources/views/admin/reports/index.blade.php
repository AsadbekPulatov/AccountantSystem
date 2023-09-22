@extends('admin.master')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">{{ __("messages.reports") }}</h3>
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
                                <form method="get" action="{{ route('reports.index') }}" id="form">
{{--                                    @csrf--}}
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="year">Йил:</label>
                                            <select name="year" id="year" class="form-control form-select"
                                                    onchange="selectYear()">
                                                <option value="">Барчаси</option>
                                                @foreach($years as $item)
                                                    <option value="{{$item->year}}">{{$item->year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="month">Ой:</label>
                                            <select name="month" id="month" class="form-control form-select"
                                                    onchange="selectMonth()">

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="n_id">ПРАВОДКА №:</label>
                                            <select name="n_id" id="n_id" class="form-control form-select">

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
                            <a href="{{ route('download.report.write',['year' => $year, 'month' => $month, 'n_id' => $n_id]) }}"
                               class="btn btn-info ml-3"><i
                                    class="fa fa-download"></i> {{ __("messages.download") }}</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ПРАВОДКА №</th>
                                <th>Сана</th>
                                <th>Мазмуни</th>
                                <th>КГ</th>
                                <th>ДТ</th>
                                <th>КТ</th>
                                <th>Суммаси</th>
                                <th>Амаллар</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $item)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$item->n_id}}</td>
                                    <td>
                                        @switch($item->month)
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
                                        {{$item->year}}
                                    </td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->weight}}</td>
                                    <td>{{$item->dt}}</td>
                                    <td>{{$item->kt}}</td>
                                    <td>{{number_format($item->price, 2, ',', ' ')}}</td>
                                    <td class="d-flex justify-content-center">

                                        <a href="{{ route('reports.edit', $item->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>


                                        <form action="{{route('reports.destroy', $item->id)}}" method="post">
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
                                <td>{{ number_format($sum['weight'], 0, ',', '') }}</td>
                                <td>X</td>
                                <td>X</td>
                                <td>{{ number_format($sum['price'], 2, ',', ' ') }}</td>
                                <td></td>
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
        function selectYear() {
            let year = document.getElementById('year').value;
            let month = document.getElementById('month');
            let table = '{{ $table }} ';
            let url = '{{ route('filter.selectYear') }}';
            let url2 = url + '?year=' + year + '&table=' + table;
            console.log(url2);
            fetch(url2)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    let options = '<option value="0">Барчаси</option>';
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].month + '">' + data[i].month + '</option>';
                    }
                    month.innerHTML = options;
                });
        }

        function selectMonth() {
            let year = document.getElementById('year').value;
            let month = document.getElementById('month').value;
            let n_id = document.getElementById('n_id');
            let table = '{{ $table }} ';
            let url = '{{ route('filter.selectMonth') }}';
            let url2 = url + '?year=' + year + '&month=' + month + '&table=' + table;
            console.log(url2);
            fetch(url2)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    let options = '<option value="0">Барчаси</option>';
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].n_id + '">' + data[i].n_id + '</option>';
                    }
                    n_id.innerHTML = options;
                });
        }
    </script>
@endsection
