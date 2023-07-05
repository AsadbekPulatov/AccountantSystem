@extends('admin.master')
{{--@section('title', 'Бажарилган ишлар')--}}
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large">{{ __("messages.users") }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __("messages.user") }}</th>
                                <th>{{ __("messages.email") }}</th>
                                <th>{{ __("messages.roles") }}</th>
                                <th>{{ __("messages.phone") }}</th>
                                <th>{{ __("messages.status") }}</th>
                                <th>Амаллар</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm">{{ $item->role }}</button>
                                    </td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <button class="btn btn-success btn-sm">{{ __("messages.active") }}</button>
                                        @else
                                            <button class="btn btn-danger btn-sm">{{ __("messages.inactive") }}</button>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        @if ($item->role != 'admin')

                                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-warning">
                                                <i class="fa fa-check-circle"></i>
                                            </a>


                                            <form action="{{route('users.destroy', $item->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger show_confirm"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
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
@endsection
