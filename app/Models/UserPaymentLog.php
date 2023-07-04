<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentLog extends Model
{
    protected $fillable = [
        'user_id','user_stripe_id','stripe_response'
    ];

}
