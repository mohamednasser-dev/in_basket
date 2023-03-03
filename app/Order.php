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

    const STATUS = ['new', 'execution', 'arrived', 'rejected', 'accept'];
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
        return $this->belongsTo(User::class, 'user_id');
    }

}
