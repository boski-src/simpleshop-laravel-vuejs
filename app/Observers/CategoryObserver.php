<?php

namespace App\Observers;

use App\Models\Categories;

class CategoryObserver
{
    public function creating(Categories $categories)
    {
        $categories->created_by = isset(auth()->user()->id) ? auth()->user()->id : null;
    }

    public function updating(Categories $categories)
    {
        $categories->updated_by = auth()->user()->id;
    }
}