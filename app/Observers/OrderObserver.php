<?php

namespace App\Observers;

use App\Models\Orders;

class OrderObserver
{
    public function creating(Orders $orders)
    {
        $orders->created_by = isset(auth()->user()->id) ? auth()->user()->id : null;
    }

    public function updating(Orders $orders)
    {
        $orders->updated_by = isset(auth()->user()->id) ? auth()->user()->id : null;
    }
}