<?php

namespace App\Observers;

use App\Models\Products;

class ProductObserver
{
    public function creating(Products $products)
    {
        $products->created_by = isset(auth()->user()->id) ? auth()->user()->id : null;
    }

    public function updating(Products $products)
    {
        $products->updated_by = auth()->user()->id;
    }
}