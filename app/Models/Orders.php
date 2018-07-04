<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable = ['hash', 'billing', 'payment_id'];

    public function creator()
    {
        return $this->hasOne('App\User', 'created_by');
    }

    public function editor()
    {
        return $this->hasOne('App\User', 'updated_by');
    }

    public function items() {
        return $this->hasMany('App\Models\OrdersItems', 'order_id');
    }
}
