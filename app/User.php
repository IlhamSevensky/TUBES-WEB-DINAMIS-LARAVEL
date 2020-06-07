<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Cart;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'address', 'contact_info', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'type'
    ];

    function carts() {
        return $this->hasMany('App\Cart', 'user_id');
    }

    function sales() {
        return $this->hasMany('App\Sale', 'user_id');
    }

    function getAvatar() {

        if (!$this->photo) {
            return asset('assets/images/avatars/default/profile.jpg');
        }

        return asset('assets/images/' . $this->photo);

    }

    function getContact() {

        if(!$this->contact_info) {
            return 'N/a';
        }

        return $this->contact_info;
    }

    function getAddress() {

        if(!$this->address) {
            return 'N/a';
        }

        return $this->address;
    }

    function getUserCartStatus() {

        return Cart::where('user_id', '=', $this->id)->count();

    }

}
