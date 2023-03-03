<div class="form-group mb-4">
    <label for="title_ar">{{ __('messages.unit_ar') }}</label>
    <input required type="text" name="unit_ar" class="form-control" id="unit_ar"
           placeholder="{{ __('messages.unit_ar') }}" value="{{old('unit_ar',$data->unit_ar ?? '')}}">
</div>
<div class="form-group mb-4">
    <label for="title_en">{{ __('messages.unit_en') }}</label>
    <input required type="text" name="unit_en" class="form-control" id="unit_en"
           placeholder="{{ __('messages.unit_en') }}" value="{{old('unit_en',$data->unit_en ?? '')}}">
</div>
<div class="form-group mb-4">
    <label for="title_en">{{ __('messages.quantity') }}</label>
    <input required type="number" name="quantity" class="form-control" id="quantity" min="0"
           placeholder="{{ __('messages.quantity') }}" value="{{old('quantity',$data->quantity ?? '')}}">
</div>
<div class="form-group mb-4">
    <label for="price">{{ __('messages.price') }}</label>
    <input required type="number" class="form-control" step="any" min="0" id="price" name="price"
           placeholder="{{ __('messages.price') }}" value="{{old('price',$data->price ?? '')}}">
</div>
<div class="form-group mb-4">
    <label for="price">الكمية الحالية في المخزن</label>
    <input required type="number" class="form-control" min="0" id="stock" name="stock"
           placeholder="الكمية الحالية في المخزن" value="{{old('stock',$data->stock ?? '')}}">
</div>
<div class="form-group mb-4">
    <label for="price">كمية التنبية</label>
    <input required type="number" class="form-control" min="0" id="stock_alert" name="stock_alert"
           placeholder="كمية التنبية" value="{{old('stock_alert',$data->stock_alert ?? '')}}">
</div>
