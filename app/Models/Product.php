<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    
    use SoftDeletes;

	protected $fillable = [
    'name','detail','description','category_id','quantity','price','image','brand_id','provider_id' ,'address','latitude','longitude','vendor_type'
	];


	public function category()
    {
		return $this->hasMany('App\Models\Category', 'id', 'category_id');


    }

    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist', 'id', 'product_id');


    }

    public function favoriteproduct()
    {
        return $this->hasMany('App\Models\FavouriteProduct');
    }

}
