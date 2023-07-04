<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderType extends Model
{
    protected $fillable = [
        'user_id', 'order_type','order_date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
