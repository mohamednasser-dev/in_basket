@extends('admin.app')

@section('title' , 'Admin Panel Home')

@section('content')

    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <a href="{{ route('products.index') }}">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"> {{ $data['products'] }}</h6>
                                <p class="">{{ __('messages.products_count') }}</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-gradient-secondary" role="progressbar"
                                 style="width: {{ $data['products'] }}%" aria-valuenow="{{ $data['products'] }}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <a href="admin-panel/users/show">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value">{{ $data['users'] }}</h6>
                                <p class=""> {{ __('messages.users_count') }}</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-gradient-secondary" role="progressbar"
                                 style="width: {{ $data['users'] }}%" aria-valuenow="{{ $data['users'] }}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <a href="{{route('orders.index')}}">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value">{{ $data['orders'] }}</h6>
                                <p class=""> {{ __('messages.orders_count') }}</p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-inbox">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path
                                            d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-gradient-secondary" role="progressbar"
                                 style="width: {{ $data['orders'] }}%" aria-valuenow="{{ $data['orders'] }}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

@endsection

