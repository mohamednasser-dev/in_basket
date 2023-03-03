<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'phone_verified_at',
        'password',
        'fcm_token',
        'verified',
        'remember_token',
        'active',
        'seen',
        'my_wallet',
        'free_balance',
        'payed_balance',
        'watsapp', 'facebook', 'insta', 'snap_chat', 'youtube', 'twiter', 'image',
        'latitude', 'longitude', 'work_time_from', 'work_time_to', 'work_day_from', 'work_day_to', 'jwt', 'code',
        'social_type', 'social_id'

    ];
    use Notifiable;

    protected $appends = ['diff_days'];

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'user_id');
    }

    public function last_order()
    {
        return $this->hasOne('App\Order', 'user_id')->orderBy('created_at', 'desc');
    }


    public function getDiffDaysAttribute()
    {
        if ($this->last_order) {
            $start = Carbon::parse($this->last_order->created_at);
            $now = Carbon::now();
            $days_count = $start->diffInMinutes($now);
            return $days_count;
        } else {
            return null;
        }
    }
}
