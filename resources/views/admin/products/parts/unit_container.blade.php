<div class="row">
    <div class="col-md-3">
        <label for="offer">{{ __('messages.unit_ar') }}</label>
        <input required type="text" class="form-control" min="0" max="100" name="unites[unit_ar][]">
    </div>
    <div class="col-md-3">
        <label for="offer">{{ __('messages.unit_en') }}</label>
        <input required type="text" class="form-control" min="0" max="100" name="unites[unit_en][]">
    </div>
    <div class="col-md-2">
        <label for="offer">{{ __('messages.quantity') }}</label>
        <input required type="number" class="form-control" min="0" max="100" name="unites[quantity][]"
               placeholder="{{ __('messages.quantity') }}" value="0">
    </div>
    <div class="col-md-3">
        <label for="offer">{{ __('messages.price') }}</label>
        <input required type="number" class="form-control" min="0" max="100" name="unites[price][]"
               placeholder="{{ __('messages.price') }}" value="0">
    </div>
    <div class="col-md-1">
        <label for="offer">{{ __('messages.delete') }}</label>
        <a class="form-control btn btn-danger"><i class="fa fa-trash"></i></a>
    </div>
</div>
