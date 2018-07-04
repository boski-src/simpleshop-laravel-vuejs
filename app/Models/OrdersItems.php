<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class OrdersItems extends Model
{
    protected $table = 'orders_items';
    protected $fillable = ['order_id', 'product_id', 'count', 'price', 'status'];

    public function products() {
        return $this->hasOne('App\Models\Products', 'product_id');
    }
}
