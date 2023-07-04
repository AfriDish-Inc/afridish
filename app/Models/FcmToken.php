<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = [
        'user_id', 'fcm_token'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
