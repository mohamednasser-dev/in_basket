@extends('admin.app')

@section('title' , __('messages.cities'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <h4>{{ __('messages.cities') }}</h4>
                    </div>
                </div>
                @if(Auth::user()->add_data)
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <a class="btn btn-primary" href="{{route('cities.create')}}">{{ __('messages.add') }}</a>
                    </div>
                @endif
            </div>
            <div class="widget-content widget-content-area">
                <div clSass="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">{{ __('messages.name') }}</th>
                            <th class="text-center">{{ __('messages.shipping_cost') }}</th>
                            @if(Auth::user()->update_data)
                                <th class="text-center">{{ __('messages.edit') }}</th>
                            @endif
                            @if(Auth::user()->delete_data)
                                <th class="text-center">{{ __('messages.delete') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-center"><?=$i;?></td>
                                <td class="text-center blue-color">{{ $row->title }}</td>
                                <td class="text-center blue-color">{{ $row->shipping_cost }}</td>
                                @if(Auth::user()->update_data)
                                    <td class="text-center blue-color"><a href="{{ route('cities.edit', $row->id) }}"><i
                                                class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data)
                                    <td class="text-center blue-color"><a
                                            onclick="return confirm('{{ __('messages.are_you_sure') }}');"
                                            href="{{ route('delete.cities', $row->id) }}"><i
                                                class="far fa-trash-alt"></i></a></td>
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
