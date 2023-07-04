<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_date','paypal_charge_id','amount','tax','order_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function orderDeliveryAddress()
    {
        return $this->hasOne('App\Models\OrderDeliveryAddress');
    }

    public function items() {
        return $this->hasMany('App\Models\OrderItem');
    }
}
