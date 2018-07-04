<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use Sluggable;

    protected $table = 'products';
    protected $fillable = ['category_id', 'name', 'description', 'price', 'available'];
    protected $hidden = ['updated_by', 'updated_at', 'created_by'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function creator() {
        $this->hasOne('App\User', 'created_by');
    }

    public function editor() {
        $this->hasOne('App\User', 'updated_by');
    }
}
