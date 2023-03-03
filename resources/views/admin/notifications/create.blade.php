@extends('admin.app')

@section('title' , __('messages.send_new_notification'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.send_new_notification') }}</h4>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">

                    @csrf
                    {{--            <div class="custom-file-container" data-upload-id="myFirstImage">--}}
                    {{--                <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>--}}
                    {{--                <label class="custom-file-container__custom-file" >--}}
                    {{--                    <input type="file"  name="image" class="custom-file-container__custom-file__custom-file-input" accept="image/*">--}}
                    {{--                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />--}}
                    {{--                    <span class="custom-file-container__custom-file__custom-file-control"></span>--}}
                    {{--                </label>--}}
                    {{--                <div class="custom-file-container__image-preview"></div>--}}
                    {{--            </div>            --}}
                    <div class="form-group mb-4">
                        <label for="title">عنوان الاشعار بالعربية</label>
                        <input required type="text" name="title" class="form-control" id="title"
                               value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="title">عنوان الاشعار بالانجليزية</label>
                        <input required type="text" name="title_en" class="form-control" id="title_en"
                               value="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="body">محتوى الاشعار بالعربية</label>
                        <textarea required name="body" class="form-control" rows="5"
                        ></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="body">محتوى الاشعار بالانجليزية</label>
                        <textarea required name="body_en" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="form-group inside">
                        <label for="users">المستخدم</label>
                        @php $users = \App\User::where('fcm_token', '!=', null)->where('deleted',0)->get(); @endphp
                        <select required class="form-control tagging" name="user_id[]" multiple="multiple" >
                            <option value="all_users">كل المستخدمين</option>
                            @foreach ($users as $row)
                                <option @if( $row->diff_days > 43200 || $row->diff_days == null ) style="background-color: #ff9999;"
                                        @endif
                                        value='{{$row->id}}' @if(request()->user_id == $row->id) selected @endif >
                                    {{$row->name}}  &nbsp;
(
                                    @if($row->diff_days == null)  لم يتم
                                    الطلب @else
                                        {{ $row->last_order ? \Carbon\Carbon::createFromTimeStamp(strtotime($row->last_order->created_at))->diffForHumans() : ''}}
                                    @endif

                                    )
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
                </form>
            </div>
            @endsection
            @section('scripts')
                <script>
                    $(".tagging").select2({
                        tags: true
                    });
                </script>
@endsection
