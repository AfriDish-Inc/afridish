<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

	protected $fillable = [
        'category_name', 'is_active', 'image'
    ];
	

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
}
