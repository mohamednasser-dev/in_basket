@extends('admin.app')
@section('title' , __('messages.orders'))
@section('content')

    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.orders') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form action="{{route('orders.index')}}" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="alternate-masks1">المستخدم</label>
                                <select class="form-control" name="user_id">
                                    <option value="all_users" @if(request()->user_id == 'all_users') selected @endif >كل
                                        المستخدمين
                                    </option>
                                    @foreach (\App\User::whereHas('orders')->get() as $row)
                                        <option value='{{$row->id}}'
                                                @if(request()->user_id == $row->id) selected @endif
                                        > {{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="status">الحالة</label>
                                <select class="form-control" name="status">
                                    <option value="all" @if(request()->status == 'all') selected @endif >الكل</option>
                                    @foreach (\App\Order::STATUS as $row)
                                        <option
                                            value='{{$row}}'
                                            @if(request()->status == $row) selected @endif > {{trans('messages.'.$row)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="from_date">من يوم</label>
                                <input id="from_date" type="date" class="form-control" name="from_date"
                                       value="{{old('from_date',request()->from_date)}}"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="to_date">الى يوم</label>
                                <input id="to_date" type="date" class="form-control" name="to_date"
                                       value="{{old('to_date',request()->to_date)}}"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="justify-content: center;">
                        <button type="submit" class="btn btn-success">بحث</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center blue-color">{{ __('messages.order_code') }}</th>
                            <th class="text-center blue-color">{{ __('messages.customer_name') }}</th>
                            <th class="text-center blue-color">{{ __('messages.phone') }}</th>
                            <th class="text-center blue-color">{{ __('messages.address') }}</th>
                            <th class="text-center blue-color">{{ __('messages.date') }}</th>
                            <th class="text-center blue-color">{{ __('messages.products') }}</th>
                            <th class="text-center blue-color">{{ __('messages.status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-center blue-color">{{ $row->id }}</td>
                                <td class="text-center blue-color">{{ $row->user->name }}</td>
                                <td class="text-center blue-color">{{ $row->phone }}</td>
                                <td class="text-center blue-color">{{ $row->address }}</td>
                                <td class="text-center">{{ $row->created_at->format('Y-m-d') }}</td>
                                <td class="text-center blue-color"><a href="{{ route('orders.show', $row->id) }}"><i
                                            class="far fa-eye"></i></a></td>
                                <td>
                                    @if($row->status == 'new')
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm">{{ __('messages.new_order') }}</button>
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference5" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference5">
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'accept','id'=>$row->id])}}"
                                                   style="color: #2196f3; text-align: center;">{{ __('messages.accept_order') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'execution','id'=>$row->id])}}"
                                                   style="color: #f5b455; text-align: center;">{{ __('messages.make_it') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'arrived','id'=>$row->id])}}"
                                                   style="color: green; text-align: center;">{{ __('messages.arrived') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'rejected','id'=>$row->id])}}"
                                                   style="color: red; text-align: center;">{{ __('messages.reject') }}</a>
                                            </div>
                                        </div>
                                    @elseif($row->status == 'accept')
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-info btn-sm">{{ __('messages.accept_order') }}</button>
                                            <button type="button"
                                                    class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference5" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference5">
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'execution','id'=>$row->id])}}"
                                                   style="color: #f5b455; text-align: center;">{{ __('messages.make_it') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'arrived','id'=>$row->id])}}"
                                                   style="color: green; text-align: center;">{{ __('messages.arrived') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'rejected','id'=>$row->id])}}"
                                                   style="color: red; text-align: center;">{{ __('messages.reject') }}</a>
                                            </div>
                                        </div>
                                    @elseif($row->status == 'execution')
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-warning btn-sm">{{ __('messages.make_it') }}</button>
                                            <button type="button"
                                                    class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference5" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference5">
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'arrived','id'=>$row->id])}}"
                                                   style="color: green; text-align: center;">{{ __('messages.arrived') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change.status',['status'=> 'rejected','id'=>$row->id])}}"
                                                   style="color: red; text-align: center;">{{ __('messages.reject') }}</a>
                                            </div>
                                        </div>
                                    @elseif($row->status == 'arrived')
                                        <h5 style="color:green;">{{ __('messages.arrived') }}</h5>
                                    @elseif($row->status == 'rejected')
                                        <h5 style="color:red;">{{ __('messages.rejected') }}</h5>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script>
                $(".tagging").select2({});

                var formSmall = $(".form-small").select2({tags: true});
                formSmall.data('select2').$container.addClass('form-control-sm')
            </script>
@endsection
