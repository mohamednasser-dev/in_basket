@extends('admin.app')

@section('title' , __('messages.show_users'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <h4>{{ __('messages.show_users') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.user_name') }}</th>
                            <th>{{ __('messages.user_phone') }}</th>
                            <th class="text-center">{{ __('messages.block_active') }}</th>
                        <!-- <th class="text-center">{{ __('messages.send_balance') }}</th> -->
                            <th class="text-center">{{ __('messages.last_order_date') }}</th>
                            <th class="text-center">متى اخر طلب ؟</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
                        <!-- <th class="text-center">{{ __('messages.products') }}</th> -->
                            @if(Auth::user()->update_data)
                                <th class="text-center">{{ __('messages.edit') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['users'] as $user)
                            <tr @if($user->diff_days > 30 || $user->diff_days == 0) style="background-color: #ff9999;"
                                @endif class="{{$user->seen == 0 ? 'unread' : '' }}">
                                <td><?=$i;?></td>
                                <td><h6>{{ $user->name }}</h6></td>
                                <td><h6>{{ $user->phone }}</h6></td>
                                <td class="text-center">
                                    @if($user->active)
                                        <a href="/admin-panel/users/block/{{$user->id}}">
                                            <span class="badge badge-danger">{{ __('messages.block') }}</span>
                                        </a>
                                    @else
                                        <a href="/admin-panel/users/active/{{$user->id}}">
                                            <span class="badge badge-success">{{ __('messages.active') }}</span>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <h6>{{ $user->last_order ? \Carbon\Carbon::createFromTimeStamp(strtotime($user->last_order->created_at))->diffForHumans() : ''}}</h6>
                                </td>
                                <td class="text-center"><h6>{{  $user->diff_days }} يوم</h6></td>
                            <!-- <td>
                                    <a class="btn btn-warning mb-2 mr-2 btn-rounded" data-user="{{$user->id}}"
                                       id="btn_send" data-toggle="modal"
                                       data-target="#zoomupModal">{{ __('messages.send_balance') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-briefcase">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </a>
                        </td> -->
                                <td class="text-center blue-color"><a href="/admin-panel/users/details/{{ $user->id }}"><i
                                            class="far fa-eye"></i></a></td>
                            <!-- <td class="text-center blue-color"><a href="{{ route('user.products', $user->id) }}"><i
                                            class="far fa-eye"></i></a></td> -->
                                @if(Auth::user()->update_data)
                                    <td class="text-center blue-color"><a
                                            href="/admin-panel/users/edit/{{ $user->id }}"><i
                                                class="far fa-edit"></i></a></td>
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--model--}}
        @endsection
        @section('scripts')
            <script>
                $(document).ready(function () {
                    $(document).on('click', '#btn_send', function () {
                        user_id = $(this).data('user');
                        $("#txt_user_id").val(user_id);
                    });
                });
            </script>
@endsection

