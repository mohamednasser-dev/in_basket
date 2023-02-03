<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    protected $dates = ['publication_date'];
    protected $fillable = ['title_ar', 'description_ar', 'title_en', 'description_en', 'price', 'category_id', 'sub_category_id', 'sub_category_two_id', 'expire_special_date',
        'sub_category_three_id', 'sub_category_four_id', 'user_id', 'type', 'publication_date', 're_post_date', 'is_special',
        'views', 'offer', 'status', 'expiry_date', 'main_image', 'expire_pin_date', 'created_at', 'plan_id', 'publish', 'sub_category_five_id',
        'city_id', 'area_id', 'latitude', 'longitude', 'share_location', 'deleted', 'brand_id', 'color_id'];

    protected $appends = ['title', 'description', 'image'];

    public function getTitleAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function getDescriptionAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->description_ar;
        } else {
            return $this->description_en;
        }
    }

    public function Product_category()
    {
        if (session('api_lang') == 'ar') {
            return $this->belongsTo('App\Category', 'category_id')->select('id', 'title_ar as title');
        } else {
            return $this->belongsTo('App\Category', 'category_id')->select('id', 'title_en as title');
        }

    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\SubCategory', 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Product_user()
    {
        return $this->belongsTo('App\User', 'user_id')
            ->select('id', 'image', 'name', 'phone', 'watsapp', 'facebook', 'insta', 'snap_chat', 'youtube', 'twiter');
    }

    public function Plan()
    {
        return $this->belongsTo('App\Plan', 'plan_id');
    }

    public function Brand()
    {
        if (session('api_lang') == 'ar') {
            return $this->belongsTo('App\Marka', 'brand_id')->select('id', 'title_ar as title');
        } else {
            return $this->belongsTo('App\Marka', 'brand_id')->select('id', 'title_en as title');
        }
    }

    public function Brand_web()
    {
        return $this->belongsTo('App\Marka', 'brand_id');

    }

    public function Web_Brand()
    {
        return $this->belongsTo('App\Marka', 'brand_id');
    }

    public function City()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function Area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage', 'product_id');
    }

    public function Colors()
    {
        return $this->hasMany('App\Product_color', 'product_id');
    }

    public function Color()
    {
        return $this->belongsTo('App\Color', 'color_id');
    }

    public function Features()
    {
        return $this->hasMany('App\Product_feature', 'product_id');
    }

    public function Views()
    {
        return $this->hasMany('App\Category_option_value', 'product_id');
    }


    public function getImageAttribute($image)
    {
        if (!empty($this->main_image)) {
            return asset('uploads/products') . '/' . $this->main_image;
        }
        return asset('defaults/default_image.png');
    }

    public function setMainImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'product_' . time() . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/products/'), $img_name);
            $this->attributes['main_image'] = $img_name;
        }
    }

}
