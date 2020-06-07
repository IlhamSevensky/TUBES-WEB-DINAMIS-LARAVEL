<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    function details() {
        return $this->hasMany('App\Detail', 'sales_id');
    }

}
