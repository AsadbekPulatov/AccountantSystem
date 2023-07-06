@extends('admin.master')
{{--@section('title', 'Бажарилган ишларни киритиш')--}}
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">Бажарилган ишларни киритиш</h3>
                </div>
                {{--                <div class="card-body">--}}
                <form method="post" action="{{route('reports.store')}}" id="form">
                    @csrf
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
                        <div class="form-group w-100 ml-3 grid" id="grid">

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary mr-3">{{ __("messages.save") }}</button>
                        <button type="button" class="btn btn-success"
                                onclick="add_row()">{{ __("messages.add") }}</button>
                    </div>
                </form>
                {{--                </div>--}}
            </div>

        </div>
        <!-- /.col-md-6 -->
    </div>
@endsection
@section('custom-scripts')
    <script>
        function add_row() {

            // Create the row container
            var rowContainer = document.createElement('div');
            rowContainer.setAttribute('class', 'row d-flex mt-3 w-100');

            // Create six input elements
            var TitleElement = document.createElement('input');
            TitleElement.setAttribute('type' , 'string');
            TitleElement.setAttribute('class' , 'form-control col-4 ml-1');
            TitleElement.setAttribute('name' , 'title[]');
            TitleElement.setAttribute('placeholder' , 'Мазмуни');
            rowContainer.appendChild(TitleElement);

            var WeightElement = document.createElement('input');
            WeightElement.setAttribute('type' , 'number');
            WeightElement.setAttribute('class' , 'form-control col-1 ml-1');
            WeightElement.setAttribute('name' , 'weight[]');
            WeightElement.setAttribute('placeholder' , 'КГ');
            rowContainer.appendChild(WeightElement);

            var DtElement = document.createElement('input');
            DtElement.setAttribute('type' , 'number');
            DtElement.setAttribute('class' , 'form-control col-2 ml-1');
            DtElement.setAttribute('name' , 'dt[]');
            DtElement.setAttribute('placeholder' , 'ДТ');
            rowContainer.appendChild(DtElement);

            var KtElement = document.createElement('input');
            KtElement.setAttribute('type' , 'number');
            KtElement.setAttribute('class' , 'form-control col-2 ml-1');
            KtElement.setAttribute('name' , 'kt[]');
            KtElement.setAttribute('placeholder' , 'КТ');
            rowContainer.appendChild(KtElement);

            var PriceElement = document.createElement('input');
            PriceElement.setAttribute('type' , 'string');
            PriceElement.setAttribute('class' , 'form-control col-2 ml-1');
            PriceElement.setAttribute('name' , 'price[]');
            PriceElement.setAttribute('placeholder' , 'Суммаси');
            rowContainer.appendChild(PriceElement);

            // Append the row container to the grid container
            var gridContainer = document.getElementById('grid');
            gridContainer.appendChild(rowContainer);
        }
    </script>
@endsection
