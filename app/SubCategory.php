<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'brand_id', 'category_id'];

    protected $appends = ['title'];

    public function getTitleAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function brand() {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'sub_category_id');
    }


    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/categories') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'category_' . time() . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/categories/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }
}
