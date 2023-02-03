<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['image', 'title_en', 'title_ar', 'deleted'];

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id');
    }

    protected $appends = ['title'];

    public function getTitleAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function Sub_categories()
    {
        if (session('api_lang') == 'en') {
            return $this->hasMany('App\SubCategory', 'category_id', 'id')->where('deleted', 0)
                ->select('id', 'title_en as title', 'image', 'category_id');
        } else {
            return $this->hasMany('App\SubCategory', 'category_id', 'id')->where('deleted', 0)
                ->select('id', 'title_ar as title', 'image', 'category_id');
        }

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
