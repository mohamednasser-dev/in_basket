@extends('admin.app')

@section('title' , __('messages.product_edit') )

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.product_edit') }}</h4>

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

                    {{--// 0--}}
                    <div class="form-group">
                        @php $cats = \App\Category::where('deleted',0)->get(); @endphp
                        <label for="sel1">{{ __('messages.category') }}</label>
                        <select required class="form-control" name="category_id" id="cmb_cat">
                            <option selected disabled>{{ __('messages.choose_category') }}</option>
                            @foreach ($cats as $row)
                                @if($data->category_id  == $row->id)
                                    @if( app()->getLocale() == 'en')
                                        <option value="{{ $row->id }}" selected>{{ $row->title_en }}</option>
                                    @else
                                        <option value="{{ $row->id }}" selected>{{ $row->title_ar }}</option>
                                    @endif
                                @else
                                    @if( app()->getLocale() == 'en')
                                        <option value="{{ $row->id }}">{{ $row->title_en }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->title_ar }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    {{--// 1--}}
                    <div class="form-group" id="sub_cat_cont">
                        @php $sub_cats = \App\SubCategory::where('deleted',0)->get(); @endphp
                        <label for="sel1">{{ __('messages.sub_category_first') }}</label>
                        <select required class="form-control" name="sub_category_id" id="cmb_sub_cat">
                            <option selected disabled>{{ __('messages.choose_sub_category') }}</option>
                            @foreach ($sub_cats as $row)
                                @if($data->sub_category_id  == $row->id)
                                    @if( app()->getLocale() == 'en')
                                        <option value="{{ $row->id }}" selected>{{ $row->title_en }}</option>
                                    @else
                                        <option value="{{ $row->id }}" selected>{{ $row->title_ar }}</option>
                                    @endif
                                @else
                                    @if( app()->getLocale() == 'en')
                                        <option value="{{ $row->id }}">{{ $row->title_en }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->title_ar }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="title_ar">{{ __('messages.product_name_ar') }}</label>
                        <input required type="text" name="title_ar" value="{{$data->title_ar}}" class="form-control"
                               id="title_ar"
                               placeholder="{{ __('messages.product_name_ar') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="title_en">{{ __('messages.product_name_en') }}</label>
                        <input required type="text" name="title_en" value="{{$data->title_en}}" class="form-control"
                               id="title_en"
                               placeholder="{{ __('messages.product_name_en') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="price">{{ __('messages.product_price') }}</label>
                        <input required type="number" class="form-control" value="{{$data->price}}" step="any" min="0"
                               id="price" name="price"
                               placeholder="{{ __('messages.product_price') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="offer">{{ __('messages.discount') }} (%)</label>
                        <input required type="number" class="form-control" min="0" max="100" id="offer"
                               name="offer"
                               placeholder="{{ __('messages.discount') }}" value="{{$data->offer}}">
                    </div>
                    <h4>{{ __('messages.properties') }}</h4>

                    <div class="form-group mb-4 arabic-direction">
                        <label for="description_ar">{{ __('messages.product_description_ar') }}</label>
                        <textarea name="description_ar" placeholder="{{ __('messages.product_description_ar') }}"
                                  class="form-control" id="description_ar" rows="5">{{$data->description_ar}}</textarea>
                    </div>
                    <div class="form-group mb-4 arabic-direction">
                        <label for="description_en">{{ __('messages.product_description_en') }}</label>
                        <textarea name="description_en" placeholder="{{ __('messages.product_description_en') }}"
                                  class="form-control" id="description_en" rows="5">{{$data->description_en}}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.main_image') }}</label><br>
                        <div class="row">
                            <div class="col-md-2 product_image">
                                <img class="img-thumbnail" style="width:100px;height: 100px;" src="{{ $data->image }}"/>
                            </div>
                        </div>
                        <div class="custom-file-container" data-upload-id="mySecondImage">
                            <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a
                                    href="javascript:void(0)" class="custom-file-container__image-clear"
                                    title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file">
                                <input type="file" name="main_image"
                                       class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview">

                            </div>
                        </div>

                        <label for="">{{ __('messages.current_images') }}</label><br>
                        <div class="row">
                            @foreach ($data->images as $image)
                                <div style="position : relative" class="col-md-2 product_image">
                                    <a onclick="return confirm('{{ __('messages.are_you_sure') }}')"
                                       style="position : absolute; right : 20px"
                                       href="{{ route('productImage.delete', $image->id) }}" class="close">x</a>
                                    <img class="img-thumbnail" style="width:100px;height: 100px;"
                                         src="{{ $image->image }}"/>
                                </div>
                            @endforeach
                        </div>
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
                            <div class="custom-file-container__image-preview">

                            </div>
                        </div>

                    </div>
                    <input type="submit" value="{{ __('messages.edit') }}" class="btn btn-primary">
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
@endsection
