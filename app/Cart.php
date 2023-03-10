<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'qty' ,'unit_id'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\ProductUnit', 'unit_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
