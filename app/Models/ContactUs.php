<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'full_name','email','user_query'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
