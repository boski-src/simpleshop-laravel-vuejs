<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use Sluggable;

    protected $table = 'categories';
    protected $fillable = ['name'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products', 'category_id');
    }
}
