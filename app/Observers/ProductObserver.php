<?php

namespace App\Observers;

use App\Models\Products;

class ProductObserver
{
    public function creating(Products $products)
    {
        if (isset(auth()->user()->id)) $products->created_by = auth()->user()->id;
    }

    public function updating(Products $products)
    {
        if (isset(auth()->user()->id)) $products->updated_by = auth()->user()->id;
    }
}