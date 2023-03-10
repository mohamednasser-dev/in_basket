@extends('admin.app')

@section('title' , __('messages.ad_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.ad_details') }}</h4>

                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table class="table table-bordered mb-4">
                    <tbody>
                            <tr>
                                <td class="label-table" > {{ __('messages.image') }}</td>
                                <td>
                                    <img style="height: 100px;" src="{{ $data['ad']['image'] }}"  />
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.ad_type') }}</td>
                                <td>
                                    {{ $data['ad']['type'] == 'link' ? __('messages.outside_the_app') : __('messages.inside_the_app') }}
                                </td>
                            </tr>
                            @if ($data['ad']['type'] == 'link')
                            <tr>
                                <td class="label-table" > {{ __('messages.link') }} </td>
                                <td>
                                    <a target="_blank" href="{{ $data['ad']['content'] }}" >
                                        {{ $data['ad']['content'] }}
                                    </a>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td class="label-table" > {{ __('messages.user') }} </td>
                                <td>
                                    <a target="_blank" href="/admin-panel/users/details/{{ $data['product']['user']['id'] }}" >
                                        {{ $data['product']['user']['name'] }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.product') }} </td>
                                <td>
                                    <a target="_blank" href="{{ route('products.details', $data['product']['id']) }}" >
                                        {{ $data['product']['title'] }}
                                    </a>
                                </td>
                            </tr>
                            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
