<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    protected $fillable = [
         'user_id', 'card_no'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
