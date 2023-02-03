<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['image', 'title_ar', 'title_en', 'deleted', 'shipping_cost'];

    protected $appends = ['title'];

    public function getTitleAttribute()
    {

        if (\app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function Areas()
    {
        if (session('api_lang') == 'en') {
            return $this->hasMany('App\Area', 'city_id', 'id')->where('deleted', '0')
                ->select('id', 'title_en as title', 'city_id');
        } else {
            return $this->hasMany('App\Area', 'city_id', 'id')->where('deleted', '0')
                ->select('id', 'title_ar as title', 'city_id');
        }

    }
}
