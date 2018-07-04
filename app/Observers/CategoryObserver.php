<?php

namespace App\Observers;

use App\Models\Categories;

class CategoryObserver
{
    public function creating(Categories $categories)
    {
        if (isset(auth()->user()->id)) $categories->created_by = auth()->user()->id;
    }

    public function updating(Categories $categories)
    {
        if (isset(auth()->user()->id)) $categories->updated_by = auth()->user()->id;
    }
}