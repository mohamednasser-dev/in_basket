<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'notes', 'status', 'user_id',
        'sub_total',
        'shipping',
        'discount',
        'total',
    ];

    public $new = "new";
    public $accept = "accept";
    public $execution = "execution";
    public $arrived = "arrived";
    public $rejected = "rejected";

    public
    function OrderDetails()
    {
        return $this->hasMany('App\OrderDetail', 'order_id', 'id');
    }

    public
    function user()
    {
        return $this->belongsTo('App/User', 'user_id');
    }
}
