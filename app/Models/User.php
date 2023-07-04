<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasRoles;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'first_name' , 'last_name' , 'email', 'password', 'remember_token', 'is_verified', 'mobile_number','user_type',
                          'login_type' , 'user_address', 'is_adult', 'address' , 'latitude', 'longitude' , 'social_id' , 'profile_picture' ,'dob' ,'country_id', 'device_type', 'vendor_category_id'];


    /**
     * Hash password
     * @param $input
     */

    protected $hidden = [
        'updated_at',
    ];
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }

    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function userAddress()
    {
        return $this->hasMany('App\Models\UserAddress');
    }
}
