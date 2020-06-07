<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    public $timestamps = false;

    protected $guarded = ['id']; 

    function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }

}
