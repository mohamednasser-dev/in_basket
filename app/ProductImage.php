<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['image', 'product_id', 'product_image'];

    public function getProductImageAttribute()
    {
        if (!empty($this->image)) {
            return asset('uploads/products') . '/' . $this->image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'product_' . time() . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/products/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }
}
