<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['category_id'];

    public $timestamps = false;

    function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    function carts() {
        return $this->hasMany('App\Cart', 'product_id');
    }

    function detail() {
        return $this->hasMany('App\Detail', 'product_id');
    }

    function image() {

        if (!$this->photo) {
            return asset('assets/images/products/default/noimage.jpg');
        }

        return asset('assets/images/products/' . $this->photo);

    }

    function number_format_price() {
        return number_format($this->price);
    }

}
