<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'order_contact_name', 'address', 'user_place_id', 'user_lat', 'user_lng', 'user_mobile_number','city','country','zip_code','email'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
