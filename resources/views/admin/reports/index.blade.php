@extends('admin.master')
{{--@section('title', 'Бажарилган ишлар')--}}
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
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="from_date">Санадан:</label>
                                            <input type="date" name="from_date" class="form-control" id="from_date"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="to_date">Санагача:</label>
                                            <input type="date" name="to_date" class="form-control" id="to_date"
                                                   required>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Бекор қилиш
                                        </button>
                                        <button type="submit" class="btn btn-primary">Сақлаш</button>
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
                                <th>Нархи</th>
                                <th>Амаллар</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $item)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$item->n_id}}</td>
                                    <td>{{$item->month}} {{$item->year}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->weight}}</td>
                                    <td>{{$item->dt}}</td>
                                    <td>{{$item->kt}}</td>
                                    <td>{{number_format($item->price, 0, ' ', ' ')}}</td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-md-6 -->
    </div>
@endsection
