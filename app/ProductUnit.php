<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    protected $guarded = [''];

    public function Producr() {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
