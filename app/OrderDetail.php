<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['product_id', 'order_id', 'quantity', 'price', 'total', 'unit_ar', 'unit_en'];


    protected $appends = ['unit'];

    public function getUnitAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->unit_ar;
        } else {
            return $this->unit_en;
        }
    }
    public function Product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }


    public function Order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
