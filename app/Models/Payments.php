<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'first_name', 'last_name', 'payer_email', 'payer_id', 'payer_status', 'payment_date', 'payment_status',
        'payment_type', 'payment_fee', 'payment_gross', 'address_city', 'address_country', 'address_country_code',
        'address_name', 'address_state', 'address_status', 'address_street', 'address_zip', 'txn_id',
        'txn_type', 'test_ipn', 'verify_sign'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Orders', 'order_id');
    }
}
