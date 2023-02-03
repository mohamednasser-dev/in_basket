<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $guarded = [];

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/ads') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'ads_' . time() . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/ads/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }
}
