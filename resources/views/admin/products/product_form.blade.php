@extends('admin.app')
@section('title' , __('messages.add_new_product'))
@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_new_product') }}</h4>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-danger mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                        <strong>Error!</strong> {{ session('status') }} </button>
                    </div>
                @endif
                <form method="post" enctype="multipart/form-data" action="">
                    @csrf
                    <div class="form-group">
                        @php $cats = \App\Category::where('deleted',0)->get(); @endphp
                        <label for="sel1">{{ __('messages.category') }}</label>
                        <select required class="form-control" name="category_id" id="cmb_cat">
                            <option selected disabled>{{ __('messages.choose_category') }}</option>
                            @foreach ($cats as $row)
                                @if( app()->getLocale() == 'en')
                                    <option value="{{ $row->id }}">{{ $row->title_en }}</option>
                                @else
                                    <option value="{{ $row->id }}">{{ $row->title_ar }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="sub_cat_cont" style="display:none;">
                        @php $sub_cats = \App\SubCategory::where('deleted',0)->get(); @endphp
                        <label for="sel1">{{ __('messages.sub_category_first') }}</label>
                        <select required class="form-control" name="sub_category_id" id="cmb_sub_cat">
                            <option selected disabled>{{ __('messages.choose_sub_category') }}</option>
                            @foreach ($sub_cats as $row)
                                @if( app()->getLocale() == 'en')
                                    <option value="{{ $row->id }}">{{ $row->title_en }}</option>
                                @else
                                    <option value="{{ $row->id }}">{{ $row->title_ar }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="title_ar">{{ __('messages.product_name_ar') }}</label>
                        <input required type="text" name="title_ar" class="form-control" id="title_ar"
                               placeholder="{{ __('messages.product_name_ar') }}" value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="title_en">{{ __('messages.product_name_en') }}</label>
                        <input required type="text" name="title_en" class="form-control" id="title_en"
                               placeholder="{{ __('messages.product_name_en') }}" value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="price">الكمية الحالية في المخزن</label>
                        <input required type="number" class="form-control" min="0" id="stock" name="stock"
                               placeholder="الكمية الحالية في المخزن" value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="price">كمية التنبية</label>
                        <input required type="number" class="form-control" min="0" id="stock_alert" name="stock_alert"
                               placeholder="كمية التنبية" value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="price">{{ __('messages.product_price') }}</label>
                        <input required type="number" class="form-control" step="any" min="0" id="price" name="price"
                               placeholder="{{ __('messages.product_price') }}" value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="offer">{{ __('messages.discount') }} (%)</label>
                        <input required type="number" class="form-control"  min="0" max="100" id="offer" name="offer"
                               placeholder="{{ __('messages.discount') }}" value="0">
                    </div>
                    <div class="form-group mb-4 arabic-direction">
                        <label for="description_ar">{{ __('messages.product_description_ar') }}</label>
                        <textarea name="description_ar"
                                  placeholder="{{ __('messages.product_description_ar') }}"
                                  class="form-control" id="description_ar" rows="5"></textarea>
                    </div>
                    <div class="form-group mb-4 arabic-direction">
                        <label for="description_en">{{ __('messages.product_description_en') }}</label>
                        <textarea name="description_en"
                                  placeholder="{{ __('messages.product_description_en') }}"
                                  class="form-control" id="description_en" rows="5"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="offer">{{ __('messages.unites') }}</label>
                        <div class="col-md-1">
                            <a class="form-control btn btn-success" id="add_unit"><i class="fa fa-plus"></i></a>
                        </div>
                        <div id="unit_container">

                        </div>
                    </div>


                    <div class="form-group mb-4 mt-3">
                        <label for="exampleFormControlFile1">{{ __('messages.main_image') }}</label>

                        <div class="custom-file-container" data-upload-id="mySecondImage">
                            <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a
                                    href="javascript:void(0)" class="custom-file-container__image-clear"
                                    title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file">
                                <input type="file" required name="main_image"
                                       class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview">

                            </div>
                        </div>
                    </div>
                    <h4>{{ __('messages.ad_images') }}</h4>
                    <div class="custom-file-container" data-upload-id="myFirstImage">
                        <label>{{ __('messages.upload') }} ({{ __('messages.multiple_images') }}) <a
                                href="javascript:void(0)" class="custom-file-container__image-clear"
                                title="Clear Image">x</a></label>
                        <label class="custom-file-container__custom-file">
                            <input type="file" name="images[]" multiple
                                   class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        <div class="custom-file-container__image-preview"></div>
                    </div>
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
