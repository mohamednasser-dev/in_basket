<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    protected $guarded = [''];

    public function Producr()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    protected $appends = ['title'];

    public function getTitleAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->unit_ar;
        } else {
            return $this->unit_en;
        }
    }
}
