@extends('admin.app')

@section('title' , __('messages.add'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add') }}</h4>
                    </div>
                </div>
            </div>
            <form action="{{route('coupons.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group  col-12">
                    <label>كود الكوبون<span
                            class="text-danger">*</span></label>
                    <input required name="code"
                           value="{{ old('code', $data->code ?? '') }}"
                           class="form-control  {{ $errors->has('code') ? 'border-danger' : '' }}" type="text"
                           maxlength="255"/>
                </div>
                <div class="form-group  col-6">
                    <label>من تاريخ<span
                            class="text-danger">*</span></label>
                    <input required name="from_date" value="{{ old('from_date', $data->from_date ?? '') }}"
                           class="form-control  {{ $errors->has('from_date') ? 'border-danger' : '' }}" type="date"
                    />
                </div>
                <div class="form-group  col-6">
                    <label>الى تاريخ<span
                            class="text-danger">*</span></label>
                    <input required name="to_date" value="{{ old('to_date', $data->to_date ?? '') }}"
                           class="form-control  {{ $errors->has('to_date') ? 'border-danger' : '' }}" type="date"
                    />
                </div>
                <div class="form-group  col-6">
                    <label>مقدار الخصم ( بالنسبة المئوية % ) <span
                            class="text-danger">*</span></label>
                    <input required name="amount" min="0" max="100" value="{{ old('amount', $data->amount ?? '') }}"
                           class="form-control  {{ $errors->has('amount') ? 'border-danger' : '' }}" type="number"
                           step="any"
                    />
                </div>
                <input type="submit" value="{{ __('messages.add') }}" class="btn btn-primary">
            </form>
        </div>
@endsection
