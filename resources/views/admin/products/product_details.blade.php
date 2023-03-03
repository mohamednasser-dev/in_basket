@extends('admin.app')

@section('title' , __('messages.product_details'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.product_details') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered mb-4">
                        <tbody>
                        <tr>
                            <td class="label-table"><h6> {{ __('messages.publication_date') }}</h6></td>
                            <td>
                                @if( $data->publication_date != null)
                                    {{date('Y-m-d', strtotime($data->publication_date))}}
                                @else
                                    {{ __('messages.not_publish_yet') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"><h6>{{ __('messages.product_name') }}</h6></td>
                            <td>
                                {{ $data->title }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"><h6> {{ __('messages.category') }} </h6></td>
                            <td>
                                {{ $data->category->title_ar }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"><h6> {{ __('messages.sub_category_first') }} </h6></td>
                            <td>
                                {{ $data->sub_category->title_ar }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"><h6> {{ __('messages.product_description') }}</h6></td>
                            <td>
                                {{ $data->description }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"><h6>{{ __('messages.product_price') }} </h6></td>
                            <td>
                                {{ $data->price }} {{ __('messages.dinar') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"><h6>{{ __('messages.discount') }} </h6></td>
                            <td>
                                {{ $data->offer }} %
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h4>{{ __('messages.unites') }}</h4><br>

                    <div id="unit_container">
                        @if(count($data->productUnits) > 0 )
                            @foreach($data->productUnits as $key => $row)
                                <div class="row" id="unit_old_row_{{$key}}">
                                    <div class="col-md-3">
                                        <label for="offer">{{ __('messages.unit_ar') }}</label>
                                        <input style="background-color: white !important;" required type="text" class="form-control" min="0" maxlength="255" readonly
                                               value="{{$row->unit_ar}}"
                                               name="unites[{{$key}}][unit_ar]">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="offer">{{ __('messages.unit_en') }}</label>
                                        <input style="background-color: white !important;"  required type="text" class="form-control" min="0" maxlength="255" readonly
                                               value="{{$row->unit_en}}"
                                               name="unites[{{$key}}][unit_en]">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="offer">{{ __('messages.quantity') }}</label>
                                        <input style="background-color: white !important;"  required type="number" class="form-control" min="0" readonly
                                               name="unites[{{$key}}][quantity]" value="{{$row->quantity}}"
                                               placeholder="{{ __('messages.quantity') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="offer">{{ __('messages.price') }}</label>
                                        <input style="background-color: white !important;"  required type="number" class="form-control" min="0" readonly
                                               name="unites[{{$key}}][price]" value="{{$row->price}}"
                                               placeholder="{{ __('messages.price') }}">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <br>
                    <h4>{{ __('messages.main_image') }}</h4><br>
                    <div class="row">
                        <div class="col-md-2 product_image">
                            <img class="img-thumbnail" style="width: 150px; height: 150px;" src="{{ $data->image }}"/>
                        </div>
                    </div>
                    <h4 style="margin-top: 20px">{{ __('messages.product_images') }}</h4><br>
                    <div class="row">
                        @foreach ($data->images as $image)
                            <div style="position : relative" class="col-md-2 product_image">
                                <img class="img-thumbnail" style="width: 100px; height: 100px;"
                                     src="{{ $image->image }}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

@endsection
