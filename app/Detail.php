<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['id'];

    public $timestamps = false;

    function sale() {
        return $this->belongsTo('App\Sale', 'sales_id');
    }

    function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
