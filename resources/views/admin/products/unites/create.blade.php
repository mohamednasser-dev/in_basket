@extends('admin.app')
@section('title' , 'إضافة وحدة جديدة للمنتج')
@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>إضافة وحدة جديدة للمنتج</h4>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-danger mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                        <strong>Error!</strong> {{ session('status') }} </button>
                    </div>
                @endif
                <form method="post" enctype="multipart/form-data" action="{{route('unites.store')}}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product_id}}">
                    @include('admin.products.unites.form')
                    <input type="submit" value="{{ __('messages.add') }}" class="btn btn-primary">
                </form>
            </div>
            @endsection
            @section('scripts')
                <script src="/admin/assets/js/generate_categories.js"></script>
                <script>
                    $(".tagging").select2({
                        tags: true
                    });
                </script>

                <script>
                    $(document).ready(function () {
                        var i = 0;
                        $("#add_unit").click(function () {
                            var html = '';
                            html += '<div class="row" id="unit_row_' + i + '">' +
                                '<div class="col-md-3">' +
                                '<label for="offer">{{ __('messages.unit_ar') }}</label>' +
                                '<input required type="text" class="form-control" min="0" maxlength="255" name="unites[' + i + '][unit_ar]">' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label for="offer">{{ __('messages.unit_en') }}</label>' +
                                '<input required type="text" class="form-control" min="0" maxlength="255" name="unites[' + i + '][unit_en]">' +
                                '</div>' +
                                '<div class="col-md-2">' +
                                '<label for="offer">{{ __('messages.quantity') }}</label>' +
                                '<input required type="number" class="form-control" min="0" name="unites[' + i + '][quantity]"' +
                                '  placeholder="{{ __('messages.quantity') }}" value="0">' +
                                ' </div>' +
                                ' <div class="col-md-3">' +
                                ' <label for="offer">{{ __('messages.price') }}</label>' +
                                ' <input required type="number" class="form-control" min="0" name="unites[' + i + '][price]"' +
                                ' placeholder="{{ __('messages.price') }}" value="0">' +
                                '</div>' +
                                ' <div class="col-md-1">' +
                                ' <label for="offer">{{ __('messages.delete') }}</label>' +
                                ' <a class="form-control btn btn-danger" onclick="delete_row(' + i + ')" ><i class="fa fa-trash"></i></a>' +
                                '</div>' +
                                '</div>';

                            $('#unit_container').append(html);
                            i++;
                        });
                    });

                    function delete_row(i) {
                        $('#unit_row_' + i).remove();
                    }
                </script>
@endsection
