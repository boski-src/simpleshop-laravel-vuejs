<?php

namespace App\Observers;

use App\Models\Orders;

class OrderObserver
{
    public function creating(Orders $orders)
    {
        if (isset(auth()->user()->id)) $orders->created_by = auth()->user()->id;
    }

    public function updating(Orders $orders)
    {
        if (isset(auth()->user()->id)) $orders->updated_by = auth()->user()->id;
    }
}