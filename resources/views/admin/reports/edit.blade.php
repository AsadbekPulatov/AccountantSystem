@extends('admin.master')
{{--@section('title', 'Бажарилган ишларни таҳрирлаш')--}}
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">Бажарилган ишларни таҳрирлаш</h3>
                </div>
{{--                <div class="card-body">--}}
                    <form method="post" action="{{route('reports.update', $report->id)}}" id="form">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="form-group w-100">
                                    <label for="n_id">ПРАВОДКА №:</label>
                                    <input type="number" name="n_id" class="form-control" id="n_id" required min="1"
                                           max="10" value="1">
                                </div>
                                <div class="form-group w-100 ml-3">
                                    <label for="year">Йил:</label>
                                    <input type="number" name="year" class="form-control" id="year" required min="1900"
                                           max="2100" value="2000">
                                </div>
                                <div class="form-group w-100 ml-3">
                                    <label for="month">Ой:</label>
                                    <select name="month" class="form-control form-select" id="month" required>
                                        <option value="{{ __("messages.january") }}">{{ __("messages.january") }}</option>
                                        <option value="{{ __("messages.february") }}">{{ __("messages.february") }}</option>
                                        <option value="{{ __("messages.march") }}">{{ __("messages.march") }}</option>
                                        <option value="{{ __("messages.april") }}">{{ __("messages.april") }}</option>
                                        <option value="{{ __("messages.may") }}">{{ __("messages.may") }}</option>
                                        <option value="{{ __("messages.june") }}">{{ __("messages.june") }}</option>
                                        <option value="{{ __("messages.july") }}">{{ __("messages.july") }}</option>
                                        <option value="{{ __("messages.august") }}">{{ __("messages.august") }}</option>
                                        <option
                                            value="{{ __("messages.september") }}">{{ __("messages.september") }}</option>
                                        <option value="{{ __("messages.october") }}">{{ __("messages.october") }}</option>
                                        <option value="{{ __("messages.november") }}">{{ __("messages.november") }}</option>
                                        <option value="{{ __("messages.december") }}">{{ __("messages.december") }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">Мазмуни:</label>
                                <input type="text" name="title" class="form-control" id="title" required value="{{ $report->title }}">
                            </div>
                            <div class="form-group">
                                <label for="weight">КГ:</label>
                                <input type="number" name="weight" class="form-control" id="weight" required value="{{ $report->weight }}">
                            </div>
                            <div class="form-group">
                                <label for="dt">ДТ:</label>
                                <input type="number" name="dt" class="form-control" id="dt" required value="{{ $report->dt }}">
                            </div>
                            <div class="form-group">
                                <label for="kt">КТ:</label>
                                <input type="number" name="kt" class="form-control" id="kt" required value="{{ $report->kt }}">
                            </div>
                            <div class="form-group">
                                <label for="price">Суммаси:</label>
                                <input type="text" name="price" class="form-control" id="price" required value="{{ $report->price }}">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">{{ __("messages.save") }}</button>
                        </div>
                    </form>
{{--                </div>--}}
            </div>

        </div>
        <!-- /.col-md-6 -->
    </div>
    <script>

    </script>
@endsection
