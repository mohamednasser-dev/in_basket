@extends('admin.app')

@section('title' , __('messages.reviews'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">

                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.reviews') }} {{ isset($data['user']) ? '( ' . $data['user'] . ' )' : '' }} {{ isset($data['category']) ? '( ' . $data['category'] . ' )' : '' }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">اسم المستخدم</th>
                            <th class="text-center">التقييم</th>
                            <th class="text-center">التعليق</th>
                            @if(Auth::user()->delete_data)
                                <th class="text-center">{{ __('messages.delete') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-center">{{ $row->user->name }}</td>
                                <td class="text-center">{{ $row->rate }}</td>
                                <td class="text-center">{{ $row->comment }}</td>
                                @if(Auth::user()->delete_data)
                                    <td class="text-center blue-color"><a
                                            onclick="return confirm('{{ __('messages.are_you_sure') }}');"
                                            href="{{ route('reviews.delete', $row->id) }}"><i
                                                class="far fa-trash-alt"></i></a></td>
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="paginating-container pagination-solid">
                <ul class="pagination">
                    <li class="prev"><a href="{{$data['products']->previousPageUrl()}}">Prev</a></li>
                    @for($i = 1 ; $i <= $data['products']->lastPage(); $i++ )
                        <li class="{{ $data['products']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/users/show?page={{$i}}">{{$i}}</a></li>
                    @endfor
                    <li class="next"><a href="{{$data['products']->nextPageUrl()}}">Next</a></li>
                </ul>
            </div>   --}}
        </div>
@endsection

