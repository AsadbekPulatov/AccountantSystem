@extends('admin.master')
{{--@section('title', 'Бажарилган ишларни киритиш')--}}
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">Колдиқни киритиш</h3>
                </div>
                {{--                <div class="card-body">--}}
                <form method="post" action="{{route('debts.store')}}" id="form">
                    @csrf
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="form-group w-100">
                                <label for="dtkt">Счёт раками:</label>
                                <input type="number" name="dtkt" class="form-control" id="dtkt" required>
                            </div>
                            <div class="form-group w-100 ml-3">
                                <label for="year">Йил:</label>
                                <input type="number" name="year" class="form-control" id="year" required min="1900" max="2100" value="2000">
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-group w-100">
                                <label for="dt_weight">Дт мик:</label>
                                <input type="text" name="dt_weight" class="form-control" id="dt_weight" required value="0">
                            </div>
                            <div class="form-group w-100 ml-3">
                                <label for="dt_price">Дт сумма:</label>
                                <input type="text" name="dt_price" class="form-control" id="dt_price" required value="0">
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-group w-100">
                                <label for="kt_weight">Кт мик:</label>
                                <input type="text" name="kt_weight" class="form-control" id="kt_weight" required value="0">
                            </div>
                            <div class="form-group w-100 ml-3">
                                <label for="kt_price">Кт сумма:</label>
                                <input type="text" name="kt_price" class="form-control" id="kt_price" required value="0">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary mr-3">{{ __("messages.save") }}</button>
                    </div>
                </form>
                {{--                </div>--}}
            </div>

        </div>
        <!-- /.col-md-6 -->
    </div>
@endsection
